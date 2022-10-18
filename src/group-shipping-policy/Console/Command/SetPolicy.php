<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicy\Console\Command;

use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Directory\Model\Country;
use Magento\Directory\Model\CountryFactory;
use Magento\Directory\Model\ResourceModel\Country as CountryResource;
use Magento\Framework\Api\SearchCriteriaBuilder;
use SwiftOtter\GroupShippingPolicy\Api\Data\GroupShippingPolicyInterface;
use SwiftOtter\GroupShippingPolicy\Api\Data\GroupShippingPolicyInterfaceFactory;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCountryInterface;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCountryInterfaceFactory;
use SwiftOtter\GroupShippingPolicy\Api\GroupShippingPolicyRepositoryInterface;
use SwiftOtter\GroupShippingPolicy\Api\PolicyCountryRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class SetPolicy extends Command
{
    const ARG_GROUP_ID = 'customer-group-id';
    const OPT_TITLE = 'title';
    const OPT_DESC = 'description';
    const OPT_COUNTRIES = 'countries';

    private GroupRepositoryInterface $customerGroupRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private GroupShippingPolicyRepositoryInterface $policyRepository;
    private PolicyCountryRepositoryInterface $policyCountryRepository;
    private GroupShippingPolicyInterfaceFactory $policyFactory;
    private CountryFactory $countryFactory;
    private CountryResource $countryResource;
    private PolicyCountryInterfaceFactory $policyCountryFactory;

    public function __construct(
        GroupRepositoryInterface $customerGroupRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        GroupShippingPolicyRepositoryInterface $policyRepository,
        PolicyCountryRepositoryInterface $policyCountryRepository,
        GroupShippingPolicyInterfaceFactory $policyFactory,
        CountryFactory $countryFactory,
        CountryResource $countryResource,
        PolicyCountryInterfaceFactory $policyCountryFactory,
        string $name = null
    ) {
        parent::__construct($name);
        $this->customerGroupRepository = $customerGroupRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->policyRepository = $policyRepository;
        $this->policyCountryRepository = $policyCountryRepository;
        $this->policyFactory = $policyFactory;
        $this->countryFactory = $countryFactory;
        $this->countryResource = $countryResource;
        $this->policyCountryFactory = $policyCountryFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('group-ship-policy:set-policy');
        $this->setDescription('Add/update the shipping policy for a customer group');
        $this->addArgument(self::ARG_GROUP_ID, InputArgument::REQUIRED, 'Customer group ID');
        $this->addOption(self::OPT_TITLE, null, InputOption::VALUE_REQUIRED, 'Policy title');
        $this->addOption(self::OPT_DESC, null, InputOption::VALUE_OPTIONAL, 'Policy description', '');
        $this->addOption(self::OPT_COUNTRIES, null, InputOption::VALUE_OPTIONAL, 'Comma-delimited list of country IDs', '');
        parent::configure();
    }

    /**
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $customerGroupId = (int) $input->getArgument(self::ARG_GROUP_ID);
        $title = (string) $input->getOption(self::OPT_TITLE);
        $description = (string) $input->getOption(self::OPT_DESC);

        $countriesStr = (string) $input->getOption(self::OPT_COUNTRIES);
        $countries = (!empty($countriesStr)) ? explode(',', $countriesStr) : [];

        // Verify customer group exists
        $this->customerGroupRepository->getById($customerGroupId);

        // Verify countries exist
        foreach ($countries as $country) {
            /** @var Country $countryModel */
            $countryModel = $this->countryFactory->create();
            $this->countryResource->load($countryModel, $country);
            if (!$countryModel->getId()) {
                throw new \Exception('Invalid country');
            }
        }

        // Get existing policy
        $this->searchCriteriaBuilder->addFilter('customer_group_id', $customerGroupId);
        $policies = $this->policyRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        if (!empty($policies)) {
            /** @var GroupShippingPolicyInterface $policy */
            $policy = current($policies);
            $this->searchCriteriaBuilder->addFilter('policy_id', $policy->getId());
            $existingCountries = $this->policyCountryRepository->getList($this->searchCriteriaBuilder->create())->getItems();
            foreach ($existingCountries as $existingCountry) {
                $this->policyCountryRepository->delete($existingCountry);
            }
        } else {
            /** @var GroupShippingPolicyInterface $policy */
            $policy = $this->policyFactory->create();
        }

        // Save main details
        $policy->setCustomerGroupId($customerGroupId);
        $policy->setTitle($title);
        if (!empty($description)) {
            $policy->setDescription($description);
        }
        $this->policyRepository->save($policy);

        // Save countries
        foreach ($countries as $country) {
            /** @var PolicyCountryInterface $policyCountry */
            $policyCountry = $this->policyCountryFactory->create();
            $policyCountry->setPolicyId((int) $policy->getId());
            $policyCountry->setCountryId($country);
            $this->policyCountryRepository->save($policyCountry);
        }

        return 0;
    }
}

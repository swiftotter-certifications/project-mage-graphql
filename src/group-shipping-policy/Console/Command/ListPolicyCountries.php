<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicy\Console\Command;

use Magento\Framework\Api\SearchCriteriaBuilder;
use SwiftOtter\GroupShippingPolicy\Api\PolicyCountryRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListPolicyCountries extends Command
{
    private PolicyCountryRepositoryInterface $policyCountryRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        PolicyCountryRepositoryInterface $policyCountryRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        string $name = null
    ) {
        parent::__construct($name);
        $this->policyCountryRepository = $policyCountryRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('group-ship-policy:list-countries');
        $this->setDescription('Lists all group shipping policy countries');
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $countries = $this->policyCountryRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        foreach ($countries as $country) {
            $output->writeln(print_r($country->getData(), true));
        }

        return 0;
    }
}

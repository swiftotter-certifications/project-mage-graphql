<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver\DataProvider\ShippingPolicies;

use Magento\Directory\Model\Country;
use Magento\Directory\Model\ResourceModel\Country\Collection as CountryCollection;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory as CountryCollectionFactory;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCountryInterface;
use SwiftOtter\GroupShippingPolicy\Api\PolicyCountryRepositoryInterface;

class Countries
{
    const COUNTRY_FORMAT_NAME = 'NAME';
    const COUNTRY_FORMAT_ISO2 = 'ISO2';
    const COUNTRY_FORMAT_ISO3 = 'ISO3';

    private array $policyIds = [];
    private array $policyCountries = [];
    private array $validFormats = [
        self::COUNTRY_FORMAT_NAME,
        self::COUNTRY_FORMAT_ISO2,
        self::COUNTRY_FORMAT_ISO3,
    ];
    private PolicyCountryRepositoryInterface $policyCountryRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    private CountryCollectionFactory $countryCollectionFactory;

    public function __construct(
        PolicyCountryRepositoryInterface $policyCountryRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CountryCollectionFactory $countryCollectionFactory
    ) {
        $this->policyCountryRepository = $policyCountryRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->countryCollectionFactory = $countryCollectionFactory;
    }

    public function addPolicyIdFilter(int $policyId): Countries
    {
        $this->policyIds[] = $policyId;
        return $this;
    }

    /**
     * @throws GraphQlInputException
     */
    public function getAllPolicyCountries(?string $format): array
    {
        if ($format !== null && !in_array($format, $this->validFormats)) {
            throw new GraphQlInputException(__('Invalid country format'));
        }

        if ($format === null) {
            $format = self::COUNTRY_FORMAT_NAME;
        }

        // Check if already loaded
        if (!isset($this->policyCountries[$format])) {
            // Load policy/country models
            $policyCountries = $this->getFilteredPolicyCountries();

            // Load all relevant country models
            $countryIds = [];
            foreach ($policyCountries as $policyCountry) {
                $countryIds[] = $policyCountry->getCountryId();
            }
            $countryIds = array_unique($countryIds);
            /** @var CountryCollection $countriesCollection */
            $countriesCollection = $this->countryCollectionFactory->create();
            /** @var Country[] $countries */
            $countries = $countriesCollection->addFieldToFilter('country_id', ['in' => $countryIds])->getItems();

            // Store formatted data for each policy/country record
            $this->policyCountries[$format] = [];
            foreach ($policyCountries as $policyCountry) {
                if (!isset($countries[$policyCountry->getCountryId()])) {
                    continue;
                }

                $this->policyCountries[$format][] = $this->formatPolicyCountryData(
                    $policyCountry,
                    $countries[$policyCountry->getCountryId()],
                    $format
                );
            }
        }
        return $this->policyCountries[$format];
    }

    /**
     * @return PolicyCountryInterface[]
     */
    private function getFilteredPolicyCountries(): array
    {
        if (empty($this->policyIds)) {
            return [];
        }

        $policyIds = array_unique($this->policyIds);
        $this->searchCriteriaBuilder->addFilter('policy_id', $policyIds, 'in');
        return $this->policyCountryRepository->getList($this->searchCriteriaBuilder->create())->getItems();
    }

    private function formatPolicyCountryData(
        PolicyCountryInterface $policyCountry,
        Country $country,
        ?string $format
    ) {
        switch ($format) {
            case self::COUNTRY_FORMAT_ISO2:
                $label = $country->getData('iso2_code');
                break;

            case self::COUNTRY_FORMAT_ISO3:
                $label = $country->getData('iso3_code');
                break;

            default:
                $label = $country->getName();
        }

        return [
            'policy_id' => $policyCountry->getPolicyId(),
            'country' => $label,
        ];
    }
}

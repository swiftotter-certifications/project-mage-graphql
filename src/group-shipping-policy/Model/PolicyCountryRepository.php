<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicy\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCountryInterface;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCountryInterfaceFactory;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCountrySearchResultsInterface;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCountrySearchResultsInterfaceFactory;
use SwiftOtter\GroupShippingPolicy\Api\PolicyCountryRepositoryInterface;
use SwiftOtter\GroupShippingPolicy\Model\ResourceModel\PolicyCountry as PolicyCountryResource;
use SwiftOtter\GroupShippingPolicy\Model\ResourceModel\PolicyCountry\Collection as PolicyCountryCollection;
use SwiftOtter\GroupShippingPolicy\Model\ResourceModel\PolicyCountry\CollectionFactory as PolicyCountryCollectionFactory;

class PolicyCountryRepository implements PolicyCountryRepositoryInterface
{
    private PolicyCountryInterfaceFactory $policyCountryFactory;
    private PolicyCountryResource $policyCountryResource;
    private PolicyCountryCollectionFactory $policyCountryCollectionFactory;
    private CollectionProcessorInterface $collectionProcessor;
    private PolicyCountrySearchResultsInterfaceFactory $policyCountryResultsFactory;

    public function __construct(
        PolicyCountryInterfaceFactory $policyCountryFactory,
        PolicyCountryResource $policyCountryResource,
        PolicyCountryCollectionFactory $policyCountryCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        PolicyCountrySearchResultsInterfaceFactory $policyCountryResultsFactory
    ) {
        $this->policyCountryFactory = $policyCountryFactory;
        $this->policyCountryResource = $policyCountryResource;
        $this->policyCountryCollectionFactory = $policyCountryCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->policyCountryResultsFactory = $policyCountryResultsFactory;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getById(int $id): PolicyCountryInterface
    {
        /** @var PolicyCountryInterface $policy */
        $policyCountry = $this->policyCountryFactory->create();
        $this->policyCountryResource->load($policyCountry, $id);
        if (!$policy->getId()) {
            throw new NoSuchEntityException(__('No such record'));
        }
        return $policy;
    }

    public function getList(SearchCriteriaInterface $searchCriteria): PolicyCountrySearchResultsInterface
    {
        /** @var PolicyCountryCollection $policies */
        $policyCountries = $this->policyCountryCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $policyCountries);

        /** @var PolicyCountrySearchResultsInterface $results */
        $results = $this->policyCountryResultsFactory->create();
        $results->setSearchCriteria($searchCriteria);
        $results->setItems($policyCountries->getItems());
        $results->setTotalCount($policyCountries->getSize());
        return $results;
    }

    /**
     * @throws CouldNotSaveException
     */
    public function save(PolicyCountryInterface $policyCountry): PolicyCountryInterface
    {
        try {
            $this->policyCountryResource->save($policyCountry);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $policyCountry;
    }

    /**
     * @throws CouldNotDeleteException
     */
    public function delete(PolicyCountryInterface $policyCountry): bool
    {
        try {
            $this->policyCountryResource->delete($policyCountry);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return true;
    }
}

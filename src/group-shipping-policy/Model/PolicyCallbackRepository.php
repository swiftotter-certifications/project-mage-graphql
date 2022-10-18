<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicy\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCallbackInterface;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCallbackInterfaceFactory;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCallbackSearchResultsInterface;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCallbackSearchResultsInterfaceFactory;
use SwiftOtter\GroupShippingPolicy\Api\PolicyCallbackRepositoryInterface;
use SwiftOtter\GroupShippingPolicy\Model\ResourceModel\PolicyCallback as PolicyCallbackResource;
use SwiftOtter\GroupShippingPolicy\Model\ResourceModel\PolicyCallback\Collection as PolicyCallbackCollection;
use SwiftOtter\GroupShippingPolicy\Model\ResourceModel\PolicyCallback\CollectionFactory as PolicyCallbackCollectionFactory;

class PolicyCallbackRepository implements PolicyCallbackRepositoryInterface
{
    private PolicyCallbackInterfaceFactory $callbackFactory;
    private PolicyCallbackResource $callbackResource;
    private PolicyCallbackCollectionFactory $callbackCollectionFactory;
    private CollectionProcessorInterface $collectionProcessor;
    private PolicyCallbackSearchResultsInterfaceFactory $callbackResultsFactory;

    public function __construct(
        PolicyCallbackInterfaceFactory $callbackFactory,
        PolicyCallbackResource $callbackResource,
        PolicyCallbackCollectionFactory $callbackCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        PolicyCallbackSearchResultsInterfaceFactory $callbackResultsFactory
    ) {
        $this->callbackFactory = $callbackFactory;
        $this->callbackResource = $callbackResource;
        $this->callbackCollectionFactory = $callbackCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->callbackResultsFactory = $callbackResultsFactory;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getById(int $id): PolicyCallbackInterface
    {
        /** @var PolicyCallbackInterface $policy */
        $callback = $this->callbackFactory->create();
        $this->callbackResource->load($callback, $id);
        if (!$callback->getId()) {
            throw new NoSuchEntityException(__('No such record'));
        }
        return $callback;
    }

    public function getList(SearchCriteriaInterface $searchCriteria): PolicyCallbackSearchResultsInterface
    {
        /** @var PolicyCallbackCollection $callbacks */
        $callbacks = $this->callbackCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $callbacks);

        /** @var PolicyCallbackSearchResultsInterface $results */
        $results = $this->callbackResultsFactory->create();
        $results->setSearchCriteria($searchCriteria);
        $results->setItems($callbacks->getItems());
        $results->setTotalCount($callbacks->getSize());
        return $results;
    }

    /**
     * @throws CouldNotSaveException
     */
    public function save(PolicyCallbackInterface $callback): PolicyCallbackInterface
    {
        try {
            $this->callbackResource->save($callback);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $callback;
    }

    /**
     * @throws CouldNotDeleteException
     */
    public function delete(PolicyCallbackInterface $callback): bool
    {
        try {
            $this->callbackResource->delete($callback);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return true;
    }
}

<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\GroupShippingPolicy\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use SwiftOtter\GroupShippingPolicy\Api\Data\GroupShippingPolicyInterface;
use SwiftOtter\GroupShippingPolicy\Api\Data\GroupShippingPolicyInterfaceFactory;
use SwiftOtter\GroupShippingPolicy\Api\Data\GroupShippingPolicySearchResultsInterface;
use SwiftOtter\GroupShippingPolicy\Api\Data\GroupShippingPolicySearchResultsInterfaceFactory;
use SwiftOtter\GroupShippingPolicy\Api\GroupShippingPolicyRepositoryInterface;
use SwiftOtter\GroupShippingPolicy\Model\ResourceModel\GroupShippingPolicy as GroupShippingPolicyResource;
use SwiftOtter\GroupShippingPolicy\Model\ResourceModel\GroupShippingPolicy\Collection as GroupShippingPolicyCollection;
use SwiftOtter\GroupShippingPolicy\Model\ResourceModel\GroupShippingPolicy\CollectionFactory as GroupShippingPolicyCollectionFactory;

class GroupShippingPolicyRepository implements GroupShippingPolicyRepositoryInterface
{
    private GroupShippingPolicyResource $policyResource;
    private GroupShippingPolicyInterfaceFactory $policyFactory;
    private CollectionProcessorInterface $collectionProcessor;
    private GroupShippingPolicyCollectionFactory $policyCollectionFactory;
    private GroupShippingPolicySearchResultsInterfaceFactory $policySearchResultsFactory;

    public function __construct(
        GroupShippingPolicyResource $policyResource,
        GroupShippingPolicyInterfaceFactory $policyFactory,
        CollectionProcessorInterface $collectionProcessor,
        GroupShippingPolicyCollectionFactory $policyCollectionFactory,
        GroupShippingPolicySearchResultsInterfaceFactory $policySearchResultsFactory
    ) {
        $this->policyResource = $policyResource;
        $this->policyFactory = $policyFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->policyCollectionFactory = $policyCollectionFactory;
        $this->policySearchResultsFactory = $policySearchResultsFactory;
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getById(int $id): GroupShippingPolicyInterface
    {
        /** @var GroupShippingPolicyInterface $policy */
        $policy = $this->policyFactory->create();
        $this->policyResource->load($policy, $id);
        if (!$policy->getId()) {
            throw new NoSuchEntityException(__('No such policy'));
        }
        return $policy;
    }

    public function getList(SearchCriteriaInterface $searchCriteria): GroupShippingPolicySearchResultsInterface
    {
        /** @var GroupShippingPolicyCollection $policies */
        $policies = $this->policyCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $policies);

        /** @var GroupShippingPolicySearchResultsInterface $results */
        $results = $this->policySearchResultsFactory->create();
        $results->setSearchCriteria($searchCriteria);
        $results->setItems($policies->getItems());
        $results->setTotalCount($policies->getSize());
        return $results;
    }

    /**
     * @throws CouldNotSaveException
     */
    public function save(GroupShippingPolicyInterface $policy): GroupShippingPolicyInterface
    {
        try {
            $this->policyResource->save($policy);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }
        return $policy;
    }

    /**
     * @throws CouldNotDeleteException
     */
    public function delete(GroupShippingPolicyInterface $policy): bool
    {
        try {
            $this->policyResource->delete($policy);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }
        return true;
    }
}

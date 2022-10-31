<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver\DataProvider;

use Magento\Customer\Model\Data\Group;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use SwiftOtter\GroupShippingPolicy\Api\Data\GroupShippingPolicyInterface;
use SwiftOtter\GroupShippingPolicy\Api\GroupShippingPolicyRepositoryInterface;

class ShippingPolicies
{
    private GroupShippingPolicyRepositoryInterface $policyRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        GroupShippingPolicyRepositoryInterface $policyRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->policyRepository = $policyRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function getAllPolicies()
    {
        $policies = $this->policyRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        $policyData = [];
        foreach ($policies as $policy) {
            $policyData[] = $this->formatPolicyData($policy);
        }
        return $policyData;
    }

    /**
     * @throws GraphQlNoSuchEntityException
     */
    public function getCustomerGroupPolicy(?int $customerGroupId): array
    {
        if ($customerGroupId === null) {
            // "Not Logged In" group if there's no authenticated customer
            $customerGroupId = Group::NOT_LOGGED_IN_ID;
        }

        $this->searchCriteriaBuilder->addFilter('customer_group_id', $customerGroupId);
        $policies = $this->policyRepository->getList($this->searchCriteriaBuilder->create())->getItems();

        if (empty($policies)) {
            throw new GraphQlNoSuchEntityException(__('No shipping policy for this user'));
        }

        return $this->formatPolicyData(current($policies));
    }

    private function formatPolicyData(GroupShippingPolicyInterface $policy)
    {
        return [
            'id' => (int) $policy->getId(),
            'customer_group_id' => $policy->getCustomerGroupId(),
            'title' => $policy->getTitle(),
            'description' => $policy->getDescription(),
        ];
    }
}

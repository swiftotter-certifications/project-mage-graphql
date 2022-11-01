<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver\DataProvider;

use Magento\Framework\Api\SearchCriteriaBuilder;
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

    private function formatPolicyData(GroupShippingPolicyInterface $policy)
    {
        return [
            'customer_group_id' => $policy->getCustomerGroupId(),
            'title' => $policy->getTitle(),
            'description' => $policy->getDescription(),
            'country_labels' => [], // TODO Remove once dedicated countries resolver is in place
        ];
    }
}

<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver\DataProvider;

use Magento\Framework\Api\SearchCriteriaBuilder;
use SwiftOtter\GroupShippingPolicy\Api\Data\GroupShippingPolicyInterface;
use SwiftOtter\GroupShippingPolicy\Api\GroupShippingPolicyRepositoryInterface;

class ShippingPolicies
{
    private GroupShippingPolicyRepositoryInterface $shippingPolicyRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        GroupShippingPolicyRepositoryInterface $shippingPolicyRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->shippingPolicyRepository = $shippingPolicyRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function getAllPolicies(): array
    {
        $policies = $this->shippingPolicyRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        $policyData = [];
        foreach ($policies as $policy) {
            $policyData[] = $this->formatPolicyData($policy);
        }

        return $policyData;
    }

    private function formatPolicyData(GroupShippingPolicyInterface $policy): array
    {
        return [
            'id' => $policy->getId(),
            'customer_group_id' => $policy->getCustomerGroupId(),
            'title' => $policy->getTitle(),
            'description' => $policy->getDescription(),
        ];
    }
}

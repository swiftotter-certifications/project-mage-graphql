<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver\Service;

use Magento\Customer\Model\Group;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use SwiftOtter\GroupShippingPolicy\Api\Data\GroupShippingPolicyInterface;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCallbackInterface;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCallbackInterfaceFactory;
use SwiftOtter\GroupShippingPolicy\Api\GroupShippingPolicyRepositoryInterface;
use SwiftOtter\GroupShippingPolicy\Api\PolicyCallbackRepositoryInterface;

class CreateShippingPolicyCallback
{
    private PolicyCallbackInterfaceFactory $policyCallbackFactory;
    private PolicyCallbackRepositoryInterface $policyCallbackRepository;
    private GroupShippingPolicyRepositoryInterface $policyRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        PolicyCallbackInterfaceFactory $policyCallbackFactory,
        PolicyCallbackRepositoryInterface $policyCallbackRepository,
        GroupShippingPolicyRepositoryInterface $policyRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->policyCallbackFactory = $policyCallbackFactory;
        $this->policyCallbackRepository = $policyCallbackRepository;
        $this->policyRepository = $policyRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @throws GraphQlNoSuchEntityException
     * @throws CouldNotSaveException
     */
    public function execute(?int $customerGroupId, string $phone): array
    {
        $policy = $this->getShippingPolicy($customerGroupId);
        $callback = $this->policyCallbackFactory->create();
        $callback->setPolicyId((int) $policy->getId())
            ->setPhone($phone);

        $savedCallback = $this->policyCallbackRepository->save($callback);

        return $this->formatCallbackData($savedCallback, $policy);
    }

    /**
     * @throws GraphQlNoSuchEntityException
     */
    private function getShippingPolicy(?int $customerGroupId): GroupShippingPolicyInterface
    {
        if ($customerGroupId === null) {
            $customerGroupId = Group::NOT_LOGGED_IN_ID;
        }

        $this->searchCriteriaBuilder->addFilter('customer_group_id', $customerGroupId);
        $policies = $this->policyRepository->getList($this->searchCriteriaBuilder->create())->getItems();

        if (empty($policies)) {
            throw new GraphQlNoSuchEntityException(__('No shipping policy associated with this user'));
        }
        return current($policies);
    }

    private function formatCallbackData(
        PolicyCallbackInterface $callback,
        GroupShippingPolicyInterface $policy
    ): array {
        $createdAt = $callback->getCreatedAt();

        return [
            'policy_title' => $policy->getTitle(),
            'phone' => $callback->getPhone(),
            'created_at' => ($createdAt !== null) ? $createdAt->format('Y-m-d H:i:s') : null,
        ];
    }
}

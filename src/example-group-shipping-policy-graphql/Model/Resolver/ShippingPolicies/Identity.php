<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver\ShippingPolicies;

use Magento\Framework\GraphQl\Query\Resolver\IdentityInterface;
use SwiftOtter\GroupShippingPolicy\Model\GroupShippingPolicy;

class Identity implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public function getIdentities(array $resolvedData): array
    {
        $ids = [];
        foreach ($resolvedData as $policyData) {
            if (isset($policyData['id'])) {
                $ids[] = GroupShippingPolicy::CACHE_TAG . '_' . $policyData['id'];
            }
        }
        return $ids;
    }
}

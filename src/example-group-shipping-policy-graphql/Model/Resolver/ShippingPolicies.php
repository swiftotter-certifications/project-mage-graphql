<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver\DataProvider\ShippingPolicies as ShippingPoliciesProvider;

class ShippingPolicies implements ResolverInterface
{
    private ShippingPoliciesProvider $policiesProvider;

    public function __construct(
        ShippingPoliciesProvider $policiesProvider
    ) {
        $this->policiesProvider = $policiesProvider;
    }

    /**
     * {@inheridoc}
     * @throws \Exception
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        // TODO Remove
        if (isset($args['all']) && $args['all'] === false) {
            throw new \Exception('Resolution of customer-specific policy not supported yet');
        }

        $includeAll = $args['all'] ?? true;

        if ($includeAll) {
            return $this->policiesProvider->getAllPolicies();
        } else {
            // TODO Fetch one policy for current customer context
        }
    }
}

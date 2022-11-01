<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\GraphQl\Model\Query\ContextInterface;
use SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver\DataProvider\ShippingPolicies as  ShippingPoliciesProvider;

class ShippingPolicies implements ResolverInterface
{
    private ShippingPoliciesProvider $policiesProvider;

    public function __construct(
        ShippingPoliciesProvider $policiesProvider
    ) {
        $this->policiesProvider = $policiesProvider;
    }

    /**
     * {@inheritdoc}
     * @param ContextInterface @context
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $includeAll = $args['all'] ?? true;

        // TODO Remove
        if (!$includeAll) {
            throw new \Exception('No support for context-specific policy at this time');
        }

        if ($includeAll) {
            return $this->policiesProvider->getAllPolicies();
        } else {
            // TODO Implement customer-specific logic
        }
    }
}

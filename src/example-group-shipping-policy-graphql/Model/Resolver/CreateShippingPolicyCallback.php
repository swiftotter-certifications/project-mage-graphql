<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\GraphQl\Model\Query\ContextExtensionInterface;
use Magento\GraphQl\Model\Query\ContextInterface;
use SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver\Service\CreateShippingPolicyCallback as CreateCallbackService;

class CreateShippingPolicyCallback implements ResolverInterface
{
    private CreateCallbackService $createCallbackService;

    public function __construct(
        CreateCallbackService $createCallbackService
    ) {
        $this->createCallbackService = $createCallbackService;
    }

    /**
     * {@inheritdoc}
     * @param ContextInterface $context
     * @throws GraphQlNoSuchEntityException
     * @throws CouldNotSaveException
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!isset($args['phone'])) {
            throw new GraphQlInputException(__('Phone number is required for shipping policy callback'));
        }

        $phone = $args['phone'];
        /** @var ContextExtensionInterface $contextExt */
        $contextExt = $context->getExtensionAttributes();
        $customerGroupId = $contextExt->getCustomerGroupId();

        if ($customerGroupId !== null) {
            $customerGroupId = (int) $customerGroupId;
        }

        return $this->createCallbackService->execute($customerGroupId, $phone);
    }
}

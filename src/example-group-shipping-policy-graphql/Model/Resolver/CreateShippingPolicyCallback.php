<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\GraphQl\Model\Query\ContextInterface;
use SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver\Service\CreateShippingPolicyCallback as CreateShippingPolicyCallbackService;

class CreateShippingPolicyCallback implements ResolverInterface
{
    private CreateShippingPolicyCallbackService $createCallbackService;

    public function __construct(
        CreateShippingPolicyCallbackService $createCallbackService
    ) {
        $this->createCallbackService = $createCallbackService;
    }

    /**
     * {@inheritdoc}
     * @param ContextInterface $context
     * @throws GraphQlInputException
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
            throw new GraphQlInputException(__('Phone number is required to register a callback'));
        }

        $phone = $args['phone'];
        $contextExt = $context->getExtensionAttributes();
        $customerGroupId = $contextExt->getCustomerGroupId();

        if ($customerGroupId !== null) {
            $customerGroupId = (int) $customerGroupId;
        }

        return $this->createCallbackService->execute($customerGroupId, $phone);
    }
}

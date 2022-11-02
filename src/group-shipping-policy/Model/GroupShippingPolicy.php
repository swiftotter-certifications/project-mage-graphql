<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\GroupShippingPolicy\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use SwiftOtter\GroupShippingPolicy\Api\Data\GroupShippingPolicyInterface;
use SwiftOtter\GroupShippingPolicy\Model\ResourceModel\GroupShippingPolicy as GroupShippingPolicyResource;

class GroupShippingPolicy extends AbstractModel implements GroupShippingPolicyInterface, IdentityInterface
{
    const CACHE_TAG = 'gsp';

    protected function _construct()
    {
        $this->_init(GroupShippingPolicyResource::class);
    }

    public function getCustomerGroupId(): int
    {
        return (int) $this->_getData('customer_group_id');
    }

    public function setCustomerGroupId(int $id): GroupShippingPolicyInterface
    {
        return $this->setData('customer_group_id', $id);
    }

    public function getTitle(): string
    {
        return (string) $this->_getData('title');
    }

    public function setTitle(string $title): GroupShippingPolicyInterface
    {
        return $this->setData('title', $title);
    }

    public function getDescription(): string
    {
        return (string) $this->_getData('description');
    }

    public function setDescription(string $description): GroupShippingPolicyInterface
    {
        return $this->setData('description', $description);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}

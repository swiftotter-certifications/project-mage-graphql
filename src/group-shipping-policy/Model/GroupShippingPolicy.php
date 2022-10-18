<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicy\Model;

use Magento\Framework\Model\AbstractModel;
use SwiftOtter\GroupShippingPolicy\Api\Data\GroupShippingPolicyInterface;
use SwiftOtter\GroupShippingPolicy\Model\ResourceModel\GroupShippingPolicy as GroupShippingPolicyResource;

class GroupShippingPolicy extends AbstractModel implements GroupShippingPolicyInterface
{
    protected function _construct()
    {
        $this->_init(GroupShippingPolicyResource::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return (int) $this->_getData('id');
    }

    /**
     * {@inheritdoc}
     */
    public function setId($value)
    {
        return $this->setData('id', $value);
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
}

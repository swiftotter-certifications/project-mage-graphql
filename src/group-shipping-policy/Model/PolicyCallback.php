<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\GroupShippingPolicy\Model;

use Magento\Framework\Model\AbstractModel;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCallbackInterface;
use SwiftOtter\GroupShippingPolicy\Model\ResourceModel\PolicyCallback as PolicyCallbackResource;

class PolicyCallback extends AbstractModel implements PolicyCallbackInterface
{
    protected function _construct()
    {
        $this->_init(PolicyCallbackResource::class);
    }

    public function getPolicyId(): int
    {
        return (int) $this->_getData('policy_id');
    }

    public function setPolicyId(int $id): PolicyCallbackInterface
    {
        return $this->setData('policy_id', $id);
    }

    public function getPhone(): string
    {
        return (string) $this->_getData('phone');
    }

    public function setPhone(string $phone): PolicyCallbackInterface
    {
        return $this->setData('phone', $phone);
    }

    public function getCreatedAt(): ?\DateTime
    {
        $dateStr = $this->_getData('created_at');
        return ($dateStr) ? new \DateTime($dateStr) : null;
    }

    public function setCreatedAt(\DateTime $createdAt): PolicyCallbackInterface
    {
        return $this->setData('created_at', $createdAt->format('Y-m-d H:i:s'));
    }

    public function hasBeenCalled(): bool
    {
        return $this->_getData('called');
    }

    public function setHasBeenCalled(bool $called): PolicyCallbackInterface
    {
        return $this->setData('called', $called);
    }
}

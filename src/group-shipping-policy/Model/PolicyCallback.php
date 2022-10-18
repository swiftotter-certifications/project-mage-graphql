<?php
declare(strict_types=1);

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
}

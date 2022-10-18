<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicy\Model\ResourceModel\GroupShippingPolicy;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SwiftOtter\GroupShippingPolicy\Model\GroupShippingPolicy;
use SwiftOtter\GroupShippingPolicy\Model\ResourceModel\GroupShippingPolicy as GroupShippingPolicyResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(GroupShippingPolicy::class, GroupShippingPolicyResource::class);
    }
}

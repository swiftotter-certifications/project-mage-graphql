<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicy\Model\ResourceModel\PolicyCallback;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SwiftOtter\GroupShippingPolicy\Model\PolicyCallback;
use SwiftOtter\GroupShippingPolicy\Model\ResourceModel\PolicyCallback as PolicyCallbackResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(PolicyCallback::class, PolicyCallbackResource::class);
    }
}

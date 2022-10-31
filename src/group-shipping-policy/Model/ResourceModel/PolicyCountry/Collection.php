<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\GroupShippingPolicy\Model\ResourceModel\PolicyCountry;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SwiftOtter\GroupShippingPolicy\Model\PolicyCountry;
use SwiftOtter\GroupShippingPolicy\Model\ResourceModel\PolicyCountry as PolicyCountryResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(PolicyCountry::class, PolicyCountryResource::class);
    }
}

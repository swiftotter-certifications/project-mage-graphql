<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\GroupShippingPolicy\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PolicyCallback extends AbstractDb
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('group_shipping_policy_callback_queue', 'id');
    }
}

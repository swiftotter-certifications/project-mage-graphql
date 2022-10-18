<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicy\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class GroupShippingPolicy extends AbstractDb
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('group_shipping_policy', 'id');
    }
}

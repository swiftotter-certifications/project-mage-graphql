<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\GroupShippingPolicy\Model;

use Magento\Framework\Model\AbstractModel;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCountryInterface;
use SwiftOtter\GroupShippingPolicy\Model\ResourceModel\PolicyCountry as PolicyCountryResource;

class PolicyCountry extends AbstractModel implements PolicyCountryInterface
{
    protected function _construct()
    {
        $this->_init(PolicyCountryResource::class);
    }

    public function getPolicyId(): int
    {
        return (int) $this->_getData('policy_id');
    }

    public function setPolicyId(int $id): PolicyCountryInterface
    {
        return $this->setData('policy_id', $id);
    }

    public function getCountryId(): string
    {
        return (string) $this->_getData('country_id');
    }

    public function setCountryId(string $id): PolicyCountryInterface
    {
        return $this->setData('country_id', $id);
    }
}

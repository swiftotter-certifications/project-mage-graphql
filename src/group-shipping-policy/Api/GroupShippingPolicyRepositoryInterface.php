<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\GroupShippingPolicy\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use SwiftOtter\GroupShippingPolicy\Api\Data\GroupShippingPolicyInterface;
use SwiftOtter\GroupShippingPolicy\Api\Data\GroupShippingPolicySearchResultsInterface;

interface GroupShippingPolicyRepositoryInterface
{
    public function getById(int $id): GroupShippingPolicyInterface;

    public function getList(SearchCriteriaInterface $searchCriteria): GroupShippingPolicySearchResultsInterface;

    public function save(GroupShippingPolicyInterface $policy): GroupShippingPolicyInterface;

    public function delete(GroupShippingPolicyInterface $policy): bool;
}

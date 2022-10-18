<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicy\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCallbackInterface;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCallbackSearchResultsInterface;

interface PolicyCallbackRepositoryInterface
{
    public function getById(int $id): PolicyCallbackInterface;

    public function getList(SearchCriteriaInterface $searchCriteria): PolicyCallbackSearchResultsInterface;

    public function save(PolicyCallbackInterface $callback): PolicyCallbackInterface;

    public function delete(PolicyCallbackInterface $callback): bool;
}

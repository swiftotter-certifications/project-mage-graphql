<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\GroupShippingPolicy\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCountryInterface;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCountrySearchResultsInterface;

interface PolicyCountryRepositoryInterface
{
    public function getById(int $id): PolicyCountryInterface;

    public function getList(SearchCriteriaInterface $searchCriteria): PolicyCountrySearchResultsInterface;

    public function save(PolicyCountryInterface $policyCountry): PolicyCountryInterface;

    public function delete(PolicyCountryInterface $policyCountry): bool;
}

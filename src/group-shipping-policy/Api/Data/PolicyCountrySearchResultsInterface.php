<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicy\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface PolicyCountrySearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return PolicyCountryInterface[]
     */
    public function getItems();

    /**
     * @param PolicyCountryInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

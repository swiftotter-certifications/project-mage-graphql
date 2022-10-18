<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicy\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface PolicyCallbackSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return PolicyCallbackInterface[]
     */
    public function getItems();

    /**
     * @param PolicyCallbackInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

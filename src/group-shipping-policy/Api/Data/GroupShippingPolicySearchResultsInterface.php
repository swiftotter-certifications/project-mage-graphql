<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\GroupShippingPolicy\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface GroupShippingPolicySearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return GroupShippingPolicyInterface[]
     */
    public function getItems();

    /**
     * @param GroupShippingPolicyInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

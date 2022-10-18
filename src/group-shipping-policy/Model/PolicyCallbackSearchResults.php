<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicy\Model;

use Magento\Framework\Api\SearchResults;
use SwiftOtter\GroupShippingPolicy\Api\Data\PolicyCallbackSearchResultsInterface;

class PolicyCallbackSearchResults extends SearchResults implements PolicyCallbackSearchResultsInterface
{

}

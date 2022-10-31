<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\GroupShippingPolicy\Api\Data;

interface PolicyCountryInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param mixed $value
     * @return PolicyCountryInterface
     */
    public function setId($value);

    public function getPolicyId(): int;

    public function setPolicyId(int $id): PolicyCountryInterface;

    public function getCountryId(): string;

    public function setCountryId(string $id): PolicyCountryInterface;
}

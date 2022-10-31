<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\GroupShippingPolicy\Api\Data;

interface PolicyCallbackInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param mixed $value
     * @return PolicyCallbackInterface
     */
    public function setId($value);

    public function getPolicyId(): int;

    public function setPolicyId(int $id): PolicyCallbackInterface;

    public function getPhone(): string;

    public function setPhone(string $phone): PolicyCallbackInterface;

    public function getCreatedAt(): ?\DateTime;

    public function setCreatedAt(\DateTime $createdAt): PolicyCallbackInterface;

    public function hasBeenCalled(): bool;

    public function setHasBeenCalled(bool $called): PolicyCallbackInterface;
}

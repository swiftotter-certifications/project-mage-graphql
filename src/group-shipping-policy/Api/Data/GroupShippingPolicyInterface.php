<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc.
 * @website https://swiftotter.com
 **/

namespace SwiftOtter\GroupShippingPolicy\Api\Data;

interface GroupShippingPolicyInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param mixed $value
     * @return GroupShippingPolicyInterface
     */
    public function setId($value);

    public function getCustomerGroupId(): int;

    public function setCustomerGroupId(int $id): GroupShippingPolicyInterface;

    public function getTitle(): string;

    public function setTitle(string $title): GroupShippingPolicyInterface;

    public function getDescription(): string;

    public function setDescription(string $description): GroupShippingPolicyInterface;
}

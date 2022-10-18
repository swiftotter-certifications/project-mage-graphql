<?php
declare(strict_types=1);

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
}

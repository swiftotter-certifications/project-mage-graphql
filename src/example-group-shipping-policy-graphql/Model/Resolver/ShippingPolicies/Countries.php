<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver\ShippingPolicies;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\ValueFactory;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver\DataProvider\ShippingPolicies\Countries as CountriesProvider;

class Countries implements ResolverInterface
{
    private CountriesProvider $countriesProvider;
    private ValueFactory $valueFactory;

    public function __construct(
        CountriesProvider $countriesProvider,
        ValueFactory $valueFactory
    ) {
        $this->countriesProvider = $countriesProvider;
        $this->valueFactory = $valueFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!isset($value['id'])) {
            return [];
        }

        $format = $args['format'] ?? null;

        $this->countriesProvider->addPolicyIdFilter((int) $value['id']);
        return $this->valueFactory->create(function() use ($value, $format) {
            $countryPolicies = $this->countriesProvider->getAllPolicyCountries($format);
            $countries = [];
            foreach ($countryPolicies as $countryPolicy) {
                $policyId = $countryPolicy['policy_id'] ?? null;
                $label = $countryPolicy['country'] ?? null;
                if ($policyId == $value['id'] && $label !== null) {
                    $countries[] = $label;
                }
            }

            return $countries;
        });
    }
}

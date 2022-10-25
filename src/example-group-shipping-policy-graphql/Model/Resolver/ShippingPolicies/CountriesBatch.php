<?php
declare(strict_types=1);

namespace SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver\ShippingPolicies;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\Resolver\BatchResolverInterface;
use Magento\Framework\GraphQl\Query\Resolver\BatchResponse;
use Magento\Framework\GraphQl\Query\Resolver\BatchResponseFactory;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use SwiftOtter\GroupShippingPolicyGraphQl\Model\Resolver\DataProvider\ShippingPolicies\Countries as CountriesProvider;

class CountriesBatch implements BatchResolverInterface
{
    private BatchResponseFactory $batchResponseFactory;
    private CountriesProvider $countriesProvider;

    public function __construct(
        BatchResponseFactory $batchResponseFactory,
        CountriesProvider $countriesProvider
    ) {
        $this->batchResponseFactory = $batchResponseFactory;
        $this->countriesProvider = $countriesProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(
        ContextInterface $context,
        Field $field,
        array $requests
    ): BatchResponse {
        /** @var Batchresponse $response */
        $response = $this->batchResponseFactory->create();

        foreach ($requests as $request) {
            $value = $request->getValue();
            if (!isset($value['id'])) {
                continue;
            }
            $this->countriesProvider->addPolicyIdFilter((int) $value['id']);
        }

        foreach ($requests as $request) {
            $value = $request->getValue();
            if (!isset($value['id'])) {
                continue;
            }

            $args = $request->getArgs();
            $format = $args['format'] ?? null;

            $countryPolicies = $this->countriesProvider->getAllPolicyCountries($format);
            $countries = [];
            foreach ($countryPolicies as $countryPolicy) {
                $policyId = $countryPolicy['policy_id'] ?? null;
                $label = $countryPolicy['country'] ?? null;
                if ($policyId == $value['id'] && $label !== null) {
                    $countries[] = $label;
                }
            }

            $response->addResponse($request, $countries);
        }
        return $response;
    }
}

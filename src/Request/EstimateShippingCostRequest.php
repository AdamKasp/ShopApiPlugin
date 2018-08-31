<?php

declare(strict_types=1);

namespace Sylius\ShopApiPlugin\Request;

use Sylius\ShopApiPlugin\Command\EstimateShippingCost;
use Symfony\Component\HttpFoundation\Request;

final class EstimateShippingCostRequest
{
    /**
     * @var string
     */
    private $cartToken;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $provinceCode;

    /**
     * @var array
     */
    private $result = [];

    public function __construct(Request $request)
    {
        $this->cartToken = $request->attributes->get('token');
        $this->countryCode = $request->query->get('countryCode');
        $this->provinceCode = $request->query->get('provinceCode');
    }

    public function cartToken(): string
    {
        return $this->cartToken;
    }

    public function countryCode(): string
    {
        return $this->countryCode;
    }

    public function provinceCode(): string
    {
        return $this->provinceCode;
    }

    public function getCommand(): EstimateShippingCost
    {
        return new EstimateShippingCost($this->cartToken, $this->countryCode, $this->provinceCode);
    }

    /**
     * @param int    $value
     * @param string $currencyCode
     */
    public function setResult(int $value, string $currencyCode)
    {
        $this->result = [$value, $currencyCode];
    }

    /**
     *Returns the array of value, currency code
     *
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }
}

<?php

declare(strict_types=1);

namespace Sylius\ShopApiPlugin\Command;

final class EstimateShippingCost
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

    public function __construct(string $cartToken, string $countryCode, string $provinceCode)
    {
        $this->cartToken = $cartToken;
        $this->countryCode = $countryCode;
        $this->provinceCode = $provinceCode;
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
}

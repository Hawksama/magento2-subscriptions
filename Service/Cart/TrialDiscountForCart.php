<?php

declare(strict_types=1);

namespace Mollie\Subscriptions\Service\Cart;

class TrialDiscountForCart
{
    /**
     * @var float
     */
    private $product;
    /**
     * @var float
     */
    private $shipping;
    /**
     * @var float
     */
    private $discount;

    public function __construct(
        float $product,
        float $shipping,
        float $discount
    ) {
        $this->product = $product;
        $this->shipping = $shipping;
        $this->discount = $discount;
    }

    public function getProduct(): float
    {
        return $this->product;
    }

    public function getShipping(): float
    {
        return $this->shipping;
    }

    public function getDiscount(): float
    {
        return $this->discount;
    }
}

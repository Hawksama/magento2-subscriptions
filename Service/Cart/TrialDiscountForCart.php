<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

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
    /**
     * @var int
     */
    private $itemCount;

    public function __construct(
        float $product,
        float $shipping,
        float $discount,
        int $itemCount
    ) {
        $this->product = $product;
        $this->shipping = $shipping;
        $this->discount = $discount;
        $this->itemCount = $itemCount;
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

    public function getItemCount(): int
    {
        return $this->itemCount;
    }
}

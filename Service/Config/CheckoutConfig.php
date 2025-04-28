<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Subscriptions\Service\Config;

use Magento\Checkout\Model\Session as CheckoutSession;
use Mollie\Subscriptions\Service\Cart\CartContainsSubscriptionProduct;
use Mollie\Subscriptions\Service\Cart\GetTrialDiscountForCart;

class CheckoutConfig implements \Magento\Checkout\Model\ConfigProviderInterface
{
    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * @var CartContainsSubscriptionProduct
     */
    private $cartContainsSubscriptionProduct;
    /**
     * @var GetTrialDiscountForCart
     */
    private $getTrialDiscountForCart;

    public function __construct(
        CheckoutSession $checkoutSession,
        CartContainsSubscriptionProduct $cartContainsSubscriptionProduct,
        GetTrialDiscountForCart $getTrialDiscountForCart
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->cartContainsSubscriptionProduct = $cartContainsSubscriptionProduct;
        $this->getTrialDiscountForCart = $getTrialDiscountForCart;
    }


    public function getConfig()
    {
        $cart = $this->checkoutSession->getQuote();
        $trialDiscountForCart = $this->getTrialDiscountForCart->execute($cart);

        return [
            'mollie' => [
                'subscriptions' => [
                    'has_subscription_products_in_cart' => $this->cartContainsSubscriptionProduct->check($cart),
                    'has_trial_products_in_cart' => $trialDiscountForCart->getProduct() != 0,
                    'trial' => [
                        'product' => $trialDiscountForCart->getProduct(),
                        'shipping' => $trialDiscountForCart->getShipping(),
                        'discount' => $trialDiscountForCart->getDiscount(),
                    ],
                ],
            ],
        ];
    }
}

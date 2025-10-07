<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Subscriptions\Service\Magento;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\DataObject;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Tax\Helper\Data as TaxHelper;
use Magento\Tax\Model\Calculation as TaxCalculation;
use Mollie\Api\Resources\Subscription;

class SubscriptionAddProductToCart
{
    private ProductRepositoryInterface $productRepository;
    private TaxHelper $taxHelper;
    private TaxCalculation $taxCalculation;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        TaxHelper $taxHelper,
        TaxCalculation $taxCalculation
    ) {
        $this->productRepository = $productRepository;
        $this->taxHelper = $taxHelper;
        $this->taxCalculation = $taxCalculation;
    }

    public function execute(CartInterface $cart, Subscription $subscription): ProductInterface
    {
        $metadata = $subscription->metadata;
        $sku = $metadata->sku;
        $parentSku = isset($metadata->parent_sku) ? $metadata->parent_sku : null;
        $quantity = isset($metadata->quantity) ? (float)$metadata->quantity : 1;

        $product = $this->productRepository->get($parentSku ?: $sku);
        $cart->setIsVirtual($product->getIsVirtual());

        if (!$parentSku) {
            $price = $this->getProductItemPrice($cart, $subscription, $product);
            $item = $cart->addProduct($product, $quantity);
            $item->setPrice($price);
            $item->setCustomPrice($price);
            $item->setOriginalCustomPrice($price);
            return $product;
        }

        $childProduct = $this->productRepository->get($sku);
        $productAttributeOptions = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);

        $options = [];
        foreach ($productAttributeOptions as $option) {
            $options[$option['attribute_id']] = $childProduct->getData($option['attribute_code']);
        }

        $item = $cart->addProduct($product, new DataObject([
            'product' => $product->getId(),
            'qty' => $quantity,
            'super_attribute' => $options,
        ]));

        $price = $this->getProductItemPrice($cart, $subscription, $product);
        $item->setPrice($price);
        $item->setCustomPrice($price);
        $item->setOriginalCustomPrice($price);

        return $product;
    }

    private function getProductItemPrice(CartInterface $cart, Subscription $subscription, ProductInterface $product)
    {
        if ($this->taxHelper->priceIncludesTax()) {
            return $subscription->amount->value;
        }

        $request = $this->taxCalculation->getRateRequest(
            $cart->getShippingAddress(),
            $cart->getBillingAddress(),
            $cart->getCustomerTaxClassId(),
            $cart->getStore(),
            $cart->getCustomerId()
        );

        $taxClassId = $product->getTaxClassId();
        $taxRate = $this->taxCalculation->getRate($request->setProductClassId($taxClassId));

        if ($taxRate <= 0) {
            return $subscription->amount->value;
        }

        $priceIncl = $subscription->amount->value;
        return $priceIncl / (1 + ($taxRate / 100));
    }
}

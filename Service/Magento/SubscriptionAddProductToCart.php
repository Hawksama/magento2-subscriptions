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
use Mollie\Api\Resources\Subscription;

class SubscriptionAddProductToCart
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository
    ) {
        $this->productRepository = $productRepository;
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
            $item = $cart->addProduct($product, $quantity);
            $item->setCustomPrice($subscription->amount->value);
            $item->setOriginalCustomPrice($subscription->amount->value);

            return $product;
        }

        $childProduct = $this->productRepository->get($sku);
        $productAttributeOptions = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);

        $options = [];
        foreach ($productAttributeOptions as $option) {
            $options[$option['attribute_id']] =  $childProduct->getData($option['attribute_code']);
        }

        $item = $cart->addProduct($product, new DataObject([
            'product' => $product->getId(),
            'qty' => $quantity,
            'super_attribute' => $options,
        ]));

        $item->setCustomPrice($subscription->amount->value);
        $item->setOriginalCustomPrice($subscription->amount->value);

        return $product;
    }
}

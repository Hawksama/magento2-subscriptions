<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Mollie\Subscriptions\Observer\CatalogProductSaveAfter;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Mollie\Subscriptions\Api\SubscriptionToProductRepositoryInterface;

class UpdateSubscriptionProduct implements ObserverInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var SubscriptionToProductRepositoryInterface
     */
    private $subscriptionToProductRepository;

    public function __construct(
        SerializerInterface $serializer,
        SubscriptionToProductRepositoryInterface $subscriptionToProductRepository
    ) {
        $this->serializer = $serializer;
        $this->subscriptionToProductRepository = $subscriptionToProductRepository;
    }

    public function execute(Observer $observer)
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $observer->getData('product');

        if ($product->dataHasChangedFor('price')) {
            $this->subscriptionToProductRepository->productHasPriceUpdate($product);
        }

        if ($product->dataHasChangedFor('mollie_subscription_table') &&
            $this->subscriptionTableHasPriceUpdate($product)
        ) {
            $this->subscriptionToProductRepository->productHasPriceUpdate($product);
        }
    }

    private function subscriptionTableHasPriceUpdate(ProductInterface $product): bool
    {
        $old = $this->serializer->unserialize($product->getOrigData('mollie_subscription_table'));
        $new = $this->serializer->unserialize($product->getData('mollie_subscription_table'));

        $oldMapping = $this->getIdentifierToPriceMapping($old);
        $newMapping = $this->getIdentifierToPriceMapping($new);

        foreach ($oldMapping as $identifier => $price) {
            if (array_key_exists($identifier, $newMapping) && $newMapping[$identifier] != $price) {
                return true;
            }
        }

        return false;
    }

    private function getIdentifierToPriceMapping(array $table): array
    {
        $output = [];
        foreach ($table as $row) {
            $output[$row['identifier']] = $row['price'];
        }

        return $output;
    }
}

<?php

declare(strict_types=1);

namespace Mollie\Subscriptions\Observer\SalesQuoteItemSetProduct;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Api\Data\CartItemInterface;
use Mollie\Subscriptions\Service\Cart\GetSelectedCartItemOption;

class SetSubscriptionPriceInQuote implements ObserverInterface
{
    /**
     * @var GetSelectedCartItemOption
     */
    private $getSelectedCartItemOption;

    public function __construct(
        GetSelectedCartItemOption $getSelectedCartItemOption
    ) {
        $this->getSelectedCartItemOption = $getSelectedCartItemOption;
    }

    public function execute(Observer $observer): void
    {
        /** @var CartItemInterface $item */
        $item = $observer->getEvent()->getQuoteItem();
        if (!$item) {
            return;
        }

        $selectedOption = $this->getSelectedCartItemOption->execute($item);
        if ($selectedOption === null || $selectedOption->getPrice() === null) {
            return;
        }

        $item->setCustomPrice($selectedOption->getPrice());
        $item->setOriginalCustomPrice($selectedOption->getPrice());
//        $item->getProduct()->setIsSuperMode(true);
    }
}

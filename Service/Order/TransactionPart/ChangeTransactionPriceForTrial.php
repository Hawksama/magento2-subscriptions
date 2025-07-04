<?php

declare(strict_types=1);

namespace Mollie\Subscriptions\Service\Order\TransactionPart;

use Magento\Sales\Api\Data\OrderInterface;
use Mollie\Payment\Helper\General;
use Mollie\Payment\Model\Client\Payments;
use Mollie\Payment\Service\Order\TransactionPartInterface;
use Mollie\Subscriptions\Service\Mollie\OrderHasTrialProduct;

class ChangeTransactionPriceForTrial implements TransactionPartInterface
{
    /**
     * @var General
     */
    private $mollieHelper;
    /**
     * @var OrderHasTrialProduct
     */
    private $orderHasTrialProduct;

    public function __construct(
        General $mollieHelper,
        OrderHasTrialProduct $orderHasTrialProduct
    ) {
        $this->mollieHelper = $mollieHelper;
        $this->orderHasTrialProduct = $orderHasTrialProduct;
    }

    public function process(OrderInterface $order, $apiMethod, array $transaction): array
    {
        $result = $this->orderHasTrialProduct->execute($order);
        if (!$result->getOutcome()) {
            return $transaction;
        }

        // Change amount
        $originalAmount = (float)$transaction['amount']['value'];
        $transaction['amount'] = $this->mollieHelper->getAmountArray(
            $transaction['amount']['currency'],
            $originalAmount - $result->getTrialAmountTotal(),
        );

        if ($apiMethod == Payments::CHECKOUT_TYPE) {
            return $transaction;
        }

        $forceBaseCurrency = (bool)$this->mollieHelper->useBaseCurrency($order->getStoreId());
        $currency = $forceBaseCurrency ? $order->getBaseCurrencyCode() : $order->getOrderCurrencyCode();

        $transaction['lines'][] = [
            'type' => 'surcharge',
            'name' => 'Trial',
            'quantity' => 1,
            'unitPrice' => $this->mollieHelper->getAmountArray($currency, -$result->getTrialAmountTotal()),
            'totalAmount' => $this->mollieHelper->getAmountArray($currency, -$result->getTrialAmountTotal()),
            'vatRate' => 0,
            'vatAmount' => $this->mollieHelper->getAmountArray($currency, 0.0),
        ];

        return $transaction;
    }
}

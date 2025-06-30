<?php

declare(strict_types=1);

namespace Mollie\Subscriptions\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface SentEmailSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Mollie\Subscriptions\Api\Data\SentEmailInterface[]
     */
    public function getItems(): array;

    /**
     * @param \Mollie\Subscriptions\Api\Data\SentEmailInterface[] $items
     */
    public function setItems(array $items);
}

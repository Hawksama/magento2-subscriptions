<?php

declare(strict_types=1);

namespace Mollie\Subscriptions\Service\Mollie;

use Magento\Catalog\Api\Data\ProductInterface;
use Mollie\Subscriptions\DTO\ProductSubscriptionOption;

class GetSelectedOption
{
    /**
     * @var ParseSubscriptionOptions
     */
    private $parseSubscriptionOptions;

    public function __construct(
        ParseSubscriptionOptions $parseSubscriptionOptions
    ) {
        $this->parseSubscriptionOptions = $parseSubscriptionOptions;
    }

    public function execute(ProductInterface $product, string $optionId): ProductSubscriptionOption
    {
        $options = $this->parseSubscriptionOptions->execute($product);
        foreach ($options as $option) {
            if ($option->getIdentifier() === $optionId) {
                return $option;
            }
        }

        throw new \Exception(sprintf('No option with ID %s available', $optionId));
    }
}

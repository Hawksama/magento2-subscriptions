<?php

declare(strict_types=1);

namespace Mollie\Subscriptions\Service\Mollie;

class OrderHasTrialProductResult
{
    /**
     * @var bool
     */
    private $outcome;
    /**
     * @var float
     */
    private $trialAmountTotal;

    public function __construct(
        bool $outcome,
        float $trialAmountTotal
    )
    {
        $this->outcome = $outcome;
        $this->trialAmountTotal = $trialAmountTotal;
    }

    public function getOutcome(): bool
    {
        return $this->outcome;
    }

    public function getTrialAmountTotal(): float
    {
        return $this->trialAmountTotal;
    }
}

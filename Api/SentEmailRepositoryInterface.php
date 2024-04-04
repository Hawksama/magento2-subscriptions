<?php

declare(strict_types=1);

namespace Mollie\Subscriptions\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Mollie\Subscriptions\Api\Data\SentEmailInterface;
use Mollie\Subscriptions\Api\Data\SentEmailSearchResultsInterface;

interface SentEmailRepositoryInterface
{
    /**
     * @param int $id
     * @return \Mollie\Subscriptions\Api\Data\SentEmailInterface
     */
    public function get(int $id): \Mollie\Subscriptions\Api\Data\SentEmailInterface;

    /**
      * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
      * @return \Mollie\Subscriptions\Api\Data\SentEmailSearchResultsInterface
      */
    public function getList(SearchCriteriaInterface $criteria): \Mollie\Subscriptions\Api\Data\SentEmailSearchResultsInterface;

    /**
     * @param \Mollie\Subscriptions\Api\Data\SentEmailInterface $entity
     * @return \Mollie\Subscriptions\Api\Data\SentEmailInterface
     */
    public function save(SentEmailInterface $entity): \Mollie\Subscriptions\Api\Data\SentEmailInterface;

    /**
      * @param \Mollie\Subscriptions\Api\Data\SentEmailInterface $entity
      * @return bool
      */
    public function delete(SentEmailInterface $entity): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}

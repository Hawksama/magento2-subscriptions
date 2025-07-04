<?php

declare(strict_types=1);

namespace Mollie\Subscriptions\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface SentEmailInterface extends ExtensibleDataInterface
{
    public const ENTITY_ID = 'entity_id';
    public const SUBJECT = 'subject';
    public const SENDER = 'sender';
    public const RECIPIENTS = 'recipients';
    public const SENT_AT = 'sent_at';

    /**
     * @return int|null
     */
    public function getEntityId();

    /**
     * @param int $entity_id
     * @return \Mollie\Subscriptions\Api\Data\SentEmailInterface
     */
    public function setEntityId(int $entity_id);

    /**
     * @return string|null
     */
    public function getSubject(): ?string;

    /**
     * @param string $subject
     * @return \Mollie\Subscriptions\Api\Data\SentEmailInterface
     */
    public function setSubject(string $subject): \Mollie\Subscriptions\Api\Data\SentEmailInterface;

    /**
     * @return string|null
     */
    public function getSender(): ?string;

    /**
     * @param string $sender
     * @return \Mollie\Subscriptions\Api\Data\SentEmailInterface
     */
    public function setSender(string $sender): \Mollie\Subscriptions\Api\Data\SentEmailInterface;

    /**
     * @return string|null
     */
    public function getRecipients(): ?string;

    /**
     * @param string $recipients
     * @return \Mollie\Subscriptions\Api\Data\SentEmailInterface
     */
    public function setRecipients(string $recipients): \Mollie\Subscriptions\Api\Data\SentEmailInterface;

    /**
     * @return string|null
     */
    public function getSentAt(): ?string;

    /**
     * @param string $sent_at
     * @return \Mollie\Subscriptions\Api\Data\SentEmailInterface
     */
    public function setSentAt(string $sent_at): \Mollie\Subscriptions\Api\Data\SentEmailInterface;

    /**
     * @return \Mollie\Subscriptions\Api\Data\SentEmailExtensionInterface|null
     */
    public function getExtensionAttributes(): ?\Mollie\Subscriptions\Api\Data\SentEmailExtensionInterface;

    /**
     * @param \Mollie\Subscriptions\Api\Data\SentEmailExtensionInterface $extensionAttributes
     * @return static
     */
    public function setExtensionAttributes(
        \Mollie\Subscriptions\Api\Data\SentEmailExtensionInterface $extensionAttributes
    );
}

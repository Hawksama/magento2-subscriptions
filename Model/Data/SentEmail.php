<?php

declare(strict_types=1);

namespace Mollie\Subscriptions\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Mollie\Subscriptions\Api\Data\SentEmailExtensionInterface;
use Mollie\Subscriptions\Api\Data\SentEmailInterface;

class SentEmail extends AbstractExtensibleObject implements SentEmailInterface
{
    public function getEntityId()
    {
        return $this->_get(self::ENTITY_ID);
    }

    public function setEntityId(int $entity_id)
    {
        return $this->setData(self::ENTITY_ID, $entity_id);
    }

    public function getSubject(): ?string
    {
        return $this->_get(self::SUBJECT);
    }

    public function setSubject(string $subject): SentEmailInterface
    {
        return $this->setData(self::SUBJECT, $subject);
    }

    public function getSender(): ?string
    {
        return $this->_get(self::SENDER);
    }

    public function setSender(string $sender): SentEmailInterface
    {
        return $this->setData(self::SENDER, $sender);
    }

    public function getRecipients(): ?string
    {
        return $this->_get(self::RECIPIENTS);
    }

    public function setRecipients(string $recipients): SentEmailInterface
    {
        return $this->setData(self::RECIPIENTS, $recipients);
    }

    public function getSentAt(): ?string
    {
        return $this->_get(self::SENT_AT);
    }

    public function setSentAt(string $sent_at): SentEmailInterface
    {
        return $this->setData(self::SENT_AT, $sent_at);
    }

    public function getExtensionAttributes(): ?SentEmailExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    public function setExtensionAttributes(
        SentEmailExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}

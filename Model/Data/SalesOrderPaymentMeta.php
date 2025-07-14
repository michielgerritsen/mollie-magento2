<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Payment\Model\Data;

use Magento\Framework\Api\AbstractExtensibleObject;
use Mollie\Payment\Api\Data\SalesOrderPaymentMetaExtensionInterface;
use Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface;

class SalesOrderPaymentMeta extends AbstractExtensibleObject implements SalesOrderPaymentMetaInterface
{
    public function getEntityId(): ?int
    {
        return $this->_get(self::ENTITY_ID);
    }

    public function setEntityId(int $entity_id): SalesOrderPaymentMetaInterface
    {
        return $this->setData(self::ENTITY_ID, $entity_id);
    }

    public function getParentId(): ?int
    {
        return $this->_get(self::PARENT_ID);
    }

    public function setParentId(int $parent_id): SalesOrderPaymentMetaInterface
    {
        return $this->setData(self::PARENT_ID, $parent_id);
    }

    public function getTransactionId(): ?string
    {
        return $this->_get(self::TRANSACTION_ID);
    }

    public function setTransactionId(string $transaction_id): SalesOrderPaymentMetaInterface
    {
        return $this->setData(self::TRANSACTION_ID, $transaction_id);
    }

    public function getPaypalReference(): ?string
    {
        return $this->_get(self::PAYPAL_REFERENCE);
    }

    public function setPaypalReference(?string $paypalReference): SalesOrderPaymentMetaInterface
    {
        return $this->setData(self::PAYPAL_REFERENCE, $paypalReference);
    }

    public function getExtensionAttributes(): ?SalesOrderPaymentMetaExtensionInterface
    {
        return $this->_getExtensionAttributes();
    }

    public function setExtensionAttributes(
        SalesOrderPaymentMetaExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}

<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Payment\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface SalesOrderPaymentMetaInterface extends ExtensibleDataInterface
{
    public const ENTITY_ID = 'entity_id';
    public const PARENT_ID = 'parent_id';
    public const TRANSACTION_ID = 'transaction_id';
    public const PAYPAL_REFERENCE = 'paypal_reference';

    /**
     * @return int|null
     */
    public function getEntityId(): ?int;

    /**
     * @param int $entity_id
     * @return \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface
     */
    public function setEntityId(int $entity_id): \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface;

    /**
     * @return int|null
     */
    public function getParentId(): ?int;

    /**
     * @param int $parent_id
     * @return \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface
     */
    public function setParentId(int $parent_id): \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface;

    /**
     * @return string|null
     */
    public function getTransactionId(): ?string;

    /**
     * @param string $transaction_id
     * @return \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface
     */
    public function setTransactionId(string $transaction_id): \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface;

    /**
     * @return string|null
     */
    public function getPaypalReference(): ?string;

    /**
     * @param string $paypalReference
     * @return \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface
     */
    public function setPaypalReference(string $paypalReference): \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface;

    /**
     * @return \Mollie\Payment\Api\Data\SalesOrderPaymentMetaExtensionInterface|null
     */
    public function getExtensionAttributes(): ?\Mollie\Payment\Api\Data\SalesOrderPaymentMetaExtensionInterface;

    /**
     * @param \Mollie\Payment\Api\Data\SalesOrderPaymentMetaExtensionInterface $extensionAttributes
     * @return static
     */
    public function setExtensionAttributes(
        \Mollie\Payment\Api\Data\SalesOrderPaymentMetaExtensionInterface $extensionAttributes
    );
}

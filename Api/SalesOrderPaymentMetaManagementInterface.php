<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Payment\Api;

use Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface;

interface SalesOrderPaymentMetaManagementInterface
{
    /**
     * @param int $entityId
     * @return SalesOrderPaymentMetaInterface
     */
    public function getForPayment(int $entityId): \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface;
}

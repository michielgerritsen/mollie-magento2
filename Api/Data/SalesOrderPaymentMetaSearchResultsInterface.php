<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Payment\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface SalesOrderPaymentMetaSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface[]
     */
    public function getItems();

    /**
     * @param \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface[] $items
     */
    public function setItems(array $items);
}

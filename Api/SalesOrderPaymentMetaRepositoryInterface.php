<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Payment\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface;
use Mollie\Payment\Api\Data\SalesOrderPaymentMetaSearchResultsInterface;

interface SalesOrderPaymentMetaRepositoryInterface
{
    /**
     * @param int $id
     * @return \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface
     */
    public function get(int $id): \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface;

    /**
      * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
      * @return \Mollie\Payment\Api\Data\SalesOrderPaymentMetaSearchResultsInterface
      */
    public function getList(SearchCriteriaInterface $criteria): \Mollie\Payment\Api\Data\SalesOrderPaymentMetaSearchResultsInterface;

    /**
     * @param \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface $entity
     * @return \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface
     */
    public function save(SalesOrderPaymentMetaInterface $entity): \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface;

    /**
      * @param \Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface $entity
      * @return bool
      */
    public function delete(SalesOrderPaymentMetaInterface $entity): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}

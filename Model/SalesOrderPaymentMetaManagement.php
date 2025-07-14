<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Payment\Model;

use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface;
use Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterfaceFactory;
use Mollie\Payment\Api\SalesOrderPaymentMetaManagementInterface;
use Mollie\Payment\Api\SalesOrderPaymentMetaRepositoryInterface;

class SalesOrderPaymentMetaManagement implements SalesOrderPaymentMetaManagementInterface
{
    /**
     * @var SearchCriteriaBuilderFactory
     */
    private $searchCriteriaBuilderFactory;
    /**
     * @var SalesOrderPaymentMetaRepositoryInterface
     */
    private $repository;
    /**
     * @var SalesOrderPaymentMetaInterfaceFactory
     */
    private $salesOrderPaymentMetaFactory;

    public function __construct(
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        SalesOrderPaymentMetaRepositoryInterface $repository,
        SalesOrderPaymentMetaInterfaceFactory $salesOrderPaymentMetaFactory
    ) {
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->repository = $repository;
        $this->salesOrderPaymentMetaFactory = $salesOrderPaymentMetaFactory;
    }

    public function getForPayment(int $entityId): SalesOrderPaymentMetaInterface
    {
        $builder = $this->searchCriteriaBuilderFactory->create();
        $builder->addFilter('parent_id', $entityId);

        $result = $this->repository->getList($builder->create());
        if ($result->getTotalCount() === 0) {
            $meta = $this->salesOrderPaymentMetaFactory->create();
            $meta->setParentId($entityId);
            return $meta;
        }

        $items = $result->getItems();
        return array_shift($items);
    }
}

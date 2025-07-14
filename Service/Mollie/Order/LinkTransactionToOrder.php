<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Payment\Service\Mollie\Order;

use Magento\Sales\Api\Data\OrderInterface;
use Mollie\Payment\Api\Data\TransactionToOrderInterfaceFactory;
use Mollie\Payment\Api\SalesOrderPaymentMetaManagementInterface;
use Mollie\Payment\Api\SalesOrderPaymentMetaRepositoryInterface;
use Mollie\Payment\Api\TransactionToOrderRepositoryInterface;

class LinkTransactionToOrder
{
    /**
     * @var TransactionToOrderRepositoryInterface
     */
    private $transactionToOrderRepository;

    /**
     * @var TransactionToOrderInterfaceFactory
     */
    private $transactionToOrderFactory;
    /**
     * @var SalesOrderPaymentMetaManagementInterface
     */
    private $salesOrderPaymentMetaManagement;
    /**
     * @var SalesOrderPaymentMetaRepositoryInterface
     */
    private $salesOrderPaymentMetaRepository;

    public function __construct(
        TransactionToOrderRepositoryInterface $transactionToOrderRepository,
        TransactionToOrderInterfaceFactory $transactionToOrderFactory,
        SalesOrderPaymentMetaManagementInterface $salesOrderPaymentMetaManagement,
        SalesOrderPaymentMetaRepositoryInterface $salesOrderPaymentMetaRepository
    ) {
        $this->transactionToOrderRepository = $transactionToOrderRepository;
        $this->transactionToOrderFactory = $transactionToOrderFactory;
        $this->salesOrderPaymentMetaManagement = $salesOrderPaymentMetaManagement;
        $this->salesOrderPaymentMetaRepository = $salesOrderPaymentMetaRepository;
    }

    public function execute(string $transactionId, OrderInterface $order): void
    {
        $this->transactionToOrderRepository->save(
            $this->transactionToOrderFactory->create()
                ->setTransactionId($transactionId)
                ->setOrderId($order->getEntityId())
        );

        $order->setMollieTransactionId($transactionId);

        $metaObject = $this->salesOrderPaymentMetaManagement->getForPayment($order->getPayment()->getEntityId());
        $metaObject->setTransactionId($transactionId);

        $this->salesOrderPaymentMetaRepository->save($metaObject);
    }
}

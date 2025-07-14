<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Payment\Model\Client\Orders\Processors;

use Magento\Sales\Api\Data\OrderInterface;
use Mollie\Api\Resources\Order;
use Mollie\Api\Resources\Payment;
use Mollie\Payment\Api\SalesOrderPaymentMetaManagementInterface;
use Mollie\Payment\Api\SalesOrderPaymentMetaRepositoryInterface;
use Mollie\Payment\Model\Client\OrderProcessorInterface;
use Mollie\Payment\Model\Client\ProcessTransactionResponse;

class AddPaymentMeta implements OrderProcessorInterface
{
    /**
     * @var SalesOrderPaymentMetaManagementInterface
     */
    private $paymentMetaManagement;
    /**
     * @var SalesOrderPaymentMetaRepositoryInterface
     */
    private $paymentMetaRepository;

    public function __construct(
        SalesOrderPaymentMetaManagementInterface $paymentMetaManagement,
        SalesOrderPaymentMetaRepositoryInterface $paymentMetaRepository
    ) {
        $this->paymentMetaManagement = $paymentMetaManagement;
        $this->paymentMetaRepository = $paymentMetaRepository;
    }

    public function process(
        OrderInterface $magentoOrder,
        Order $mollieOrder,
        string $type,
        ProcessTransactionResponse $response
    ): ?ProcessTransactionResponse {
        $metaObject = $this->paymentMetaManagement->getForPayment((int)$magentoOrder->getPayment()->getEntityId());

        $payments = $mollieOrder->payments();
        /** @var Payment $payment */
        $payment = $payments->offsetGet(0);
        if (!property_exists($payment, 'details') ||
            !$payment->details ||
            !property_exists($payment->details, 'paypalReference')
        ) {
            return $response;
        }

        $reference = $payment->details->paypalReference;
        $metaObject->setPaypalReference($reference);
        $this->paymentMetaRepository->save($metaObject);

        return $response;
    }
}

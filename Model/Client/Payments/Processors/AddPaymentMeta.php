<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Payment\Model\Client\Payments\Processors;

use Magento\Sales\Api\Data\OrderInterface;
use Mollie\Api\Resources\Payment;
use Mollie\Payment\Api\SalesOrderPaymentMetaManagementInterface;
use Mollie\Payment\Api\SalesOrderPaymentMetaRepositoryInterface;
use Mollie\Payment\Model\Client\PaymentProcessorInterface;
use Mollie\Payment\Model\Client\ProcessTransactionResponse;

class AddPaymentMeta implements PaymentProcessorInterface
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
        Payment $molliePayment,
        string $type,
        ProcessTransactionResponse $response
    ): ?ProcessTransactionResponse {
        $metaObject = $this->paymentMetaManagement->getForPayment((int)$magentoOrder->getPayment()->getEntityId());

        if (!property_exists($molliePayment, 'details') ||
            !$molliePayment->details ||
            !property_exists($molliePayment->details, 'paypalReference')
        ) {
            return $response;
        }

        $reference = $molliePayment->details->paypalReference;
        $metaObject->setPaypalReference($reference);
        $this->paymentMetaRepository->save($metaObject);

        return $response;
    }
}

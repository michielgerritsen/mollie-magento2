<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Payment\Service\Order;

use Magento\Sales\Api\Data\OrderInterface;
use Mollie\Api\Resources\Payment;
use Mollie\Payment\Api\SalesOrderPaymentMetaManagementInterface;
use Mollie\Payment\Api\SalesOrderPaymentMetaRepositoryInterface;

class SavePaypalReference
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

    public function execute(OrderInterface $order, Payment $molliePayment): void
    {
        $metaObject = $this->paymentMetaManagement->getForPayment((int)$order->getPayment()->getEntityId());

        if (!property_exists($molliePayment, 'details') ||
            !$molliePayment->details ||
            !property_exists($molliePayment->details, 'paypalReference')
        ) {
            return;
        }

        $reference = $molliePayment->details->paypalReference;
        $metaObject->setPaypalReference($reference);
        $this->paymentMetaRepository->save($metaObject);
    }
}

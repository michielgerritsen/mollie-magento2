<?php
/**
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Mollie\Payment\Service\Order\TransactionPart;

use Mollie\Payment\Model\Client\Orders;
use Mollie\Payment\Model\Client\Payments;
use Mollie\Payment\Test\Integration\IntegrationTestCase;

class CardTokenTest extends IntegrationTestCase
{
    /**
     * @magentoDataFixture Magento/Sales/_files/order.php
     */
    public function testAddsDataForPaymentsApi()
    {
        $order = $this->loadOrderById('100000001');
        $payment = $order->getPayment();
        $payment->setAdditionalInformation('card_token', 'abc123');

        /** @var CardToken $instance */
        $instance = $this->objectManager->create(CardToken::class);

        $transaction = $instance->process($order, Payments::CHECKOUT_TYPE, ['method' => 'creditcard']);

        $this->assertEquals(['method' => 'creditcard', 'cardToken' => 'abc123'], $transaction);
    }

    /**
     * @magentoDataFixture Magento/Sales/_files/order.php
     */
    public function testAddsDataForOrdersApi()
    {
        $order = $this->loadOrderById('100000001');
        $payment = $order->getPayment();
        $payment->setAdditionalInformation('card_token', 'abc123');

        /** @var CardToken $instance */
        $instance = $this->objectManager->create(CardToken::class);

        $transaction = $instance->process($order, Orders::CHECKOUT_TYPE, ['method' => 'creditcard']);

        $this->assertEquals(['method' => 'creditcard', 'payment' => ['cardToken' => 'abc123']], $transaction);
    }

    /**
     * @magentoDataFixture Magento/Sales/_files/order.php
     */
    public function testDoesNotChangeTheTransactionWhenNoCardTokenIsPresent()
    {
        $order = $this->loadOrderById('100000001');

        /** @var CardToken $instance */
        $instance = $this->objectManager->create(CardToken::class);

        $transaction = $instance->process($order, Orders::CHECKOUT_TYPE, ['method' => 'creditcard']);

        $this->assertEquals(['method' => 'creditcard'], $transaction);
    }
}

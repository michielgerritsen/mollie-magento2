<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Payment\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface;
use Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterfaceFactory;

class SalesOrderPaymentMeta extends AbstractModel
{
    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;
    /**
     * @var SalesOrderPaymentMetaInterfaceFactory
     */
    private $salesOrderPaymentMetaDataFactory;

    public function __construct(
        Context $context,
        Registry $registry,
        DataObjectHelper $dataObjectHelper,
        SalesOrderPaymentMetaInterfaceFactory $salesOrderPaymentMetaDataFactory,
        ResourceModel\SalesOrderPaymentMeta $resource,
        ?AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->dataObjectHelper = $dataObjectHelper;
        $this->salesOrderPaymentMetaDataFactory = $salesOrderPaymentMetaDataFactory;
    }

    public function getDataModel(): SalesOrderPaymentMetaInterface
    {
        $data = $this->getData();

        $dataObject = $this->salesOrderPaymentMetaDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $dataObject,
            $data,
            SalesOrderPaymentMetaInterfaceFactory::class
        );

        return $dataObject;
    }
}

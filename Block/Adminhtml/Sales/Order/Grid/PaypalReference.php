<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Payment\Block\Adminhtml\Sales\Order\Grid;

use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Mollie\Payment\Api\SalesOrderPaymentMetaRepositoryInterface;

class PaypalReference extends Column
{
    /**
     * @var SearchCriteriaBuilderFactory
     */
    private $searchCriteriaBuilderFactory;
    /**
     * @var SalesOrderPaymentMetaRepositoryInterface
     */
    private $paymentMetaRepository;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        SalesOrderPaymentMetaRepositoryInterface $paymentMetaRepository,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);

        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->paymentMetaRepository = $paymentMetaRepository;
    }

    public function prepare()
    {
        parent::prepare();
    }

    public function prepareDataSource(array $dataSource)
    {
        $prepareDataSource = parent::prepareDataSource($dataSource);

        if (isset($prepareDataSource['data']['items'])) {
            $prepareDataSource['data']['items'] = $this->ehanceItems($prepareDataSource['data']['items']);
        }


        return $prepareDataSource;
    }

    private function ehanceItems($items): array
    {
        $entityIds = array_column($items, 'entity_id');

//        $builder = $this->searchCriteriaBuilderFactory->create();
//        $builder->add

        return $items;
    }
}

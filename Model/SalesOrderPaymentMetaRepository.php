<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Payment\Model;

use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Mollie\Payment\Api\Data\SalesOrderPaymentMetaInterface;
use Mollie\Payment\Api\Data\SalesOrderPaymentMetaSearchResultsInterface;
use Mollie\Payment\Api\Data\SalesOrderPaymentMetaSearchResultsInterfaceFactory;
use Mollie\Payment\Api\SalesOrderPaymentMetaRepositoryInterface;
use Mollie\Payment\Model\ResourceModel\SalesOrderPaymentMeta as ResourceSalesOrderPaymentMeta;
use Mollie\Payment\Model\ResourceModel\SalesOrderPaymentMeta\CollectionFactory as SalesOrderPaymentMetaCollectionFactory;

class SalesOrderPaymentMetaRepository implements SalesOrderPaymentMetaRepositoryInterface
{
    /**
     * @var ResourceSalesOrderPaymentMeta
     */
    private $resource;
    /**
     * @var SalesOrderPaymentMetaFactory
     */
    private $salesOrderPaymentMetaFactory;
    /**
     * @var SalesOrderPaymentMetaCollectionFactory
     */
    private $salesOrderPaymentMetaCollectionFactory;
    /**
     * @var SalesOrderPaymentMetaSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var JoinProcessorInterface
     */
    private $extensionAttributesJoinProcessor;
    /**
     * @var ExtensibleDataObjectConverter
     */
    private $extensibleDataObjectConverter;

    public function __construct(
        ResourceSalesOrderPaymentMeta $resource,
        SalesOrderPaymentMetaFactory $salesOrderPaymentMetaFactory,
        SalesOrderPaymentMetaCollectionFactory $salesOrderPaymentMetaCollectionFactory,
        SalesOrderPaymentMetaSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->salesOrderPaymentMetaFactory = $salesOrderPaymentMetaFactory;
        $this->salesOrderPaymentMetaCollectionFactory = $salesOrderPaymentMetaCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * @throws \Exception
     */
    public function save(SalesOrderPaymentMetaInterface $entity): SalesOrderPaymentMetaInterface
    {
        $salesOrderPaymentMetaData = $this->extensibleDataObjectConverter->toNestedArray(
            $entity,
            [],
            SalesOrderPaymentMetaInterface::class
        );

        $salesOrderPaymentMetaModel = $this->salesOrderPaymentMetaFactory->create()->setData($salesOrderPaymentMetaData);

        try {
            $this->resource->save($salesOrderPaymentMetaModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the salesOrderPaymentMeta: %1',
                $exception->getMessage()
            ));
        }
        return $salesOrderPaymentMetaModel->getDataModel();
    }

    /**
     * @throws NoSuchEntityException
     */
    public function get(int $id): SalesOrderPaymentMetaInterface
    {
        $salesOrderPaymentMeta = $this->salesOrderPaymentMetaFactory->create();
        $this->resource->load($salesOrderPaymentMeta, $id);
        if (!$salesOrderPaymentMeta->getId()) {
            throw new NoSuchEntityException(__('SalesOrderPaymentMeta with id "%1" does not exist.', $id));
        }
        return $salesOrderPaymentMeta->getDataModel();
    }

    public function getList(SearchCriteriaInterface $criteria): SalesOrderPaymentMetaSearchResultsInterface
    {
        $collection = $this->salesOrderPaymentMetaCollectionFactory->create();

        $this->extensionAttributesJoinProcessor->process(
            $collection,
            SalesOrderPaymentMetaInterface::class
        );

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @throws CouldNotDeleteException
     */
    public function delete(SalesOrderPaymentMetaInterface $salesOrderPaymentMeta): bool
    {
        try {
            $salesOrderPaymentMetaModel = $this->salesOrderPaymentMetaFactory->create();
            $this->resource->load($salesOrderPaymentMetaModel, $salesOrderPaymentMeta->getEntityId());
            $this->resource->delete($salesOrderPaymentMetaModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the SalesOrderPaymentMeta: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    public function deleteById(int $id): bool
    {
        return $this->delete($this->get($id));
    }
}

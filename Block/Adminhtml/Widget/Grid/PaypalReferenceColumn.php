<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Payment\Block\Adminhtml\Widget\Grid;

use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Sales\Model\ResourceModel\Transaction\Grid\Collection;

class PaypalReferenceColumn extends Column
{
    public function _construct()
    {
        parent::_construct();

        $this->setData(
            'filter_condition_callback',
            [$this, 'filterPaypalReference']
        );
    }

    public function filterPaypalReference(Collection $collection, self $column)
    {
        if (!$this->getFilter()->getValue()) {
            return;
        }

        $value = $this->getFilter()->getValue();
        $collection->addFieldToFilter('mpsopm.paypal_reference', ['like' => '%' . $value . '%']);
    }
}

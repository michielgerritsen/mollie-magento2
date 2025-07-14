<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Payment\Plugin\Backend\Block\Widget\Grid;

use Magento\Backend\Block\Widget\Grid;

class AddMetaJoinToCollection
{
    public function afterGetCollection(Grid $subject, ?\Magento\Framework\Data\Collection $collection): ?\Magento\Framework\Data\Collection
    {
        if ($collection === null || !method_exists($collection, 'getSelect')) {
            return $collection;
        }

        /** @var \Magento\Framework\DB\Select $select */
        $select = $collection->getSelect();

        $from = $select->getPart('from');
        if (array_key_exists('mpsopm', $from)) {
            return $collection;
        }

        $select->joinLeft(
            ['mpsopm' => 'mollie_payment_salesorderpaymentmeta'],
            'main_table.payment_id = mpsopm.parent_id',
            [
                'mpsopm.transaction_id as mollie_transaction_id',
                'mpsopm.paypal_reference as mollie_paypal_reference',
            ]
        );

        return $collection;
    }
}

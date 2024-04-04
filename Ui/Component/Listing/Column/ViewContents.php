<?php
/*
 * Copyright Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Mollie\Subscriptions\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class ViewContents extends Column
{
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = "<a href='#' class='view-contents-modal' data-id='" . $item['entity_id'] . "'>View Contents</a>";
            }
        }

        return $dataSource;
    }
}

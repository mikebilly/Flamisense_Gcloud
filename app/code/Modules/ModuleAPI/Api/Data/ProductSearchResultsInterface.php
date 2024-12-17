<?php

namespace Modules\ModuleAPI\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ProductSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Function getItems
     *
     * @return ProductInterface[]
     */
    public function getItems();

    /**
     * Function setItems
     *
     * @param ProductInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

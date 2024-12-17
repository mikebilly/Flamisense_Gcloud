<?php
namespace Modules\ModuleAPI\Model;

use Magento\Framework\View\Element\Template;
use Modules\ModuleAPI\Api\ProductByCategoryIDInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;

class ProductByCategoryID extends Template implements ProductByCategoryIDInterface
{
    protected $_productCollectionFactory;
    protected $_categoryCollectionFactory;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        CategoryCollectionFactory $categoryCollectionFactory
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
    }

    public function getCategoryIdsBySearchTerm($searchTerm)
    {
        $categoryCollection = $this->_categoryCollectionFactory->create();
        $categoryCollection->addAttributeToSelect('entity_id');

        if (is_numeric($searchTerm)) {
            $categoryCollection->addFieldToFilter('entity_id', $searchTerm);
        } else {
            $categoryCollection->addFieldToFilter('name', ['like' => '%' . $searchTerm . '%']);
        }

        $categoryIds = [];
        foreach ($categoryCollection as $category) {
            $categoryIds[] = $category->getEntityId();
        }

        return $categoryIds;
    }

    public function getProductCollectionBySearchTerm($searchTerm)
    {
        $categoryIds = $this->getCategoryIdsBySearchTerm($searchTerm);

        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addCategoriesFilter(['in' => $categoryIds]);

        return $collection;
    }

    public function getProductByCategoryID($searchTerm)
    {
        $productCollection = $this->getProductCollectionBySearchTerm($searchTerm);
        $data = [];

        foreach ($productCollection as $k => $product) {
            $data[$k + 1] = [
                'ID' => $product['entity_id'],
                'SKU' => $product['sku'],
                'NAME' => $product['name'],
                'PRICE' => $product['price'],
                'URL KEY' => $product['url_key'],
                'META_TITLE' => $product['meta_title'],
                'META_DESCRIPTION' => $product['meta_description'],
                'SHORT_DESCRIPTION' => $product['short_description'],
                'DESCRIPTION' => $product['description'],
                'IMAGE' => $product['image'],
                'STATUS_ID' => $product['status'],
            ];
        }

        return $data;
    }
}

<?php
namespace Modules\ModuleAPI\Model;
use Magento\Framework\View\Element\Template;
use Modules\ModuleAPI\Api\ProductByIdInterface;

class ProductById extends Template implements ProductByIdInterface
{
    protected $_productCollectionFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getProductCollection($searchTerm)
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');

        if (is_numeric($searchTerm)) {
            $collection->addFieldToFilter('entity_id', $searchTerm);
        } else {
                $collection->addFieldToFilter('name', ['like' => '%' . $searchTerm . '%']);
        }

        return $collection;
    }

    public function getProductById($searchTerm)
    {
        $productCollection = $this->getProductCollection($searchTerm);
        $data = [];

        foreach ($productCollection as $product) {
            $data[] = [
                'ID' => $product->getId(),
                'SKU' => $product->getSku(),
                'NAME' => $product->getName(),
                'PRICE' => $product->getPrice(),
                'URL KEY' => $product->getUrlKey(),
                'META_TITLE' => $product->getMetaTitle(),
                'META_DESCRIPTION' => $product->getMetaDescription(),
                'SHORT_DESCRIPTION' => $product->getShortDescription(),
                'DESCRIPTION' => $product->getDescription(),
                'IMAGE' => $product->getImage(),
                'STATUS_ID' => $product->getStatus(),
            ];
        }

        return $data;
    }
}

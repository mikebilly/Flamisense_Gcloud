<?php

  namespace Modules\ModuleAPI\Api;

  /**
   * interface get product data API XML by product id
   */
  interface ProductBySKUInterface
  {
    /**
     * @api
     * @param string $sku Product id.
     * @return string product data
     */
    public function getProductBySKU($sku);
  }


 ?>

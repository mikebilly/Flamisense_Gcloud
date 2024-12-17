<?php

  namespace Modules\ModuleAPI\Api;

  /**
   * interface get product data API XML by product id
   */
  interface ProductByCategoryIDInterface
  {
    /**
     * @api
     * @param string $cid Product id.
     * @return string product data
     */
    public function getProductByCategoryID($cid);
  }


 ?>

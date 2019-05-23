<?php

class LCB_PrettyUrls_Model_Catalog_Url extends Mage_Catalog_Model_Url
{

    /**
     * Refresh product rewrite
     *
     * @param Varien_Object $product
     * @param Varien_Object $category
     * @return Mage_Catalog_Model_Url
     */
    protected function _refreshProductRewrite(Varien_Object $product, Varien_Object $category)
    {
        if ($category->getId() == $category->getPath()) {
            return $this;
        }
        if ($product->getUrlKey() == '') {
            $urlKey = $this->getProductModel()->formatUrlKey($product->getName());
        } else {
            $urlKey = $this->getProductModel()->formatUrlKey($product->getUrlKey());
        }

        $idPath = $this->generatePath('id', $product, $category);
        $targetPath = $this->generatePath('target', $product, $category);
        $requestPath = $this->getProductRequestPath($product, $category);

        $categoryId = null;
        $updateKeys = true;
        if ($category->getLevel() > 1) {
            $categoryId = $category->getId();
            $updateKeys = false;
        }

        $rewriteData = array(
            'store_id' => $category->getStoreId(),
            'category_id' => $categoryId,
            'product_id' => $product->getId(),
            'id_path' => $idPath,
            'request_path' => $requestPath,
            'target_path' => $targetPath,
            'is_system' => 1
        );

        $this->getResource()->saveRewrite($rewriteData, $this->_rewrite);

        if ($this->getShouldSaveRewritesHistory($category->getStoreId())) {
            $this->_saveRewriteHistory($rewriteData, $this->_rewrite);
        }

        if ($updateKeys && $product->getUrlKey() != $urlKey) {
            $product->setUrlKey($urlKey);
            $this->getResource()->saveProductAttribute($product, 'url_key');
        }
        if ($updateKeys && $product->getUrlPath() != $requestPath) {
            $product->setUrlPath($requestPath);
            $this->getResource()->saveProductAttribute($product, 'url_path');
        }

        return $this;
    }

}

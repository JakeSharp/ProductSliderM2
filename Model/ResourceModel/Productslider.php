<?php

namespace JakeSharp\Productslider\Model\ResourceModel;

class Productslider extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {

    const SLIDER_PRODUCTS_TABLE = 'js_productslider_product';

    protected function _construct(){
        $this->_init('js_productslider','slider_id');
    }

    //Get product for selected slider
    public function getSliderProducts($slider)
    {
        $select = $this->getConnection()->select()->from(
            $this->getTable('js_productslider_product'),
            ['product_id', 'position']
        )->where(
            'slider_id = :slider_id'
        );

        $bind = ['slider_id' => (int)$slider->getSliderId()];

        return $this->getConnection()->fetchPairs($select, $bind);
    }

    public function getSliderProductsTable()
    {
        return $this->getTable(self::SLIDER_PRODUCTS_TABLE);
    }

    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $this->_saveSliderProducts($object);
        return parent::_afterSave($object);
    }

    protected function _saveSliderProducts($slider)
    {
        $id = $slider->getSliderId();

        /**
         * new slider-product relationships
         */
        $products = $slider->getPostedProducts();
        /**
         * Example re-save slider
         */
        if ($products === null) {
            return $this;
        }

        /**
         * old slider-product relationships
         */
        $oldProducts = $slider->getSelectedSliderProducts();

        $insert = array_diff_key($products, $oldProducts);
        $delete = array_diff_key($oldProducts, $products);

        /**
         * Find product ids which are presented in both arrays
         * and saved before (check $oldProducts array)
         */
        $update = array_intersect_key($products, $oldProducts);
        $update = array_diff_assoc($update, $oldProducts);

        $connection = $this->getConnection();

        /**
         * Delete products from slider
         */
        if (!empty($delete)) {
            $condition = ['product_id IN(?)' => array_keys($delete), 'slider_id=?' => $id];
            $connection->delete($this->getSliderProductsTable(), $condition);
        }

        /**
         * Add products to slider
         */
        if (!empty($insert)) {
            $data = [];
            foreach ($insert as $productId => $position) {
                $data[] = [
                    'slider_id' => (int)$id,
                    'product_id' => (int)$productId,
                    'position' => (int)$position,
                ];
            }
            $connection->insertMultiple($this->getSliderProductsTable(), $data);
        }

        /**
         * Update product positions in category
         */
        if (!empty($update)) {
            foreach ($update as $productId => $position) {
                $where = ['slider_id = ?' => (int)$id, 'product_id = ?' => (int)$productId];
                $bind = ['position' => (int)$position];
                $connection->update($this->getSliderProductsTable(), $bind, $where);
            }
        }

        return $this;

    }

}

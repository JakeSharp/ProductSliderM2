<?php

namespace JakeSharp\Productslider\Block\Adminhtml\Slider\Edit\Tab;

class Products extends \Magento\Backend\Block\Widget\Grid\Extended {

    //For geting product collection
    protected $_productFactory;
    protected $_resource;
    protected $_coreRegistry = null;
    protected $_catalogProductVisibility;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Backend\Helper\Data $helper,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        array $data = []
    ){
        $this->_productFactory = $productFactory;
        $this->_coreRegistry = $coreRegistry;
        $this->_resource = $resource;
        $this->_catalogProductVisibility = $catalogProductVisibility;
        parent::__construct($context, $helper, $data);
    }

    protected function _construct(){
        parent::_construct();
        $this->setId('products_grid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    public function getSlider()
    {
        return $this->_coreRegistry->registry('product_slider');
    }


    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in slider flag
        if ($column->getId() == 'in_slider') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $productIds]);
            } elseif (!empty($productIds)) {
                $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $productIds]);
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    protected function _prepareCollection(){

        if ($this->getSlider()->getSliderId()) {
            $this->setDefaultFilter(['in_slider' => 1]);
        }

        $collection = $this->_productFactory->create()->getCollection();
        $collection->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());
        $collection->addAttributeToSelect('name')
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('price')
            ->addStoreFilter(
              $this->getRequest()->getParam('store')
            )
            ->joinField(
                'position',
                'js_productslider_product',
                'position',
                'product_id=entity_id',
                'slider_id=' . (int)$this->getRequest()->getParam('id', 0),
                'left'
            );

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn(
            'in_slider',
            [
                'type' => 'checkbox',
                'name' => 'in_slider',
                'values' => $this->_getSelectedProducts(),
                'index' => 'entity_id',
                'header_css_class' => 'col-select col-massaction',
                'column_css_class' => 'col-select col-massaction'
            ]
        );

        $this->addColumn(
             'entity_id',
             [
                 'header' => __('ID'),
                 'sortable' => true,
                 'index' => 'entity_id',
                 'header_css_class' => 'col-id',
                 'column_css_class' => 'col-id'
             ]
         );

         $this->addColumn(
             'name',
             [
                 'header' => __('Name'),
                 'index' => 'name'
             ]);

         $this->addColumn(
             'sku',
             [
                 'header' => __('SKU'),
                 'index' => 'sku'
             ]);

         $this->addColumn(
             'price',
             [
                 'header' => __('Price'),
                 'type' => 'currency',
                 'currency_code' => (string)$this->_scopeConfig->getValue(
                     \Magento\Directory\Model\Currency::XML_PATH_CURRENCY_BASE,
                     \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                 ),
                 'index' => 'price'
             ]
         );

        $this->addColumn(
            'position',
            [
                'header' => __('Position'),
                'type' => 'number',
                'index' => 'position',
                'editable' => true
            ]
        );

        return parent::_prepareColumns();

    }

    public function getSelectedSliderProducts()
    {
        $slider_id = $this->getRequest()->getParam('id');

        $select = $this->_resource->getConnection()->select()->from(
            'js_productslider_product',
            ['product_id', 'position']
        )->where(
            'slider_id = :slider_id'
        );
        $bind = ['slider_id' => (int)$slider_id];

        return $this->_resource->getConnection()->fetchPairs($select, $bind);

    }

    protected function _getSelectedProducts()
    {
        $products = $this->getRequest()->getParam('selected_products');
        if ($products === null)  {
            $products = $this->getSlider()->getSelectedSliderProducts();
            return array_keys($products);
        }
        return $products;
    }

    /* Retrieve grid reload url  */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/productsgrid', ['_current' => true]);
    }

}
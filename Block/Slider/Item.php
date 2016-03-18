<?php

namespace JakeSharp\Productslider\Block\Slider;


class Item extends \Magento\Catalog\Block\Product\AbstractProduct
{
    const PRODUCTS_COUNT = 10;

    protected $_productsCollectionFactory;
    protected $_reportsCollectionFactory;
    protected $_sliderFactory;
    protected $_sliderId;
    protected $_slider;

    //For the reports
    protected $_eventTypeFactory;
    protected $_catalogProductVisibility;

    protected $_template = 'JakeSharp_Productslider::slider/item.phtml';

    protected $_dateTime;
    protected $_storeManager;

    public function __construct
    (
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productsCollectionFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\Reports\Model\ResourceModel\Product\CollectionFactory $reportsCollectionFactory,
        \JakeSharp\Productslider\Model\ProductsliderFactory $productsliderFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Magento\Reports\Model\Event\TypeFactory $eventTypeFactory,
        array $data = []
    ){
        $this->_productCollectionFactory = $productsCollectionFactory;
        $this->_reportsCollectionFactory = $reportsCollectionFactory;
        $this->_catalogProductVisibility = $catalogProductVisibility;
        $this->_sliderFactory = $productsliderFactory;
        $this->_dateTime = $dateTime;
        $this->_eventTypeFactory = $eventTypeFactory;
        $this->_storeManager = $context->getStoreManager();
        parent::__construct($context,$data);
    }


    public function getSliderProducts()
    {
        $collection = "";
        switch($this->_slider->getType()){
            case 'new':
                $collection =  $this->_getNewProducts($this->_productCollectionFactory->create());
                break;
            case 'bestsellers':
                $collection = $this->_getBestsellersProducts($this->_productCollectionFactory->create());
                break;
            case 'mostviewed':
                $collection =  $this->_getMostViewedProducts($this->_reportsCollectionFactory->create());
                break;
            case 'onsale':
                $collection =  $this->_getOnSaleProducts($this->_productCollectionFactory->create());
                break;
            case 'featured':
                $collection =  $this->_getSliderFeaturedProducts($this->_productCollectionFactory->create());
                break;
        }

        return $collection;
    }

    protected function _getSliderFeaturedProducts($collectionFactory)
    {
        $collection = $this->_addProductAttributesAndPrices($collectionFactory);
        $collection->getSelect()
                    ->join(['slider_products' => $collection->getTable('js_productslider_product')],
                            'e.entity_id = slider_products.product_id AND slider_products.slider_id = '.$this->getSliderId(),
                            ['position'])
                    ->order('slider_products.position');
        $collection->addStoreFilter($this->getStoreId())
                    ->setPageSize($this->getProductsCount())
                    ->setCurPage(1);

        return $collection;
    }

    protected function _getNewProducts($collectionFactory)
    {
        $collectionFactory->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());
        $collection = $this->_addProductAttributesAndPrices($collectionFactory)
            ->addAttributeToFilter(
                'news_from_date',
                ['date' => true, 'to' => $this->getEndOfDayDate()],
                'left')
            ->addAttributeToFilter(
                'news_to_date',
                [
                    'or' => [
                        0 => ['date' => true, 'from' => $this->getStartOfDayDate()],
                        1 => ['is' => new \Zend_Db_Expr('null')],
                    ]
                ],
                'left')
            ->addAttributeToSort(
               'news_from_date',
               'desc')
            ->addStoreFilter($this->getStoreId())
            ->setPageSize($this->getProductsCount())
            ->setCurPage(1);

        return $collection;
    }

    protected function _getMostViewedProducts($collectionFactory)
    {
        $eventTypes = $this->_eventTypeFactory->create()->getCollection();

        //Getting event type id for catalog_product_view event
        foreach ($eventTypes as $eventType) {
            if ($eventType->getEventName() == 'catalog_product_view') {
                $productViewEvent = (int)$eventType->getId();
                break;
            }
        }

        $collectionFactory->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());
        $collection = $this->_addProductAttributesAndPrices($collectionFactory);
        $collection->getSelect()->reset()->from(
                    ['report_table_views' => $collection->getTable('report_event')],
                    ['views' => 'COUNT(report_table_views.event_id)']
                )->join(
                    ['e' => $collection->getProductEntityTableName()],
                    $collection->getConnection()->quoteInto(
                        'e.entity_id = report_table_views.object_id',
                        $collection->getProductAttributeSetId()
                    )
                )->where(
                    'report_table_views.event_type_id = ?',
                    $productViewEvent
                )->group(
                    'e.entity_id'
                )->order(
                    'views DESC'
                )->having(
                    'COUNT(report_table_views.event_id) > ?',
                    0
                );

        $collection->addStoreFilter($this->getStoreId())
            ->setPageSize($this->getProductsCount())
            ->setCurPage(1);
//            ->addViewsCount()

        return $collection;
    }

    protected function _getOnSaleProducts($collectionFactory)
    {
        $collectionFactory->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());
        $collection = $this->_addProductAttributesAndPrices($collectionFactory)
            ->addAttributeToFilter(
                'special_from_date',
                ['date' => true, 'to' => $this->getEndOfDayDate()],
                'left')
            ->addAttributeToFilter(
                'special_to_date',
                [
                    'or' => [
                        0 => ['date' => true, 'from' => $this->getStartOfDayDate()],
                        1 => ['is' => new \Zend_Db_Expr('null')],
                    ]
                ],
                'left')
            ->addAttributeToSort(
                'news_from_date',
                'desc')
            ->addStoreFilter($this->getStoreId())
            ->setPageSize($this->getProductsCount())
            ->setCurPage(1);

        return $collection;
    }

    protected function _getBestsellersProducts($collectionFactory)
    {
        $collectionFactory->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());
        $collection = $this->_addProductAttributesAndPrices($collectionFactory);
        $collection->getSelect()
                    ->join(['bestsellers' => $collection->getTable('sales_bestsellers_aggregated_yearly')],
                                'e.entity_id = bestsellers.product_id AND bestsellers.store_id = '.$this->getStoreId(),
                                ['qty_ordered','rating_pos'])
                    ->order('rating_pos');
        $collection->addStoreFilter($this->getStoreId())
                    ->setPageSize($this->getProductsCount())
                    ->setCurPage(1);

        return $collection;
    }

    public function getSliderProductsCollection()
    {
        $collection = [];
        $featuredProducts = $this->getSliderFeaturedProducts();
        $sliderProducts = $this->getSliderProducts();
        if(count($featuredProducts)>0){
            $collection['featured'] = $featuredProducts;
        }

        if(count($sliderProducts)>0){
            $collection['products'] = $sliderProducts;
        }

        return $collection;
    }

    public function getStartOfDayDate()
    {
        return $this->_localeDate->date()->setTime(0, 0, 0)->format('Y-m-d H:i:s');
    }

    public function getEndOfDayDate()
    {
        return $this->_localeDate->date()->setTime(23, 59, 59)->format('Y-m-d H:i:s');
    }

    public function setSlider($slider)
    {
        $this->_slider = $slider;
        return $this;
    }

    public function getSliderId()
    {
        return $this->_slider->getId();
    }

    public function getSlider()
    {
        return $this->_slider;
    }

    // maybe this should be deleted
    public function setSliderId($sliderId)
    {
        $this->_sliderId = $sliderId;
        $slider = $this->_sliderFactory->create()->load($sliderId);

        if($slider->getId()){
            $this->setSlider($slider);
        }

        return $this;
    }

    public function getSLiderDisplayId()
    {
        return $this->_dateTime->timestamp().$this->getSliderId();
    }

    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

    public function getProductsCount()
    {
        return self::PRODUCTS_COUNT;
    }

    public function testCollection()
    {
        $collection2 = $this->_productCollectionFactory->create();
        $todayStartOfDayDate = $this->_localeDate->date()->setTime(0, 0, 0)->format('Y-m-d H:i:s');
        $todayEndOfDayDate = $this->_localeDate->date()->setTime(23, 59, 59)->format('Y-m-d H:i:s');

        $collection =
            $this->_addProductAttributesAndPrices($collection2)
            ->addAttributeToFilter(
                'news_from_date',
                ['date' => true, 'to' => $todayEndOfDayDate],
                'left'
            )
            ->addAttributeToFilter(
                'news_to_date',
                [
                    'or' => [
                        0 => ['date' => true, 'from' => $todayStartOfDayDate],
                        1 => ['is' => new \Zend_Db_Expr('null')],
                    ]
                ],
                'left'
            )
            ->addAttributeToSort(
               'news_from_date',
               'description')
            ->setPageSize(10)->setCurPage(1);

        echo "<pre>";
        echo $collection->getSelect()->__toString();
        echo "</pre>";
        die;

    }


}
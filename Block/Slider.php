<?php

namespace JakeSharp\Productslider\Block;

use JakeSharp\Productslider\Model\Productslider;

class Slider extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface {

    const XML_PATH_PRODUCT_SLIDER_STATUS = "productslider/general/enable_productslider";

    protected $_template = 'JakeSharp_Productslider::slider.phtml';

    protected $_sliderCollectionFactory;
    protected $_scopeConfig;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \JakeSharp\Productslider\Model\ResourceModel\Productslider\CollectionFactory $sliderCollectionFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array $data = []
    ){
        $this->_sliderCollectionFactory = $sliderCollectionFactory;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context,$data);
    }


    protected function _beforeToHtml()
    {
        if($this->getData('widget_slider_id')){
            $this->setSliderLocation(null);
        }
    }

    /**
     * Render block HTML
     * if extension is enabled then render HTML
     */
    protected function _toHtml()
    {
        if($this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_STATUS,\Magento\Store\Model\ScopeInterface::SCOPE_STORES)){
            return parent::_toHtml();
        }
        return false;
    }


    public function setSliderLocation($location,$slider_id=null){
        $todayDateTime = $this->_localeDate->date()->format('Y-m-d H:i:s');
        $widgetSliderId = $this->getData('widget_slider_id');


        //Get data without start/end time
        $sliderCollection = $this->_sliderCollectionFactory->create()
            ->addFieldToFilter('status',Productslider::STATUS_ENABLED)
            ->addFieldToFilter('start_time',['null' => true])
            ->addFieldToFilter('end_time',['null' => true]);

        //If slider_id is not null
        if($widgetSliderId){
            $sliderCollection->addFieldToFilter('slider_id',$widgetSliderId);
        } else {
            $sliderCollection->addFieldToFilter('location',$location);
        }


        //Get data with start/end time
        $sliderCollectionTimer = $this->_sliderCollectionFactory->create()
            ->addFieldToFilter('status',Productslider::STATUS_ENABLED)
            ->addFieldToFilter('start_time', ['lteq' => $todayDateTime ])
            ->addFieldToFilter('end_time',
                                [
                                    'or' => [
                                        0 => ['date' => true, 'from' => $todayDateTime],
                                        1 => ['is' => new \Zend_Db_Expr('null')],
                                    ]
                                ]);

        if($widgetSliderId){
            $sliderCollectionTimer->addFieldToFilter('slider_id',$widgetSliderId);
        } else {
            $sliderCollectionTimer->addFieldToFilter('location',$location);
        }

        $this->setSlider($sliderCollection);
        $this->setSlider($sliderCollectionTimer);
    }


    public function setSlider($sliderCollection)
    {
        foreach($sliderCollection as $slider):
            $this->append($this->getLayout()
                                ->createBlock('\JakeSharp\Productslider\Block\Slider\Items')
//                                ->setTemplate('JakeSharp_Productslider::slider/item.phtml')
                                ->setSlider($slider));
        endforeach;
    }

}
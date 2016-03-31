<?php
/**
 * Copyright © 2016 Jake Sharp (http://www.jakesharp.co/) All rights reserved.
 */

namespace JakeSharp\Productslider\Block\Adminhtml\Slider\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs {

    /**
     * Template file for the tabs
     */
    protected $_template = 'widget/tabs.phtml';

    /**
     * JSON Encoder
     *
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $_jsonEncoder;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\Registry $registry,
        array $data = []
    ){
        $this->_jsonEncoder = $jsonEncoder;
        $this->_coreRegistry = $registry;
        parent::__construct($context, $jsonEncoder, $authSession, $data);
    }

    /**
     * Initialize Tabs
     *
     * @return void
     */
    protected function _construct(){
        parent::_construct();
        $this->setId('product_slider_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Product Slider Information'));
    }

    /**
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'general',
            [
                'label' => __('Slider'),
                'title' => __('Slider'),
                'content' => $this->getChildHtml('admin.block.slider.tab.general'),
                'active' => true
            ]);

        $this->addTab(
            'advanced',
            [
                'label' => __('Advanced Slider Options'),
                'title' => __('Advanced Slider Options'),
                'content' => $this->getChildHtml('admin.block.slider.tab.advanced'),
            ]);

        $this->addTab(
            'products',
            [
                'label' => __('Slider Products'),
                'title' => __('Slider Products'),
                'content' => $this->getChildHtml('admin.block.slider.tab.products')
//                'url' => $this->getUrl('*/*/products', ['_current' => true]),
//                'class' => 'ajax',
            ]);

        return parent::_beforeToHtml();
    }

    /**
     * Retrieve product slider object
     *
     * @return \JakeSharp\Productslider\Model\Productslider
     */
    public function getCurrentSlider()
    {
        return $this->_coreRegistry->registry('product_slider');
    }

    /**
     * Retrieve additional slider products
     *
     * @return string
     */
    public function getProductsJson()
    {
        $products = $this->getCurrentSlider()->getSelectedSliderProducts();
        if (!empty($products)) {
            return $this->_jsonEncoder->encode($products);
        }
        return '{}';
    }

}
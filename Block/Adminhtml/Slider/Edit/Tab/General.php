<?php
/**
 * Copyright © 2016 Jake Sharp (http://www.jakesharp.co/) All rights reserved.
 */

namespace JakeSharp\Productslider\Block\Adminhtml\Slider\Edit\Tab;

use JakeSharp\Productslider\Model\Productslider;
use \Magento\Store\Model\ScopeInterface as Scope;

class General extends \Magento\Backend\Block\Widget\Form\Generic {

    /**
     * Config path for default slider settings
     */
    const XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES = 'productslider/slider_settings/' ;

    /**
     * @var \Magento\Config\Model\Config\Source\Yesno
     */
    protected $_yesNo;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Config\Model\Config\Source\Yesno $yesNo
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Config\Model\Config\Source\Yesno $yesNo,
        array $data = []
    ){
        $this->_yesNo = $yesNo;
        $this->_scopeConfig = $context->getScopeConfig();
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm() {

        $form = $this->_formFactory->create([
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getData('action'),
                    'method' => 'post'
                ]
            ]
        );

        $productSlider = $this->_coreRegistry->registry('product_slider');
        $yesno = $this->_yesNo->toOptionArray();

        $fieldset = $form->addFieldset(
            'slider_fieldset_general',
            ['legend' => __('General settings')]
        );

        $dateFormat = $this->_localeDate->getDateFormat(
            \IntlDateFormatter::SHORT
        );
        $timeFormat = $this->_localeDate->getTimeFormat(
            \IntlDateFormatter::SHORT
        );

        if ($productSlider->getId()) {
            $fieldset->addField(
                'slider_id',
                'hidden',
                [
                    'name' => 'slider_id'
                ]
            );
        }

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Slider status'),
                'title' => __('Slider status'),
                'name' => 'status',
                'options' => Productslider::getStatusArray(),
                'disabled' => false,
            ]
        );

        $fieldset->addField(
            'description',
            'textarea',
            [
                'name' => 'description',
                'label' => __('Description'),
                'title' => __('Description'),
                'note' => __('Not visible on frontend. Only for admin remainder.'),
            ]
        );

        $fieldset->addField(
            'type',
            'select',
            [
                'label' => __('Slider type'),
                'title' => __('Slider type'),
                'name' => 'type',
                'required' => true,
                'values' => Productslider::getSliderTypeArray(),
                'note' => __('Auto related products available only on product page location.'),
            ]
        );

        $fieldset->addField(
            'location',
            'select',
            [
                'label' => __('Slider location'),
                'title' => __('Slider location'),
                'name' => 'location',
                'required' => false,
//                'options' => Productslider::getSliderLocations()
                'values' => Productslider::getSliderLocations()
            ]
        );

        $fieldset->addField(
            'products_number',
            'text',
            [
                'name' => 'products_number',
                'label' => __('Products number'),
                'title' => __('Products number'),
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'products_number',Scope::SCOPE_STORE),
                'note' => __('Number of products displayed in slider. Max. 20 products.'),
            ]
        );

        $fieldset->addField(
            'display_title',
            'select',
            [
                'label' => __('Display title'),
                'title' => __('Display title'),
                'name' => 'display_title',
                'values' => $yesno,
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'display_title',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'display_price',
            'select',
            [
                'label' => __('Display price'),
                'title' => __('Display price'),
                'name' => 'display_price',
                'values' => $yesno,
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'display_price',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'display_cart',
            'select',
            [
                'label' => __('Display cart'),
                'title' => __('Display add to cart button'),
                'name' => 'display_cart',
                'values' => $yesno,
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'display_cart',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'display_wishlist',
            'select',
            [
                'label' => __('Display wishlist'),
                'title' => __('Display add to wish list'),
                'name' => 'display_wishlist',
                'values' => $yesno,
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'display_wishlist',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'display_compare',
            'select',
            [
                'label' => __('Display compare'),
                'title' => __('Display add to compare'),
                'name' => 'display_compare',
                'values' => $yesno,
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'display_compare',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'grid',
            'select',
            [
                'label' => __('Items in grid'),
                'title' => __('Display items in grid'),
                'note'  => __('Display items in the grid, without slider '),
                'name' => 'grid',
                'values' => $yesno,
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'grid',Scope::SCOPE_STORE)
            ]
        );

        // Reference in vendor/magento/module-newsletter/Block/Adminhtml/Queue/Edit/Form.php
        $fieldset->addField(
            'start_time',
            'date',
            [
                'name' => 'start_time',
                'label' => __('Start time'),
                'title' => __('Start time'),
                'date_format' => $dateFormat,
                'time_format' => $timeFormat,
                'note' => $this->_localeDate->getDateTimeFormat(\IntlDateFormatter::SHORT),
            ]
        );

        $fieldset->addField(
            'end_time',
            'date',
            [
                'name' => 'end_time',
                'label' => __('End time'),
                'title' => __('Start time'),
                'date_format' => $dateFormat,
                'time_format' => $timeFormat,
                'note' => $this->_localeDate->getDateTimeFormat(\IntlDateFormatter::SHORT),
            ]
        );

        $fieldset->addField(
            'exclude_from_cart',
            'select',
            [
                'label' => __('Exclude from cart'),
                'title' => __('Exclude from cart'),
                'note'  => __('Don\'t display sliders on cart page'),
                'name' => 'exclude_from_cart',
                'values' => $yesno,
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'exclude_from_cart',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'exclude_from_checkout',
            'select',
            [
                'label' => __('Exclude from checkout'),
                'title' => __('Exclude from cart'),
                'note'  => __('Don\'t display sliders on checkout'),
                'name' => 'exclude_from_checkout',
                'values' => $yesno,
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'exclude_from_checkout',Scope::SCOPE_STORE)
            ]
        );

        if($productSlider->getData()) {
            $form->setValues($productSlider->getData());
        }

        $this->setForm($form);

        return parent::_prepareForm();
    }

}
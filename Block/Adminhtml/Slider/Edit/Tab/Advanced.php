<?php
/**
 * Copyright © 2016 Jake Sharp (http://www.jakesharp.co/) All rights reserved.
 */

namespace JakeSharp\Productslider\Block\Adminhtml\Slider\Edit\Tab;

use \Magento\Store\Model\ScopeInterface as Scope;

class Advanced extends \Magento\Backend\Block\Widget\Form\Generic
{
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
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create();

        $productSlider = $this->_coreRegistry->registry('product_slider');
        $yesno = $this->_yesNo->toOptionArray();

        $fieldset = $form->addFieldset(
            'slider_fieldset',
            ['legend' => __('Slider settings')]
        );

        $fieldset->addField(
            'navigation',
            'select',
            [
                'name' => 'navigation',
                'label' => __('Navigation'),
                'title' => __('Navigation'),
                'note' => __('Enable Navigation (dots below slider)'),
                'values' => $yesno,
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'navigation',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'infinite',
            'select',
            [
                'name' => 'infinite',
                'label' => __('Infinite'),
                'title' => __('Infinite'),
                'values' => $yesno,
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'infinite',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'slides_to_show',
            'text',
            [
                'name' => 'slides_to_show',
                'label' => __('Slides to show'),
                'title' => __('Number of slides to show'),
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'slides_to_show',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'slides_to_scroll',
            'text',
            [
                'name' => 'slides_to_scroll',
                'label' => __('Slides to scroll'),
                'title' => __('Number of slides to scroll'),
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'slides_to_scroll',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'speed',
            'text',
            [
                'name' => 'speed',
                'label' => __('Speed'),
                'title' => __('Speed'),
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'speed',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'autoplay',
            'select',
            [
                'name' => 'autoplay',
                'label' => __('Autoplay'),
                'title' => __('Autoplay'),
                'values' => $yesno,
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'autoplay',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'autoplay_speed',
            'text',
            [
                'name' => 'autoplay_speed',
                'label' => __('Autoplay speed'),
                'title' => __('Autoplay speed'),
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'autoplay_speed',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'rtl',
            'select',
            [
                'name' => 'rtl',
                'label' => __('Right to left'),
                'title' => __('Right to left'),
                'values' => $yesno,
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'rtl',Scope::SCOPE_STORE)
            ]
        );

        $fieldset = $form->addFieldset(
            'slider_fieldset_large',
            ['legend' => __('Large display settings')]
        );

        $fieldset->addField(
            'breakpoint_large',
            'text',
            [
                'name' => 'breakpoint_large',
                'label' => __('Breakpoint large'),
                'title' => __('Breakpoint large'),
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'breakpoint_large',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'large_slides_to_show',
            'text',
            [
                'name' => 'large_slides_to_show',
                'label' => __('Slides to show on large'),
                'title' => __('Slides to show on large'),
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'large_slides_to_show',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'large_slides_to_scroll',
            'text',
            [
                'name' => 'large_slides_to_scroll',
                'label' => __('Slides to scroll on large'),
                'title' => __('Slides to scroll on large'),
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'large_slides_to_scroll',Scope::SCOPE_STORE)
            ]
        );

        $fieldset = $form->addFieldset(
            'slider_fieldset_medium',
            ['legend' => __('Medium display settings')]
        );

        $fieldset->addField(
            'breakpoint_medium',
            'text',
            [
                'name' => 'breakpoint_medium',
                'label' => __('Breakpoint medium'),
                'title' => __('Breakpoint medium'),
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'breakpoint_medium',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'medium_slides_to_show',
            'text',
            [
                'name' => 'medium_slides_to_show',
                'label' => __('Slides to show on medium'),
                'title' => __('Slides to show on medium'),
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'medium_slides_to_show',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'medium_slides_to_scroll',
            'text',
            [
                'name' => 'medium_slides_to_scroll',
                'label' => __('Slides to scroll on medium'),
                'title' => __('Slides to scroll on medium'),
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'medium_slides_to_scroll',Scope::SCOPE_STORE)
            ]
        );

        $fieldset = $form->addFieldset(
            'slider_fieldset_small',
            ['legend' => __('Small display settings')]
        );

        $fieldset->addField(
            'breakpoint_small',
            'text',
            [
                'name' => 'breakpoint_small',
                'label' => __('Breakpoint small'),
                'title' => __('Breakpoint small'),
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'breakpoint_small',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'small_slides_to_show',
            'text',
            [
                'name' => 'small_slides_to_show',
                'label' => __('Slides to show on small'),
                'title' => __('Slides to show on small'),
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'small_slides_to_show',Scope::SCOPE_STORE)
            ]
        );

        $fieldset->addField(
            'small_slides_to_scroll',
            'text',
            [
                'name' => 'small_slides_to_scroll',
                'label' => __('Slides to scroll on small'),
                'title' => __('Slides to scroll on small'),
                'value' => $this->_scopeConfig->getValue(self::XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES.'small_slides_to_scroll',Scope::SCOPE_STORE)
            ]
        );

        if($productSlider->getData()) {
            $form->setValues($productSlider->getData());
        }

        $this->setForm($form);

        return parent::_prepareForm();
    }

}
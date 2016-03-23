<?php

namespace JakeSharp\Productslider\Block\Adminhtml\Slider\Edit\Tab;

use JakeSharp\Productslider\Model\Productslider;
use \Magento\Store\Model\ScopeInterface as Scope;

class General extends \Magento\Backend\Block\Widget\Form\Generic {

    const XML_PATH_PRODUCT_SLIDER_DEFAULT_VALUES = 'productslider/slider_settings/' ;

    protected $_yesNo;
    protected $_scopeConfig;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Config\Model\Config\Source\Yesno $yesNo,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array $data = []
    ){
        $this->_yesNo = $yesNo;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }


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
                'options' => Productslider::getSliderTypeArray()
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

        //Reference -  vendor/magento/module-newsletter/Block/Adminhtml/Queue/Edit/Form.php
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

        $form->setValues($productSlider->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

}
<?php

namespace JakeSharp\Productslider\Block\Adminhtml\Slider;

class Edit extends \Magento\Backend\Block\Widget\Form\Container {
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct(){
        $this->_objectId = 'id';
        $this->_blockGroup = 'JakeSharp_Productslider';
        $this->_controller = 'adminhtml_slider';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Slider'));
        $this->buttonList->update('delete', 'label', __('Delete Slider'));

        // Add button like on /vendor/magento/module-customer/Block/Adminhtml/Edit.php
        $this->buttonList->add(
            'save_and_continue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                    ],
                ]
            ],
            10
        );

//        $this->_formScripts[] = '';
    }


}
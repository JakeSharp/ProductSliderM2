<?php

namespace JakeSharp\Productslider\Block\Adminhtml;

class Slider extends \Magento\Backend\Block\Widget\Grid\Container {
    protected function _construct(){
        $this->_blockGroup = 'JakeSharp_Productslider';
        $this->_controller = 'adminhtml';
        $this->_headerText = 'Slider';
        $this->_addButtonLabel = __('Create New Slider');
        parent::_construct();
    }

}
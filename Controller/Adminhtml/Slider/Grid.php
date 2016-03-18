<?php

namespace JakeSharp\Productslider\Controller\Adminhtml\Slider;

class Grid extends \JakeSharp\Productslider\Controller\Adminhtml\Slider
{
    public function execute()
    {
        $this->_view->loadLayout(false);
        $this->_view->renderLayout();
    }
}
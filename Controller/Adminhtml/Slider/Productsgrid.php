<?php

namespace JakeSharp\Productslider\Controller\Adminhtml\Slider;

class Productsgrid extends \JakeSharp\Productslider\Controller\Adminhtml\Slider
{
    public function execute()
    {
        $sliderId = (int)$this->getRequest()->getParam('id', false);

        $slider = $this->_initSlider($sliderId);
        $this->_coreRegistry->register('product_slider', $slider);

        $resultRaw = $this->_resultRawFactory->create();
        return $resultRaw->setContents(
            $this->_layoutFactory->create()->createBlock(
                'JakeSharp\Productslider\Block\Adminhtml\Slider\Edit\Tab\Products',
                'admin.block.slider.tab.products'
            )->toHtml()
        );


//        $resultLayout = $this->_layoutFactory->create();
//        $resultLayout->getLayout()->getBlock('admin.block.slider.tab.products');
//
//        return $resultLayout;

    }
}
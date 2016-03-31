<?php
/**
 * Copyright © 2016 Jake Sharp (http://www.jakesharp.co/) All rights reserved.
 */

namespace JakeSharp\Productslider\Controller\Adminhtml\Slider;

class Delete extends \JakeSharp\Productslider\Controller\Adminhtml\Slider
{
    /**
     * Delete slider page
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $sliderId = $this->getRequest()->getParam('id');
        $slider = $this->_sliderFactory->create();
        $slider->load($sliderId);
        if($slider->getSliderId()){
            try {
                $slider->delete();
                $this->messageManager->addSuccess(__('The slider has been deleted.'));
                $this->_getSession()->setFormData(false);
            } catch (\Exception $e){
                $this->messageManager->addError($e->getMessage());
            }
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->_resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
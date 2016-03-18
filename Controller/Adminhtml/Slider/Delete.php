<?php

namespace JakeSharp\Productslider\Controller\Adminhtml\Slider;

class Delete extends \JakeSharp\Productslider\Controller\Adminhtml\Slider
{
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

        $resultRedirect = $this->_resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
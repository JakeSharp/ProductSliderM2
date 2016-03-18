<?php

namespace JakeSharp\Productslider\Controller\Adminhtml\Slider;

class Edit extends \JakeSharp\Productslider\Controller\Adminhtml\Slider {

    public function execute(){

//        $id = $this->getRequest()->getParam('id');
//        $model = $this->_sliderFactory->create();
//
//        if ($id) {
//            $model->load($id);
//            if (!$model->getId()) {
//                $this->messageManager->addError(__('This slider no longer exists.').' slider_id = '.$id);
//                $resultForward = $this->_resultRedirectFactory->create();
//                return $resultForward->setPath('*/*/');
//            }
//        }

        $sliderId = (int)$this->getRequest()->getParam('id', false);

        $model = $this->_initSlider($sliderId);
        if ($sliderId)
        {
            if (!$model->getId()) {
                $this->messageManager->addError(__('This slider no longer exists.'));
                $resultForward = $this->_resultRedirectFactory->create();
                return $resultForward->setPath('*/*/');
            }
        }


        // set entered data if there was an error when saving
        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('product_slider', $model);

        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Product Slider'));
        return $resultPage;
    }

}
<?php
/**
 * Copyright © 2016 Jake Sharp (http://www.jakesharp.co/) All rights reserved.
 */

namespace JakeSharp\Productslider\Controller\Adminhtml\Slider;

class Save extends \JakeSharp\Productslider\Controller\Adminhtml\Slider {

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute(){

        $resultRedirect = $this->_resultRedirectFactory->create();
        // Check if form data has been sent
        $sliderFormData = $this->getRequest()->getPostValue();
        if($sliderFormData){
            try{
                $slider_id = $this->getRequest()->getParam('slider_id');
                $productSlider = $this->_sliderFactory->create();
                if($slider_id !== null){
                    $productSlider->load($slider_id);
                }

                $productSlider->setData($sliderFormData);

                // Check for additional slider products
                if (isset($sliderFormData['slider_products']) && is_string($sliderFormData['slider_products']))
                {
                    $products = json_decode($sliderFormData['slider_products'], true);
                    $productSlider->setPostedProducts($products);
                    $productSlider->unsetData('slider_products');
                }

                // Save data
                $productSlider->save();

                if(!$slider_id){
                    $slider_id = $productSlider->getSliderId();
                }

                // Add success message
                $this->messageManager->addSuccess(__('Product slider has been successfully saved.'));
                // Clear previously saved data from session
                $this->_getSession()->setFormData(false);

                //Check if save is clicked or save and continue edit
                if($this->getRequest()->getParam('back') == 'edit'){
                    return $resultRedirect->setPath('*/*/edit', ['id' => $slider_id]);
                }

                //Go to grid
                return $resultRedirect->setPath('*/*/');

            } catch(\Exception $e){
                $this->messageManager->addError($e->getMessage());
                $this->messageManager->addException($e,__('Error occurred during slider saving.'));
            }

            //Set entered form data so we don't have to enter it again (not saved in database)
            $this->_getSession()->setFormData($sliderFormData);
            // Return to edit
            return $resultRedirect->setPath('*/*/edit',['id' => $slider_id]);
        }
    }
}
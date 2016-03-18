<?php

namespace JakeSharp\Productslider\Controller\Adminhtml\Slider;

class Save extends \JakeSharp\Productslider\Controller\Adminhtml\Slider {

    public function execute(){

        $resultForward = $this->_resultForwardFactory->create();
        $resultRedirect = $this->_resultRedirectFactory->create();

        $sliderFormData = $this->getRequest()->getPostValue();

        if($sliderFormData){
            try{
                $slider_id = $this->getRequest()->getParam('slider_id');
                $productSlider = $this->_sliderFactory->create();
                if($slider_id !== null){
                    $productSlider->load($slider_id);
                }

                $productSlider->setData($sliderFormData);

                if (isset($sliderFormData['slider_products']) && is_string($sliderFormData['slider_products']))
                {
                    $products = json_decode($sliderFormData['slider_products'], true);
                    $productSlider->setPostedProducts($products);
                    $productSlider->unsetData('slider_products');
                }

                $productSlider->save();

                if(!$slider_id){
                    $slider_id = $productSlider->getSliderId();
                }

                //Check if save is clicked or save and continue edit
                if($this->getRequest()->getParam('back') == 'edit'){
                    return $resultRedirect->setPath('*/*/edit', ['id' => $slider_id]);
                }

                return $resultRedirect->setPath('*/*/');
                //return $resultRedirect->setRefererUrl();

            } catch(\Exception $e){
                $this->messageManager->addError($e->getMessage());
                $this->messageManager->addException($e,__('Error occurred during slider saving.'));
            }

            //Set entered form data so we don't have to enter it again (not saved in database)
            $this->_getSession()->setFormData($sliderFormData);
            return $resultRedirect->setPath('*/*/edit',['id' => $slider_id]);


        }

//        echo "<pre>";
//        var_dump($sliderFormData);
//        echo "</pre>";
//        die;

    }
}
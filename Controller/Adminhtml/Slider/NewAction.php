<?php

namespace JakeSharp\Productslider\Controller\Adminhtml\Slider;

//reference /Applications/AMPPS/www/m2/vendor/magento/module-customer/Controller/Adminhtml/Index/NewAction.php

class NewAction extends \JakeSharp\Productslider\Controller\Adminhtml\Slider
{
    public function execute(){
        //Forward to edit action
        $resultForward = $this->_resultForwardFactory->create();
        $resultForward->forward('edit');
        return $resultForward;
    }
}
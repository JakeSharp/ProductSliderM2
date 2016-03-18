<?php

namespace JakeSharp\Productslider\Controller\Adminhtml;

abstract class Slider extends \Magento\Backend\App\Action {

    //These variables will be used in child controller classes like Index, Grid, Close
    protected $_resultPageFactory;
    protected $_resultForwardFactory;
    protected $_resultRedirectFactory;
    protected $_layoutFactory;
    protected $_resultRawFactory;
    protected $_sliderFactory;
    protected $_coreRegistry;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \JakeSharp\Productslider\Model\ProductsliderFactory $productsliderFactory,
        \Magento\Framework\Registry $coreRegistry
    ){
        $this->_resultPageFactory = $resultPageFactory;
        $this->_layoutFactory = $layoutFactory;
        $this->_resultRawFactory = $resultRawFactory;
        $this->_resultForwardFactory = $resultForwardFactory;
        $this->_resultRedirectFactory = $context->getResultRedirectFactory();
        $this->_sliderFactory = $productsliderFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    protected function _isAllowed(){
        return $this->_authorization->isAllowed('JakeSharp_Productslider::manage_sliders');
    }

    protected function _initAction(){
        $this->_view->loadLayout();
//        $this->_setActiveMenu('Foggyline_Helpdesk::ticket_manage')
//            ->_addBreadcrumb(__('Helpdesk'), __('Tickets'));
        return $this;
    }

    protected function _initSlider($sliderId)
    {
        $model = $this->_sliderFactory->create();

        if ($sliderId) {
            $model->load($sliderId);
        }

        return $model;
    }

}
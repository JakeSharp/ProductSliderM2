<?php

namespace JakeSharp\Productslider\Model\ResourceModel\Productslider;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    protected function _construct(){
        $this->_init('JakeSharp\Productslider\Model\Productslider','JakeSharp\Productslider\Model\ResourceModel\Productslider');
    }

}
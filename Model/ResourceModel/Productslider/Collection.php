<?php
/**
 * Copyright © 2016 Jake Sharp (http://www.jakesharp.co/) All rights reserved.
 */

namespace JakeSharp\Productslider\Model\ResourceModel\Productslider;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    /**
     * Initialize resources
     * @return void
     */
    protected function _construct(){
        $this->_init('JakeSharp\Productslider\Model\Productslider','JakeSharp\Productslider\Model\ResourceModel\Productslider');
    }

}
<?php
/**
 * Copyright © 2016 Jake Sharp (http://www.jakesharp.co/) All rights reserved.
 */

namespace JakeSharp\Productslider\Model\Slider\Grid;

class Status implements \Magento\Framework\Option\ArrayInterface {

    /**
     * To option slider statuses array
     * @return array
     */
    public function toOptionArray(){
        return \JakeSharp\Productslider\Model\Productslider::getStatusArray();
    }
}
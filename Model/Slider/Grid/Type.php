<?php
/**
 * Copyright © 2016 Jake Sharp (http://www.jakesharp.co/) All rights reserved.
 */

namespace JakeSharp\Productslider\Model\Slider\Grid;

class Type implements \Magento\Framework\Data\OptionSourceInterface{

    /**
     * To option slider types array
     * @return array
     */
    public function toOptionArray(){
        return \JakeSharp\Productslider\Model\Productslider::getSliderTypeArray();
    }
}
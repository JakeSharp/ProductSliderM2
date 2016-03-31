<?php
/**
 * Copyright © 2016 Jake Sharp (http://www.jakesharp.co/) All rights reserved.
 */

namespace JakeSharp\Productslider\Model\Slider\Grid;

/**
 * To option slider locations array
 * @return array
 */
class Location implements \Magento\Framework\Option\ArrayInterface{

    public function toOptionArray(){
        return \JakeSharp\Productslider\Model\Productslider::getSliderGridLocations();
    }
}
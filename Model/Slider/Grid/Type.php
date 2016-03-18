<?php

namespace JakeSharp\Productslider\Model\Slider\Grid;

class Type implements \Magento\Framework\Data\OptionSourceInterface{

    //!--
    //Check if this is necessary or we can just use getSliderTypeArray function
    //!--
    public function toOptionArray(){
        return \JakeSharp\Productslider\Model\Productslider::getSliderTypeArray();
    }
}
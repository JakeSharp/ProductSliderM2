<?php

namespace JakeSharp\Productslider\Model\Slider\Grid;

class Status implements \Magento\Framework\Data\OptionSourceInterface{

    public function toOptionArray(){
        return \JakeSharp\Productslider\Model\Productslider::getStatusArray();
    }
}
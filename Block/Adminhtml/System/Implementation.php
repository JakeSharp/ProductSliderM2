<?php
/**
 * Copyright © 2016 Jake Sharp (http://www.jakesharp.co/) All rights reserved.
 */

namespace JakeSharp\Productslider\Block\Adminhtml\System;

use Magento\Framework\Data\Form\Element\AbstractElement;

class Implementation extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $html = '<div class="notices-wrapper">
                    <div class="message"><strong>'.__('Use widgets in Magento admin for custom location implementation').'</strong></div>
                    <div class="message">
                        <strong>'.__('Copy code from below to the template file (between php tags) and replace custom_slider_id with proper slider id').'</strong><br/>
                        echo $this->getLayout()->createBlock("JakeSharp\Productslider\Block\Slider\Items")->setSliderId("custom_slider_id")->toHtml();
                    </div>
                    <div class="message">
                        <strong>'.__('Copy code from below to the CMS page or block and replace custom_slider_id with proper slider id').'</strong><br/>
                        {{block class="JakeSharp\Productslider\Block\Slider\Items" slider_id="custom_slider_id"}}
                    </div>
                    <div class="message">
                        <strong>'.__('Copy code from below to the layout XML file and replace custom_slider_id with proper slider id').'</strong><br/>
                        &lt;block class="JakeSharp\Productslider\Block\Slider\Items"&gt;<br/>
                           &nbsp;&nbsp;&lt;action method="setSliderId"&gt;<br/>
                               &nbsp;&nbsp;&nbsp;&nbsp;&lt;argument name="sliderId" xsi:type="string"&gt;your_slider_id&lt;/argument&gt;<br/>
                           &nbsp;&nbsp;&lt;/action&gt;<br/>
                        &lt;/block>
                    </div>
                </div>';

        return $html;

    }
}
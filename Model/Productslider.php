<?php
/**
 * Copyright © 2016 Jake Sharp (http://www.jakesharp.co/) All rights reserved.
 */

namespace JakeSharp\Productslider\Model;

/**
 * Productslider model
 * @package JakeSharp\Productslider\Model
 */
class Productslider extends \Magento\Framework\Model\AbstractModel {

    /**
     * Slider statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * Slider types
     */
    const SLIDER_TYPE_DEFAULT = "";
    const SLIDER_TYPE_NEW = 'new';
    const SLIDER_TYPE_BESTSELLERS = 'bestsellers';
    const SLIDER_TYPE_MOSTVIEWED = 'mostviewed';
    const SLIDER_TYPE_ONSALE = 'onsale';
    const SLIDER_TYPE_FEATURED = 'featured';
    const SLIDER_TYPE_AUTORELATED = 'autorelated';

    /**
     * Slider locations/positions displayed on frontend
     */
    const SLIDER_LOCATION_DEFAULT = "";
    const HOMEPAGE_CONTENT_TOP = 'homepage-content-top';
    const HOMEPAGE_CONTENT_BOTTOM = 'homepage-content-bottom';
    const CONTENT_TOP = 'content-top';
    const CONTENT_BOTTOM = 'content-bottom';
    const SIDEBAR_ADDITIONAL_TOP = 'sidebar-additional-top';
    const SIDEBAR_ADDITIONAL_BOTTOM = 'sidebar-additional-bottom';
    const CATEGORY_CONTENT_TOP = 'category-content-top';
    const CATEGORY_CONTENT_BOTTOM = 'category-content-bottom';
    const CATEGORY_SIDEBAR_ADDITIONAL_TOP = 'category-sidebar-additional-top';
    const CATEGORY_SIDEBAR_ADDITIONAL_BOTTOM = 'category-sidebar-additional-bottom';
    const PRODUCT_CONTENT_TOP = 'product-content-top';
    const PRODUCT_CONTENT_BOTTOM = 'product-content-bottom';
    const PRODUCT_SIDEBAR_ADDITIONAL_TOP = 'product-sidebar-additional-top';
    const PRODUCT_SIDEBAR_ADDITIONAL_BOTTOM = 'product-sidebar-additional-bottom';
    const CART_CONTENT_TOP = 'cart-content-top';
    const CART_CONTENT_BOTTOM = 'cart-content-bottom';
    const CHECKOUT_CONTENT_TOP = 'checkout-content-top';
    const CHECKOUT_CONTENT_BOTTOM = 'checkout-content-bottom';
    const CUSTOMER_CONTENT_TOP = 'customer-content-top';
    const CUSTOMER_CONTENT_BOTTOM = 'customer-content-bottom';
    const CUSTOMER_SIDEBAR_ADDITIONAL_TOP = 'customer-sidebar-additional-top';
    const CUSTOMER_SIDEBAR_ADDITIONAL_BOTTOM = 'customer-sidebar-additional-bottom';

    /**
     * Set resource class
     */
    protected function _construct()
    {
        $this->_init('JakeSharp\Productslider\Model\ResourceModel\Productslider');
    }

    /**
     * Slider statuses
     *
     * @var array
     */
    protected static $statusOptions = [
        self::STATUS_ENABLED => 'Enabled',
        self::STATUS_DISABLED => 'Disabled',
    ];

    /**
     * Slider types
     *
     * @var array
     */
    protected static $sliderTypes = [
        self::SLIDER_TYPE_DEFAULT => '--- Select Slider Type --',
        self::SLIDER_TYPE_NEW => 'New Products',
        self::SLIDER_TYPE_BESTSELLERS => 'Bestselers Products',
        self::SLIDER_TYPE_MOSTVIEWED => 'Most Viewed Products',
        self::SLIDER_TYPE_ONSALE => 'On Sale Products',
        self::SLIDER_TYPE_FEATURED => 'Featured Products',
        self::SLIDER_TYPE_AUTORELATED => 'Auto Related Products',
    ];

    /**
     * Formatted slider locations
     * @return array
     */
    public static function getSliderLocations()
    {
        return [
            ['label' => __('--- Select Slider Location --') , 'value' => self::SLIDER_LOCATION_DEFAULT ],
            ['label' => __('Home page'), 'value' => [
                    ['label' => __('Homepage Content Top'), 'value' => self::HOMEPAGE_CONTENT_TOP],
                    ['label' => __('Homepage Content Bottom'), 'value' => self::HOMEPAGE_CONTENT_BOTTOM],
                ]
            ],
            ['label' => __('Display on all pages'), 'value' =>  [
                    ['label' => __('Content Top'), 'value' => self::CONTENT_TOP],
                    ['label'  => __('Content Bottom'), 'value' => self::CONTENT_BOTTOM],
                    ['label'  => __('Sidebar Additional Top'), 'value' => self::SIDEBAR_ADDITIONAL_TOP],
                    ['label'  => __('Sidebar Additional Bottom'), 'value' => self::SIDEBAR_ADDITIONAL_BOTTOM],
                ]
            ],
            ['label' => __('Category page'), 'value' => [
                    ['label' => __('Category Content Top'), 'value' => self::CATEGORY_CONTENT_TOP],
                    ['label' => __('Category Content Bottom'), 'value' => self::CATEGORY_CONTENT_BOTTOM],
                    ['label' => __('Category Sidebar Additional Top'), 'value' => self::CATEGORY_SIDEBAR_ADDITIONAL_TOP],
                    ['label' => __('Category Sidebar Additional Bottom'), 'value' => self::CATEGORY_SIDEBAR_ADDITIONAL_BOTTOM],
                ]
            ],
            ['label' => __('Product page'), 'value' => [
                    ['label' => __('Product Content Top'), 'value' => self::PRODUCT_CONTENT_TOP],
                    ['label' => __('Product Content Bottom'), 'value' => self::PRODUCT_CONTENT_BOTTOM],
                    ['label' => __('Product Sidebar Additional Top'), 'value' => self::PRODUCT_SIDEBAR_ADDITIONAL_TOP],
                    ['label' => __('Product Sidebar Additional Bottom'), 'value' => self::PRODUCT_SIDEBAR_ADDITIONAL_BOTTOM],
                ]
            ],
            ['label' => __('Cart, checkout and customer page'), 'value' => [
                    ['label' => __('Cart Content Top'), 'value' => self::CART_CONTENT_TOP],
                    ['label' => __('Cart Content Bottom'), 'value' => self::CART_CONTENT_BOTTOM],
                    ['label' => __('Checkout Content Top'), 'value' => self::CHECKOUT_CONTENT_TOP],
                    ['label' => __('Checkout Content Bottom'), 'value' => self::CHECKOUT_CONTENT_BOTTOM],
                ]
            ],
            ['label' => __('Customer page'), 'value' => [
                    ['label' => __('Customer Content Top'), 'value' => self::CUSTOMER_CONTENT_TOP],
                    ['label' => __('Customer Content Bottom'), 'value' => self::CUSTOMER_CONTENT_BOTTOM],
                    ['label' => __('Customer Sidebar Additional Top'), 'value' => self::CUSTOMER_SIDEBAR_ADDITIONAL_TOP],
                    ['label' => __('Customer Sidebar Additional Bottom'), 'value' => self::CUSTOMER_SIDEBAR_ADDITIONAL_BOTTOM],
                ]
            ],
        ];
    }

    /**
     * Not formatted slider locations
     * @return array
     */
    public static function getSliderGridLocations()
    {
        return [
            self::SLIDER_LOCATION_DEFAULT => '--- No Location ---',
            self::HOMEPAGE_CONTENT_TOP => __('Homepage Content Top'),
            self::HOMEPAGE_CONTENT_BOTTOM => __('Homepage Content Bottom'),
            self::CONTENT_TOP => __('Content Top'),
            self::CONTENT_BOTTOM => __('Content Bottom'),
            self::SIDEBAR_ADDITIONAL_TOP => __('Sidebar Additional Top'),
            self::SIDEBAR_ADDITIONAL_BOTTOM => __('Sidebar Additional Bottom'),
            self::CATEGORY_CONTENT_TOP => __('Category Content Top'),
            self::CATEGORY_CONTENT_BOTTOM => __('Category Content Bottom'),
            self::CATEGORY_SIDEBAR_ADDITIONAL_TOP => __('Category Sidebar Additional Top'),
            self::CATEGORY_SIDEBAR_ADDITIONAL_BOTTOM => __('Category Sidebar Additional Bottom'),
            self::PRODUCT_CONTENT_TOP => __('Product Content Top'),
            self::PRODUCT_CONTENT_BOTTOM => __('Product Content Bottom'),
            self::PRODUCT_SIDEBAR_ADDITIONAL_TOP => __('Product Sidebar Additional Top'),
            self::PRODUCT_SIDEBAR_ADDITIONAL_BOTTOM => __('Product Sidebar Additional Bottom'),
            self::CART_CONTENT_TOP => __('Cart Content Top'),
            self::CART_CONTENT_BOTTOM => __('Cart Content Bottom'),
            self::CHECKOUT_CONTENT_TOP => __('Checkout Content Top'),
            self::CHECKOUT_CONTENT_BOTTOM => __('Checkout Content Bottom'),
            self::CUSTOMER_CONTENT_TOP => __('Customer Content Top'),
            self::CUSTOMER_CONTENT_BOTTOM => __('Customer Content Bottom'),
            self::CUSTOMER_SIDEBAR_ADDITIONAL_TOP => __('Customer Sidebar Additional Top'),
            self::CUSTOMER_SIDEBAR_ADDITIONAL_BOTTOM => __('Customer Sidebar Additional Bottom'),
        ];
    }

    /**
     * Slider statuses
     * @return array
     */
    public static function getStatusArray()
    {
        return self::$statusOptions;
    }

    /**
     * Slider types
     * @return array
     */
    public static function getSliderTypeArray()
    {
        return self::$sliderTypes;
    }

    /**
     * Slider statuses label
     * @return array
     */
    public function getStatusLabel()
    {
        return self::$statusOptions[$this->getStatus()];
    }

    /**
     * Slider types label
     * @return array
     */
    public function getSliderTypeLabel()
    {
        return self::$sliderTypes[$this->getType()];
    }

    /**
     * Additional products for current slider
     * @return array
     */
    public function getSelectedSliderProducts()
    {
        if (!$this->getSliderId()) {
            return [];
        }

        $array = $this->getData('slider_products');
        if ($array === null) {
            $array = $this->getResource()->getSliderProducts($this);
            $this->setData('slider_products', $array);
        }
        return $array;
    }
}

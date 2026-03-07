<?php

namespace Breakdance\DynamicData;

class WoocommerceProductPrice extends StringField {

    /**
     * @inheritDoc
     */
    public function label()
    {
        return __('Product Price', 'breakdance');
    }

    /**
     * @inheritDoc
     */
    public function category()
    {
        return __('WooCommerce', 'breakdance');
    }

    /**
     * @inheritDoc
     */
    public function slug()
    {
        return 'product_price';
    }

    /**
     * @inheritDoc
     */
    public function controls()
    {
        return [
            \Breakdance\Elements\control('product', __('Product', 'breakdance'), [
                    'type' => 'post_chooser',
                    'layout' => 'vertical',
                    'postChooserOptions' => [
                        'multiple' => false,
                        'showThumbnails' => false,
                        'postType' => 'Product'
                    ]
                ]
            ),
            \Breakdance\Elements\control('price_type', __('Price Type', 'breakdance'), [
                'type' => 'dropdown',
                'layout' => 'vertical',
                'items' => array_merge([
                    ['text' => __('Regular Price', 'breakdance'), 'value' => 'regular'],
                    ['text' => __('Sale Price', 'breakdance'), 'value' => 'sale'],
                ])
            ]),
        ];
    }

    public function defaultAttributes()
    {
        return [
            'price_type' => 'regular'
        ];
    }

    /**
     * @inheritDoc
     */
    public function handler($attributes): StringData
    {
        global $post;
        $productId = $post->ID ?? null;
        if (!empty($attributes['product'])) {
            $productId = $attributes['product'];
        }
        $product = wc_get_product($productId);

        if (!$product) {
            return StringData::emptyString();
        }

        return StringData::fromString($product->get_price_html());
    }
}

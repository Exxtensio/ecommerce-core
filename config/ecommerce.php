<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Available Columns Type
    |--------------------------------------------------------------------------
    |
    | Follow links below to know more about column types.
    |
    | id        https://laravel.com/docs/11.x/migrations#column-method-id
    | ulid      https://laravel.com/docs/11.x/migrations#column-method-ulid
    | uuid      https://laravel.com/docs/11.x/migrations#column-method-uuid
    |
    */
    'migration' => [
        /*
        |--------------------------------------------------------------------------
        | Primary Key
        |--------------------------------------------------------------------------
        |
        | This option determines the primary key type of all package's tables.
        |
        | Available types: "id", "ulid" (recommended), "uuid",
        |
        */
        'primary' => 'ulid',
        'customer_table' => [
            'model' => \Sambu\Ecommerce\Models\Customer::class,
        ],
        'product_brand_table' => [
            'name' => 'product_brands'
        ],
        'product_category_table' => [
            'name' => 'product_categories'
        ],
        'product_attribute_table' => [
            'name' => 'product_attributes'
        ],
        'product_review_table' => [
            'name' => 'product_reviews'
        ],
        'product_table' => [
            'name' => 'products',
            'status_default' => 'active',
        ],
        'product_price_table' => [
            'name' => 'product_prices',
            'price_decimal_total' => 8,
            'price_decimal_places' => 2,
        ],
        'product_stock_table' => [
            'name' => 'product_stocks',
            'stock_decimal_total' => 8,
            'stock_decimal_places' => 1,
        ],
        'product_image_table' => [
            'name' => 'product_images'
        ],
        'cart_table' => [
            'name' => 'carts'
        ],
        'cart_item_table' => [
            'name' => 'cart_items'
        ],
        'order_table' => [
            'name' => 'orders',
            'amount_decimal_total' => 8,
            'amount_decimal_places' => 2,
            'status_default' => 'new',
            'payment_status_default' => 'processing',
        ],
        'order_item_table' => [
            'name' => 'orders_items'
        ],
        'currency_table' => [
            'name' => 'currencies',
        ],
        'country_table' => [
            'name' => 'countries'
        ]
    ],
    'routes' => [
        'web' => [
            'middlewares' => [
                'web'
            ]
        ],
        'api' => [
            'prefix' => env('ECOMMERCE_API_PREFIX', 'api'),
            'middlewares' => [
                'auth:sanctum',
                'ecommerce-response'
            ]
        ]
    ],
    'default' => [
        'country' => env('ECOMMERCE_DEFAULT_COUNTRY', 'US'),
        'currency' => env('ECOMMERCE_DEFAULT_CURRENCY', 'USD'),
    ],
    'artisan' => [
        'email' => env('ECOMMERCE_ARTISAN_EMAIL'),
        'name' => env('ECOMMERCE_ARTISAN_NAME'),
        'password' => env('ECOMMERCE_ARTISAN_PASSWORD'),
    ],
    'exchangerateApiKey' => env('ECOMMERCE_EXCHANGERATE_API_KEY'),
    /*
    |--------------------------------------------------------------------------
    | Frequency
    |--------------------------------------------------------------------------
    |
    | This option determines the frequency of updating the currency rate against the dollar.
    |
    | Available frequencies: "daily", "weekly",
    |
    */
    'rateUpdateFrequency' => env('ECOMMERCE_RATE_UPDATE_FREQUENCY', 'weekly'),
];

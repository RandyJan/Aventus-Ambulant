<?php

return [

    'admin' => [
        'password' => env('ADMIN_PASSWORD', 'p@$$w0rd')
    ],

    'default_product_image' => env('DEFAULT_PRODUCT_IMAGE', '/assets/default-product.png'),

    'stores' => env('STORES_CODE', 'LOC'),

    'servery_link' => env('SERVERY_LINK', 'https://example.com'),

    'show_screen_guide' => env('SHOW_SCREEN_GUIDE', false),

    // shell_ambulant | restaurant_ambulant | invoicer_ambulant
    'app_type' => env('APP_TYPE', 'restaurant_ambulant'),

    'work_shifting' => env('WORK_SHIFTING', false),

    'customer_display' => env('CUSTOMER_DISPLAY', false),

    'plate_number_entry' => env('PLATE_NUMBER_ENTRY', false),

    'table_assignment' => env('TABLE_ASSIGNMENT',true),


    'service_charge' => env('SERVICE_CHARGE', true),

    // 1 = "DINE IN" , 2 = "TAKE OUT"
    'default_order_type' => env('DEFAULT_ORDER_TYPE', 1),

    'esc_printer' => [
        'max_length' => env('PRINTER_PAPER_LENGTH', 58),
        // NETWORK | LOCAL
        'type' => env('PRINTER_TYPE', 'NETWORK'),
        //  IF LOCAL put the name of printer, if NETWORK put the ip of printer
        'address' => env('PRINTER_ADDRESS'),
        'port' => env('PRINTER_PORT', 9100),
    ]
];

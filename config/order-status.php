<?php

    return [
        "order_status_admin" => [
            'pending' => [
                'status' => 'Pending',
                'details' => 'Your order is currently pending'
            ],
            'processed_and_ready_to_ship' => [
                'status' => 'Processed and ready to ship',
                'details' => 'Your package has been processed and will be with our delivery partner soon'
            ],
            'dropped_off' => [
                'status' => 'Dropped Off',
                'details' => 'Your package has been dropped of by the seller'
            ],
            'shipped' => [
                'status' => 'Shipped',
                'details' => 'Your package has arrived at our logistics facility'
            ],
            'out_for_delivery' => [
                'status' => 'Out for Delivery',
                'details' => 'Our delivery partner will attempt to deliver your package'
            ],
            'delivered' => [
                'status' => 'Delivered',
                'details' => 'Delivered'
            ],
            'cancelled' => [
                'status' => 'Cancelled',
                'details' => 'Cancelled'
            ],
        ],
        "order_status_vendor" => [
            'pending' => [
                'status' => 'Pending',
                'details' => 'Your order is currently pending'
            ],
            'processed_and_ready_to_ship' => [
                'status' => 'Processed and ready to ship',
                'details' => 'Your package has been processed and will be with our delivery partner soon'
            ],
        ]

    ];
<?php

return [
    'name' => 'Status',
    'available' => [
        ['type' => 'shipment_type', 'name' => 'Picking', 'code' => 1],
        ['type' => 'shipment_type', 'name' => 'Double counting', 'code' => 2],
        ['type' => 'shipment_type', 'name' => 'Loading', 'code' => 3],
        ['type' => 'shipment_type', 'name' => 'Finish loading', 'code' => 13],
        ['type' => 'shipment_status', 'name' => 'Released', 'code' => 4],
        ['type' => 'shipment_status', 'name' => 'Waiting', 'code' => 5],
        ['type' => 'shipment_status', 'name' => 'Loading', 'code' => 6],
        ['type' => 'shipment_status', 'name' => 'Not directed', 'code' => 7],
        ['type' => 'shipment_status', 'name' => 'Directed', 'code' => 8],
        ['type' => 'invoice', 'name' => 'Waiting', 'code' => 9],
        ['type' => 'invoice', 'name' => 'Emitting', 'code' => 10],
        ['type' => 'invoice', 'name' => 'Issued', 'code' => 11],
        ['type' => 'invoice', 'name' => 'Released', 'code' => 12],
    ],
];

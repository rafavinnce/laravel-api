<?php

return [
    'name' => 'Shipment',
    'permissions' => [
        ['name' => 'shipments.index', 'title' => 'List shipments'],
        ['name' => 'shipments.show', 'title' => 'Show shipment'],
        ['name' => 'shipments.store', 'title' => 'Create shipment'],
        ['name' => 'shipments.update', 'title' => 'Update shipment'],
        ['name' => 'shipments.destroy', 'title' => 'Delete shipment'],

        ['name' => 'steps.index', 'title' => 'List steps'],
        ['name' => 'steps.show', 'title' => 'Show step'],
        ['name' => 'steps.store', 'title' => 'Create step'],
        ['name' => 'steps.update', 'title' => 'Update step'],
        ['name' => 'steps.destroy', 'title' => 'Delete step'],

        ['name' => 'pendency.index', 'title' => 'List pendencies'],
        ['name' => 'pendency.show', 'title' => 'Show pendency'],
        ['name' => 'pendency.store', 'title' => 'Create pendency'],
        ['name' => 'pendency.update', 'title' => 'Update pendency'],
        ['name' => 'pendency.destroy', 'title' => 'Delete pendency'],
    ],
];

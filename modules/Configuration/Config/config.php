<?php

return [
    'name' => 'Configuration',
    'permissions' => [
        ['name' => 'configurations.index', 'title' => 'List configurations'],
        ['name' => 'configurations.show', 'title' => 'Show configuration'],
        ['name' => 'configurations.store', 'title' => 'Create configuration'],
        ['name' => 'configurations.update', 'title' => 'Update configuration'],
        ['name' => 'configurations.destroy', 'title' => 'Delete configuration'],
    ],
    'available' => [
        ['title' => 'Regressive counter', 'name' => 'regressive-counter', 'type' => null],
        ['title' => 'Stop alerts', 'name' => 'stop-alerts', 'type' => null],
        ['title' => 'Meal interval', 'name' => 'meal-interval', 'type' => null],
    ],
];

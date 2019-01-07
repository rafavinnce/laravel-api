<?php

return [
    'name' => 'User',
    'permissions' => [
        ['name' => 'users.index', 'title' => 'List users'],
        ['name' => 'users.show', 'title' => 'Show user'],
        ['name' => 'users.store', 'title' => 'Create user'],
        ['name' => 'users.update', 'title' => 'Update user'],
        ['name' => 'users.destroy', 'title' => 'Delete user'],
    ],
];

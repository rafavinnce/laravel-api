<?php

return [
    'name' => 'Notification',
    'permissions' => [
        ['name' => 'notification.notifications.index', 'title' => 'List notifications'],
        ['name' => 'notification.notifications.show', 'title' => 'Show notification'],
        ['name' => 'notification.notifications.destroy', 'title' => 'Delete notification'],

        ['name' => 'notification.comments.index', 'title' => 'List comments'],
        ['name' => 'notification.comments.show', 'title' => 'Show comment'],
        ['name' => 'notification.comments.store', 'title' => 'Create comment'],
        ['name' => 'notification.comments.update', 'title' => 'Update comment'],
        ['name' => 'notification.comments.destroy', 'title' => 'Delete comment'],
    ],
];

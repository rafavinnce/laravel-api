<?php

namespace Modules\Notification\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Notification\Entities\Comment;
use Modules\Notification\Entities\Notification;

class NotificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Notification::class, 25)->create()->each(function (Notification $e) {
            $e->comments()->save(factory(Comment::class)->make());
        });
    }
}

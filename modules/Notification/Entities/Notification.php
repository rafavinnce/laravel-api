<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notification_notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'message', 'type', 'extra',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'extra' => 'array',
    ];

    /**
     * Get the comments for the notification.
     */
//    public function comments()
//    {
//        return $this->hasMany(Comment::class, 'notification_id', 'id')->orderBy('created_at', 'desc');
//    }

    /**
     * Get the comments for the notification.
     */
    public function comments()
    {
        return $this->morphMany(\Modules\Comment\Entities\Comment::class, 'commentable');
    }
}

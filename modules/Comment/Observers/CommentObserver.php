<?php

namespace Modules\Comment\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Comment\Entities\Comment;

class CommentObserver
{
    /**
     * Handle the comment "creating" event.
     *
     * @param Comment $comment
     * @return void
     */
    public function creating(Comment $comment)
    {
        if (Auth::check()) {
            $comment->user_id = Auth::id();
        }
    }
}
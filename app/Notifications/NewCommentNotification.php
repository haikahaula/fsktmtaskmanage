<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
{
    use Queueable;

    public $comment;
    public $task;

    public function __construct($comment, $task)
    {
        $this->comment = $comment;
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['database']; // Save in database
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Comment on Task',
            'message' => $this->comment->user->name . ' commented on "' . $this->task->title . '"',
            'task_id' => $this->task->id,
        ];
    }
}

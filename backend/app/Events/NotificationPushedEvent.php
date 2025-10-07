<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationPushedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct($model, $message, $permissions, $subject_id)
    {
        Notification::query()->create([
            'model' => $model,
            'message' => $message,
            'permissions' => $permissions,
            'subject_id' => $subject_id,
        ]);
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('applicationChannel'),
        ];
    }
}

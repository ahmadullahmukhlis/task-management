<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $task;

    public function __construct($task)
    {
        $this->task = $task;

    }

    public function broadcastOn(): array
    {
        // Public channel for now (you can switch to Private if you want auth)
        return [new Channel('add-task')];
    }

    public function broadcastAs(): string
    {
        return 'TaskEvent'; // frontend will listen for this
    }
}

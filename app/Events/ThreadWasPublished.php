<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ThreadWasPublished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The thread that was published.
     *
     * @var \App\Thread
     */
    public $thread;
    /**
     * Create a new event instance.
     *
     * @param \App\Thread $thread
     * @return void
     */

    public function __construct($thread)
    {
        $this->thread = $thread;
    }
    
    /**
     * Get the subject of the event.
     */
    public function subject()
    {
        return $this->thread;
    }
}

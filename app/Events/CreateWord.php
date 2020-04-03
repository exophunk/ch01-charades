<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateWord implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $word;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($word)
    {
        $this->word = $word;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('room.' . $this->word->room_id);
    }
}

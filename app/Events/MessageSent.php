<?php

namespace App\Events;

use App\Models\RoomMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $room_messages;
    public $room_id;
    public $check;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($room_messages, $room_id, $check)
    {
        //
        $this->room_messages = $room_messages;
        $this->room_id = $room_id;
        $this->check = $check;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('room.'.$this->room_id);
    }

}

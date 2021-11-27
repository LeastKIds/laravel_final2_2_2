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

    public $room_message;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(RoomMessage $room_message, $message)
    {
        //
        $this->room_message = $room_message;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('room.'.$this->room_message->room_id);
    }

//    public function broadcastAs(){
//        return 'message.new';
//    }


}

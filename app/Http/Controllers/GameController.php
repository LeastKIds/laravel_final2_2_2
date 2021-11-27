<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Room;
use App\Models\RoomMessage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GameController extends Controller
{
    //

    public function store(Request $request) {

        if(!($request -> name)) {
            return Inertia::render('Error/Error_BadConnection');
        }

        if(RoomMessage::where('user_id',auth() -> user() -> id) -> exists()) {
            $room = RoomMessage::where('user_id', auth() -> user() -> id) -> first();
            $room_id = $room -> id;
            return ['success' => 0, 'message' =>'이미 들어가 있는 방이 있습니다.', 'room_id' => $room_id];
        }


        $room = new Room();
        $room -> name = $request -> name;
        $room -> admin = auth() -> user() -> id;
        $room -> save();

        $room_message = new RoomMessage();
        $room_message -> user_id = auth() -> user() ->id;
        $room_message -> room_id = $room -> id;
        $room_message -> save();


        return ['success' => 1, 'message' =>'성공하셨습니다.', 'room' => $room];

    }


    public function send_messages(Request $request, $room_id) {

        if(RoomMessage::where('user_id',auth() -> user() -> id)
            -> where('room_id',$room_id) -> doesntExist())
            return ['success' => 0, 'message' =>'잘못된 접근'];

        $room_message = RoomMessage::where('room_id' , $room_id) -> first();

//        broadcast(new MessageSent($room_message, $request->message)) -> toOthers();
        MessageSent::dispatch($room_message, $request -> message);

        return ['success' => 1, 'message' =>'메세지 전송 성공'];
    }
}

<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Quizlet;
use App\Models\Room;
use App\Models\RoomMessage;
use App\Models\Voca;
use App\Models\Word;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GameController extends Controller
{
    //

    public function index() {
        $rooms = Room::with('room_messages') -> latest() -> paginate(12);

        return ['success' => 1, 'message' =>'성공', 'rooms' => $rooms];
    }



    public function store(Request $request) {

        if(!($request -> name)) {
            return Inertia::render('Error/Error_BadConnection');
        }
        if(!($request -> voca_id))
            return Inertia::render('Error/Error_BadConnection');


        if(RoomMessage::where('user_id',auth() -> user() -> id) -> exists()) {
            $room = RoomMessage::where('user_id', auth() -> user() -> id) -> first();
            $room_id = $room -> id;
            return ['success' => 0, 'message' =>'이미 들어가 있는 방이 있습니다. 위쪽의 참가참가를 눌러주세요', 'room_id' => $room_id];
        }


        $room = new Room();
        $room -> name = $request -> name;
        $room -> admin = auth() -> user() -> id;
        $room -> voca_id = $request -> voca_id;
        $room -> save();


        $room_message = new RoomMessage();
        $room_message -> user_id = auth() -> user() ->id;
        $room_message -> room_id = $room -> id;
        $room_message -> save();





        return ['success' => 1, 'message' =>'성공하셨습니다.', 'room' => $room];
//        return redirect('/game/create/'.$room -> id);

    }


    public function send_messages(Request $request, $room_id) {

        if(RoomMessage::where('user_id',auth() -> user() -> id)
            -> where('room_id',$room_id) -> doesntExist())
            return ['success' => 0, 'message' =>'잘못된 접근'];

        $room_message = RoomMessage::where('room_id' , $room_id)
            -> where('user_id',auth() -> user() -> id) ->first();

        $room_message -> message = $request -> message;
        $room_message -> save();

        $room_messages = RoomMessage::where('room_id' , $room_id) -> get();
//        $room_messages = RoomMessage::find(1);
//        $abc = RoomMessage::find(1);
//        broadcast(new MessageSent($room_message, $request->message)) -> toOthers();
        MessageSent::dispatch($room_messages, $room_id, 1);
        $room_message -> message = null;
        $room_message -> save();

        return ['success' => 1, 'message' =>'메세지 전송 성공'];
    }

    public function member($room_id) {
        $room_message = RoomMessage::where('room_id' ,$room_id) -> with('user') -> get();

        return ['success' => 1, 'message' =>'멤버 체크 확인', 'users' => $room_message];
    }

    public function destroy($room_id) {

        if(RoomMessage::where('user_id',auth() -> user() -> id)
            -> where('room_id',$room_id) -> doesntExist())
            return ['success' => 0, 'message' =>'잘못된 접근'];

        $room_message = RoomMessage::where('user_id',auth() -> user() -> id)
            -> where('room_id',$room_id) -> first();
        $room_message -> delete();

        $room = Room::find($room_id);
        if($room -> admin == auth() -> user() -> id) {
            $room -> delete();
            MessageSent::dispatch('', $room_id, 3);
        } else{
            MessageSent::dispatch('', $room_id, 0);
        }


        return ['success' => 1, 'message' =>'성공적으로 삭제'];
    }

    public function member_check($room_id) {
        $room_message = RoomMessage::where('room_id', $room_id) -> get();
        $room_member = $room_message -> count();

        if($room_member >= 4)
            return ['success'=> 0, 'message' => '인원 초과!'];
        else
            return ['success'=> 1, 'message' => '어서오세요!'];
    }

    public function timer() {
        $time = now();

        return time();
    }

    public function game_start(Request $request, $room_id) {
        $room = Room::find($room_id);
        if($room -> admin != auth() -> user() -> id)
            return ['success'=> 0, 'message' => '방장이 아니야!'];

        $quiz = Word::where('voca_id',$room -> voca_id) -> inRandomOrder()->get();




        foreach($quiz as $q) {
            $n = rand(1,3);
            $quizlet = new Quizlet();


            if($n === 1) {
                dd('이 컴퓨터는 해킹당했습니다.');
            }
        }


        return $n;
    }
}

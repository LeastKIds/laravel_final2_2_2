<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Room;
use App\Models\RoomMessage;
use App\Models\Voca;
use App\Models\Word;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MainPageController extends Controller
{
    //

    public function index() {
        return Inertia::render('Main/Main');
    }

    public function index_my() {
        return Inertia::render('Main/MyVoca');
    }

    public function index_words($id) {
        $user_id = auth() -> user() -> id;
        if(Voca::where('id', $id) -> doesntExist()) {
            return Inertia::render('Error/Error_404');
        }
        $voca = Voca::find($id);
        if($voca -> user_id != $user_id)
            return Inertia::render('Error/Error_404');

        $words = Word::where('voca_id', $id) -> get();

        return Inertia::render('Main/CreateWords', ['voca' => $voca, 'words' => $words]);
    }

    public function index_other() {

        return Inertia::render('Main/OtherVoca');
    }

    public function index_other_words($voca_id) {
        $voca = Voca::find($voca_id);
        if($voca -> open == 0)
            return Inertia::render('Error/Error_BadConnection');

        $words = Word::where('voca_id', $voca_id) ->get();

        $id = auth() -> user() -> id;
        if($voca -> user_id == $id)
            return Inertia::render('Main/CreateWords',['voca' => $voca, 'words' => $words]);
        else
            return Inertia::render('Main/OtherVocaView', ['voca' => $voca, 'words' => $words]);
    }

    public function index_game($room_id) {

//        if(RoomMessage::where('room_id', $room_id) -> where('user_id', auth() -> user() -> id)  -> doesntExist())
//            return Inertia::render('Error/Error_BadConnection');
        if(Room::where('id',$room_id) -> doesntExist())
            return Inertia::render('Error/Error_BadConnection');
        $room = Room::find($room_id);


        if(RoomMessage::where('user_id',auth() -> user() -> id) -> doesntExist()) {
            $room_message = new RoomMessage();
            $room_message -> user_id = auth() -> user() ->id;
            $room_message -> room_id = $room -> id;
            $room_message -> save();
        }


        $users = RoomMessage::where('room_id', $room_id) -> with('user') -> get();
        MessageSent::dispatch($users, $room_id, 0, $room);


        return Inertia::render('Main/GameRoom', ['users' => $users, 'room'=>$room]);
    }

    public function index_game_list() {

        if(RoomMessage::where('user_id', auth() -> user() -> id) -> exists()) {
            $room_message = RoomMessage::where('user_id', auth() -> user() -> id) -> first();
            $room_id = $room_message -> room_id;
            $url = '/game/'.$room_id;
            return redirect($url);
        }

        $rooms = Room::with('room_messages') -> latest() -> paginate(12);
        return Inertia::render('Main/GameRoomSelect', ['rooms' => $rooms]);
    }

    public function index_game_enter($room_id) {
        if(RoomMessage::where('room_id', $room_id) -> doesntExist()) {
            return Inertia::render('Error/Error_BadConnection');
        }

        $room_message = RoomMessage::where('room_id', $room_id) -> get();
        $room_member = $room_message -> count();
        if($room_member > 4) {

        }

        return ['success' => 1, 'room_message' => $room_message -> count()];
    }

    public function index_help() {
        return Inertia::render('Main/Help');
    }
}

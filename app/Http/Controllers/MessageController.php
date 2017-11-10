<?php
/**
 * Created by PhpStorm.
 * User: anil
 * Date: 9/29/17
 * Time: 1:24 PM
 */

namespace App\Http\Controllers;
use App\Model\Advert;
use App\Model\Message;
use App\Model\Room;
use App\Model\Sale;
use GuzzleHttp\Pool;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

use Ramsey\Uuid\Uuid;

class MessageController extends BaseController
{
    public function __construct()
    {

        $this->middleware('auth');
        parent::__construct();
    }
    public function messages(Request $request){
        $user = Auth::user();
        if(!$user->access_token){
            $token = $user->createToken('Message Token')->accessToken;

            $user->access_token=$token;
            $user->save();
        }


        return view('home.messages',['cur'=>$user->rooms()->first(),'user'=>$user,'leftclass'=>'left-div-noroom','rightclass'=>'right-div-noroom']);
    }

    public function rooms(Request $request,$id){

        $user = Auth::user();

        return view('home.rooms',['cur'=>Room::find($id),'user'=>$user,'leftclass'=>'left-div-noroom','rightclass'=>'right-div-noroom']);
    }
    public function gmessages(Request $request,$rid){
        $user = Auth::user();
        $room=Room::find($rid);
        if($room->last_message()->user->id!==$user->id)
        $room->read();
        if($room===null){
            return redirect('/user/manage/messages');

        }
        if(!$user->access_token){
            $token = $user->createToken('Message Token')->accessToken;

            $user->access_token=$token;
            $user->save();
        }

        return view('home.messages',['cur'=>$room,'user'=>$user,'leftclass'=>'left-div-room','rightclass'=>'right-div-room']);
    }

    public function reply(Request $request,$id){
        $user = Auth::user();
        $advert = Advert::find($id);
        if($advert===null)
        {
            $advert=Advert::where('sid',$id)->first();
        }
        $room = Room::where('advert_id',$advert->id)->where('sender_id',$user->id)->first();
        if($room!==null){
            return redirect('/user/manage/messages/' . $room->id);
        }

        return view('home.reply',['advert'=>$advert,'user'=>$user]);

    }


    public function contact_buyer(Request $request,$id){
        $user = Auth::user();
        $sale = Sale::find($id);
        $advert = $sale->advert;

        $room = Room::where('advert_id',$advert->id)->where('sender_id',$sale->user->id)->first();
        if($room!==null){
            return redirect('/user/manage/messages/' . $room->id);
        }

        return view('home.contact_buyer',['advert'=>$advert,'user'=>$user,'sale'=>$sale]);

    }
    public function send(Request $request){
        if($request->has('g-recaptcha-response')) {
            $user = Auth::user();
            $advert = Advert::find($request->id);



            $room = Room::where('advert_id',$advert->id)->where('sender_id',$user->id)->first();
            if($room===null){
                $room = new Room;
                $room->advert_id = $advert->id;
                $room->image=$advert->first_image();
                $room->title=$advert->param('title');
                $room->sender_id=$user->id;
                $room->save();
                $room->users()->save($user);
                if($user->id!==$advert->user_id)
                $room->users()->save($advert->user);
                $advert->replies++;
                $advert->save();
            }




            $message = new Message;
            $message->message=$request->message;
            $message->from_msg=$user->id;
            $message->to_msg=$advert->user_id;
            $message->room_id=$room->id;
            $message->url='';
            $message->save();



            $room->modify();

        $this->notify($room,$message);

            return redirect('/user/manage/messages/' . $room->id);
        }else{
            return redirect('/user/reply/' . $request->id);
        }

    }

    public function bsend(Request $request){
        if($request->has('g-recaptcha-response')) {
            $user = Auth::user();
            $sale = Sale::find($request->id);
            $advert = $sale->advert;



            $room = Room::where('advert_id',$advert->id)->where('sender_id',$sale->user->id)->first();
            if($room===null){
                $room = new Room;
                $room->advert_id = $advert->id;
                $room->image=$advert->first_image();
                $room->title=$advert->param('title');
                $room->sender_id=$sale->user->id;
                $room->save();
                $room->users()->save($user);
                if($sale->user->id!==$advert->user_id)
                    $room->users()->save($sale->user);
                $advert->replies++;
                $advert->save();

            }




            $message = new Message;
            $message->message=$request->message;
            $message->from_msg=$user->id;
            $message->to_msg=$sale->user->id;
            $message->room_id=$room->id;
            $message->url='';
            $message->save();


            $room->modify();

            $this->notify($room,$message);

            return redirect('/user/manage/messages/' . $room->id);
        }else{
            return redirect('/user/breply/' . $request->id);
        }

    }
    public function buyer_send(Request $request){
            $user = Auth::user();
            $sale = Sale::find($request->id);
            $advert = $sale->advert;



            $room = Room::where('advert_id',$advert->id)->where('sender_id',$sale->user->id)->first();
            if($room===null){
                $room = new Room;
                $room->advert_id = $advert->id;
                $room->image=$advert->first_image();
                $room->title=$advert->param('title');
                $room->sender_id=$sale->user->id;
                $room->save();
                $room->users()->save($user);
                if($sale->user->id!==$advert->user_id)
                    $room->users()->save($sale->user);
                $advert->replies++;
                $advert->save();

            }




            $message = new Message;
            $message->message=$request->message;
            $message->from_msg=$user->id;
            $message->to_msg=$sale->user->id;
            $message->room_id=$room->id;
            $message->url='';
            $message->save();


            $room->modify();

            $this->notify($room,$message);
            return ['msg'=>'sent','room_id'=>$room->id,'mid'=>$message->id];

    }
    public function create_message(Request $request){

        $user = Auth::user();
        $advert = Advert::find($request->id);
        if($advert===null){
            $advert = Advert::where('sid',$request->id)->first();
        }
        $room = Room::where('advert_id',$advert->id)->where('sender_id',$user->id)->first();
        if($room===null){
            $room = new Room;
            $room->advert_id = $advert->id;
            $room->image=$advert->first_image();
            $room->title=$advert->param('title');
            $room->sender_id=$user->id;
            $room->save();
            $room->users()->save($user);
            if($user->id!==$advert->user_id)
                $room->users()->save($advert->user);
            $advert->replies++;
            $advert->save();
        }




        $message = new Message;
        $message->message=$request->message;
        $message->from_msg=$user->id;
        $message->to_msg=$advert->user_id;


        $message->room_id=$room->id;
        $message->url='';
        $message->save();
        $room->modify();

        $this->notify($room,$message);




        return ['room_id'=>$room->id,'msg'=>'sent','mid'=>$message->id];

    }

    public function normal_message(Request $request){


        $user = Auth::user();
        $room = Room::find($request->id);
        $advert=$room->advert;

        $message = new Message;
        $message->message=$request->message;
        $message->from_msg=$user->id;
        $message->to_msg=$advert->user_id;
        $message->room_id=$room->id;
        if($request->has('url')){
            $message->url=$request->url;
        }
        if($request->has('type')){
            $message->url=$request->type;
        }
        $message->save();

        $room->modify();
        $this->notify($room,$message);

        return ['mid'=>$message->id,'msg'=>'sent','message'=>$message];

    }
    public function room(Request $request,$id){
        $room =  Room::find($id);
        $room->users=$room->users()->pluck('user_id')->toArray();
        return $room;
    }
    public function create_call(Request $request){
        $advert=Advert::find($request->id);
        $user = Auth::user();

        $room = Room::where('advert_id',$advert->id)->where('sender_id',$user->id)->first();
        if($room===null){
            $room = new Room;
            $room->advert_id = $advert->id;
            $room->image=$advert->first_image();
            $room->title=$advert->param('title');
            $room->sender_id=$user->id;
            $room->save();
            $room->users()->save($user);
            if($user->id!==$advert->user_id)
                $room->users()->save($advert->user);
            $advert->replies++;
            $advert->save();
        }




        $message = new Message;
        $message->message='Call';
        $message->from_msg=$user->id;
        $message->to_msg=$advert->user_id;
        $message->room_id=$room->id;
        $message->url='';
        $message->save();
        $room->modify();

        foreach ($room->users as $usr) {
            if ($usr->id !== $user->id) {
                foreach ($usr->android as $token) {
                    $this->android_call($token, ['title' => $advert->param('title'), 'subtitle' => $usr->name, 'group' => $request->group, 'action' => 'call', 'video' => $request->video,'room_id'=>$room->id]);
                }
            }
        }



        return ['msg'=>'sent','room_id'=>$room->id];
    }

    public function call(Request $request){
        $user = Auth::user();

        $room = Room::find($request->id);


        $advert=$room->advert;



        $message = new Message;
        $message->message='Call';
        $message->from_msg=$user->id;
        $message->to_msg=$advert->user_id;
        $message->room_id=$room->id;
        $message->url='';
        $message->save();
        $room->modify();

        foreach ($room->users as $usr) {
            if ($usr->id !== $user->id) {
                foreach ($usr->android as $token) {
                    $this->android_call($token, ['title' => $advert->param('title'), 'subtitle' => $usr->name, 'group' => $request->group, 'action' => 'call', 'video' => $request->video,'room_id'=>$room->id]);
                }
            }
        }



        return ['msg'=>'sent','room_id'=>$room->id];
    }
    public function end_call(Request $request){
        $user = Auth::user();

        $room = Room::find($request->id);



        foreach ($room->users as $usr) {
            if ($usr->id !== $user->id) {
                foreach ($usr->android as $token) {
                    $this->android_call($token, [  'action' => 'end','room_id'=>$room->id]);
                }
            }
        }






        return ['msg'=>'sent'];
    }

    public function all_messages(Request $request){
        $user = Auth::user();
        $rooms = $user->rooms()->pluck('room_id')->toArray();
        if($request->has('time')){
            $x=date('Y-m-d H:i:s',$request->time);
            $messages = Message::where('created_at','>',$x)->whereIn('room_id',$rooms)->get();

        }else{
            $messages = Message::whereIn('room_id',$rooms)->get();

        }
        $msgs = [];
        foreach ($messages as $message){
            $message->room = $message->room;
            $msgs[]=$message;
        }

         return $msgs;

    }
    public function all_rooms(Request $request){
        $user = Auth::user();
        return $user->rooms;
    }

        public function rsend(Request $request){
        if($request->has('g-recaptcha-response')){
            $user = Auth::user();

            $room = Room::find($request->rid);

            $advert=$room->advert;

            $message = new Message;
            $message->message=$request->message;
            $message->from_msg=$user->id;
            $message->to_msg=$advert->user_id;
            $message->room_id=$room->id;
            if($request->has('url')){
                $message->url=$request->url;
            }

            $message->save();

            $room->modify();
            $this->notify($room,$message);



        }

        return redirect('/user/manage/messages/'.$request->rid);

    }


}
<?php
/**
 * Created by PhpStorm.
 * User: sumra
 * Date: 21/09/2017
 * Time: 15:21
 */

namespace App\Http\Controllers;

use App\Mail\PayInvoice;
use App\Model\Address;
use App\Model\Business;
use App\Model\Pack;
use App\Model\Payment;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use PDF;
use Illuminate\Support\Facades\Mail;

use App\Model\Contract;
use App\Model\ContractPack;
use App\Model\EmailCode;
use App\Model\ExtraPrice;
use App\Model\ExtraType;
use App\Model\Location;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\Price;
use Illuminate\Http\Request;
use App\Model\Category;
use App\Model\Advert;
use Illuminate\Support\Facades\Auth;
class BusinessController extends BaseController
{
    public function myads(Request $request){
        $user = Auth::user();

        $milliseconds = round(microtime(true) * 1000);
        foreach ($user->adverts as $advert){
            $advert->category_id=$advert->param('category');
            $advert->save();
        }

        return view('business.ads',['mill'=>$milliseconds,'user'=>$user]);
    }
    public function finance(Request $request){
        $user = Auth::user();
        return view('business.finance',['user'=>$user]);

    }
    public function details(Request $request){
        $user = Auth::user();
        $stripe_id = $user->stripe_id;

        try{
            $cards = \Stripe\Customer::retrieve($stripe_id)->sources->all(array(
                'limit' => 10, 'object' => 'card'));
            $cards = $cards['data'];

        }catch (\Exception $exception){
            $cards = [];
        }

        return view('business.details',['user'=>$user,'cards'=>$cards]);

    }
    public function company(Request $request){
        $user = Auth::user();
        return view('business.company',['user'=>$user]);

    }
    public function metrics(Request $request){
        $user = Auth::user();
        return view('business.metrics',['user'=>$user]);

    }
    public function support(Request $request){
        $user = Auth::user();
        return view('business.support',['user'=>$user]);

    }
    public function invoice(Request $request,$id){
        $payment=Payment::find($id);
        if($payment->status!=='pending'){
            return redirect('/business/manage/finance');
        }

        $user=Auth::user();
        $invoice = new PayInvoice();
        $invoice->payment_id=$id;
        $invoice->reference=$payment->reference;
        Mail::to($user)->send($invoice);

        $user=Auth::user();
        $order = new Order;
        $order->buyer_id = $user->id;
        $order->payment_id = $id;
        $order->type='invoice';
        $order->save();
        $request->session()->put('order_id',$order->id);
        return redirect('/user/manage/order');
    }
    public function bump(Request $request){
        $user = Auth::user();
        if(!$request->has('matrix')){
            return redirect('/business/manage/ads');
        }
        $order= new Order;
        $order->amount = 70;
        $order->type='bump';
        $order->buyer_id=$user->id;
        $order->save();
        foreach ($request->matrix as $id=>$ad) {
            $advert=Advert::find($id);
            $category = Category::find($advert->param('category'));
            $location = Location::where('res',$advert->param('location_id'))->first();

           // $extratypes = ExtraType::all();
            foreach ($ad as $key=>$val) {

                    $extraprice = ExtraPrice::where('key', $key)->first();
                    if($extraprice===null)
                        return $key.' do';
                    $orderitem = new OrderItem;
                    $orderitem->title = 'Featured';
                    $orderitem->slug = 'featured';
                    $orderitem->advert_id = $advert->id;
                    $orderitem->category_id = $category->id;
                    $orderitem->location_id = $location->id;
                    $orderitem->type_id = $extraprice->id;
                    $orderitem->amount = 0;
                    $orderitem->save();
                    $order->items()->save($orderitem);
            }
        }
        $request->session()->put('order_id', $order->id);

        return redirect('/user/manage/order');
    }
    public function __construct()
    {

        $this->middleware('auth');
        parent::__construct();
    }

}
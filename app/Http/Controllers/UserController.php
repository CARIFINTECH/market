<?php
/**
 * Created by PhpStorm.
 * User: sumra
 * Date: 05/08/2017
 * Time: 11:12
 */

namespace App\Http\Controllers;

use App\Model\Address;
use App\Model\Advert;
use App\Model\Application;
use App\Model\Category;
use App\Model\Cover;
use App\Model\Cv;
use App\Model\Favorite;
use App\Model\Featured;
use App\Model\Interest;
use App\Model\Offer;
use App\Model\Order;

use App\Model\Payment;
use App\Model\Price;
use App\Model\Report;
use App\Model\Review;
use App\Model\Shipping;
use App\Model\Spotlight;
use App\Model\Transaction;
use App\Model\Urgent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

class UserController extends BaseController
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();
            //Creating a token without scopes...
            $token = $user->createToken('Token Name')->accessToken;
            return ['token' => $token, 'id' => $user->id, 'email' => $user->email, 'name' => $user->name];
        } else {
            return ['msg' => "Invalid Credentials"];
        }
    }

    public function contract(Request $request)
    {

        $price = $this->cprice($request);
        $discounted = (int)(0.75 * $price);
        if ($discounted < 250000) {
            return ['msg' => 'Minimum £2500 is needed to start a contract'];
        }
        if (!$request->has('transaction_id')) {
            return ['msg' => '5% deposit is required to start the contract'];
        }
        $monthly = (int)(0.95 * 1.2 * $price / 12);
        foreach (range(3, 15) as $i) {
            $payment = new Payment;
            $payment->amount = $monthly;
            $payment->charge_at = date("Y-m-d H:i:s", strtotime('+' . $i . ' months'));
            $payment->save();
        }
        return ['msg' => 'contract has just started'];

    }

    public function addcv(Request $request)
    {
        $user = Auth::user();
        $category = $request->category;
        $title = $request->title;
        $file_name = $request->file_name;

        $cv = new Cv;
        $cv->category = $category;
        $cv->title = $title;
        $cv->file_name = $file_name;
        $cv->user_id = $user->id;
        $cv->save();
        return ['msg' => 'Cv added'];

    }

    public function getcv()
    {
        $user = Auth::user();
        //  $user_id = $user->id;

        $cv = Cv::where('user_id', $user->id)->get();
        $cover = Cover::where('user_id', $user->id)->get();
        return ["cv" => $cv, "covers" => $cover];
    }


    public function review(Request $request)
    {
        $user = Auth::user();
        $order_id = $request->order_id;
        $order = Order::find($order_id);

        if ($order === null) {
            return ['msg' => 'No order found'];
        }
        if ($order->buyer_id !== $user->id) {
            return ['msg' => 'You cannot rate this order'];
        }
        $review = $request->review;
        $cv = new Review;
        $cv->order_id = $order->id;
        $cv->review = $review;
        $cv->description_rating = $request->description_rating;
        $cv->communication_rating = $request->communication_rating;
        $cv->dispatchtime_rating = $request->dispatchtime_rating;
        $cv->postage_rating = $request->postage_rating;
        $cv->save();
        return ['msg' => 'Review added'];

    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $advert = Advert::find($request->id);
        if ($advert === null) {
            $advert = Advert::where('sid', $request->id)->first();
        }
        if ($advert === null) {
            return ['msg' => 'Advert not found'];
        }
        if ($advert->user_id != $user->id) {
            return ['msg' => 'Advert does not belong to you'];
        }
        $body = $request->json()->all();
        unset($body['id']);
        $params = [
            'index' => 'adverts',
            'type' => 'advert',
            'id' => $advert->elastic,
            'body' => [
                'doc' => $body
            ]
        ];

// Update doc at /my_index/my_type/my_id
        $response = $this->client->update($params);
        return ['msg' => 'updated', 'response' => $response];
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        $advert = Advert::find($request->id);
        if ($advert === null) {
            $advert = Advert::where('sid', $request->id)->first();
        }
        if ($advert === null) {
            return ['code' => 1, 'msg' => 'Advert not found'];
        }
        if ($advert->user_id != $user->id) {
            return ['code' => 2, 'msg' => 'Advert does not belong to you'];
        }
        $body = $request->json()->all();
        unset($body['id']);
        $params = [
            'index' => 'adverts',
            'type' => 'advert',
            'id' => $advert->elastic
        ];

// Update doc at /my_index/my_type/my_id
        $response = $this->client->delete($params);
        $advert->delete();
        return ['code' => 3, 'msg' => 'deleted', 'response' => $response];
    }

    public function addcover(Request $request)
    {
        $user = Auth::user();
        $category = $request->category;
        $title = $request->title;
        $cover = $request->cover;

        $cv = new Cover;
        $cv->category = $category;
        $cv->title = $title;
        $cv->cover = $cover;
        $cv->user_id = $user->id;
        $cv->save();
        return ['msg' => 'Cover added'];
    }

    public function offer(Request $request)
    {
        // Get the currently authenticated user...
        $user = Auth::user();
        $id = $request->id;
        $advert = Advert::find($id);
        if ($advert === null) {
            $advert = Advert::where('sid', $request->id)->first();
        }
        if ($advert === null) {
            return ['msg' => 'No Advert found'];
        }

        $offer = new Offer;
        $offer->amount = $request->amount;
        $offer->user_id = $user->id;
        $offer->save();

        $advert->offers()->save($offer);
        return ['msg' => 'Offer successfully sent'];

    }

    public function favorite(Request $request)
    {
        // Get the currently authenticated user...
        $user = Auth::user();
        $id = $request->id;
        $advert = Advert::find($id);
        if ($advert === null) {
            $advert = Advert::where('sid', $request->id)->first();
        }
        if ($advert === null) {
            return ['msg' => 'No Advert found'];
        }


        $favorite = new Favorite;
        $favorite->advert_id = $advert->id;
        $favorite->user_id = $user->id;
        $favorite->save();

        return ['msg' => 'Favorite sent'];

    }

    public function favorites()
    {
        $user = Auth::user();
        $favorites = $user->favorites;
        $adverts = array();
        foreach ($favorites as $favorite){
            $advert = Advert::find($favorite->advert_id);
            $params = [
                'index' => 'adverts',
                'type' => 'advert',
                'id' => $advert->elastic
            ];
            $response = $this->client->get($params);
            $adverts[]=$response['_source'];
        }

        return ['favorites' => $favorites ,'adverts'=>$adverts];
    }



    public function report(Request $request)
    {
        // Get the currently authenticated user...
        $user = Auth::user();
        $id = $request->id;
        $advert = Advert::find($id);
        if ($advert === null) {
            $advert = Advert::where('sid', $request->id)->first();
        }
        if ($advert === null) {
            return ['msg' => 'No Advert found'];
        }
        $report = new Report;
        $report->advert_id = $advert->id;
        $report->user_id = $user->id;
        $report->info = $request->info;
        $report->save();

        return ['msg' => 'Report sent'];

    }

    public function apply(Request $request)
    {
        // Get the currently authenticated user...
        $user = Auth::user();
        $id = $request->id;
        $advert = Advert::find($id);
        if ($advert === null) {
            $advert = Advert::where('sid', $request->id)->first();
        }
        if ($advert === null) {
            return ['msg' => 'No Advert found'];
        }
        $cover = Cover::find($request->cover_id);
        if ($cover === null) {
            return ['msg' => 'No Cover found'];
        }
        $cv = Cv::find($request->cv_id);
        if ($cv === null) {
            return ['msg' => 'No Cv found'];
        }
        $application = new Application;
        $application->advert_id = $advert->id;
        $application->user_id = $user->id;
        $application->cv_id = $cv->id;
        $application->cover_id = $cover->id;
        $application->save();

        return ['msg' => 'Application sent'];

    }

    public function interest(Request $request)
    {
        // Get the currently authenticated user...
        $user = Auth::user();
        $id = $request->id;
        $advert = Advert::find($id);
        if ($advert === null) {
            $advert = Advert::where('sid', $request->id)->first();
        }
        if ($advert === null) {
            return ['msg' => 'No Advert found'];
        }
        $interest = new Interest;
        $interest->advert_id = $advert->id;
        $interest->user_id = $user->id;
        $interest->save();

        return ['msg' => 'Interest sent'];

    }

    public function profile()
    {
        // Get the currently authenticated user...
        $user = Auth::user();

// Get the currently authenticated user's ID...
        //$id = Auth::id();

        return ["phone" => $user->phone, "email" => $user->email, "name" => $user->name, 'featured' => $user->featured, 'urgent' => $user->urgent, 'spotlight' => $user->spotlight, 'balance' => $user->balance, 'available' => $user->available, 'shipping' => $user->shipping, 'cvs' => $user->cvs, 'covers' => $user->covers];
    }

    public function price(Request $request)
    {
        // Get the currently authenticated user...
        $user = Auth::user();

// Get the currently authenticated user's ID...
        //$id = Auth::id();
        $category = $request->category;
        $lat = $request->lat;
        $lng = $request->lng;
        return Price::find(1);
    }

    public function mprice(Request $request)
    {

        return ['price' => (int)(0.8 * $this->cprice($request))];
    }

    public function cprice($request)
    {

        $price = Price::find(1);
        $featured = $request->featured;
        $urgent = $request->urgent;
        $spotlight = $request->spotlight;
        $featured_14 = $request->featured_14;
        $shipping_1 = $request->shipping_1;
        $shipping_2 = $request->shipping_2;
        $shipping_3 = $request->shipping_3;
        return (int)(($featured * $price->featured + $urgent * $price->urgent + $spotlight * $price->spotlight + $featured_14 * $price->featured_14 + $shipping_1 * $price->shipping_1 + $shipping_2 * $price->shipping_2 + $shipping_3 * $price->shipping_3));
    }

    public function token(Request $request)
    {
        $gateway = new \Braintree\Gateway(array(
            'accessToken' => 'access_token$sandbox$jv3x2sd9tm2n385b$ec8ce1335aea01876baaf51326d9bd90',
        ));
        $clientToken = $gateway->clientToken()->generate();
        return ['token' => $clientToken];
    }

    public function stripe(Request $request)
    {
        $token = \Stripe\Token::create(array(
            "card" => array(
                "number" => "4242424242424242",
                "exp_month" => 8,
                "exp_year" => 2018,
                "cvc" => "314"
            )
        ));
        return $token;
    }

    public function nonce(Request $request)
    {
        $gateway = new \Braintree\Gateway(array(
            'accessToken' => 'access_token$sandbox$jv3x2sd9tm2n385b$ec8ce1335aea01876baaf51326d9bd90',
        ));
        try {
            $result = $gateway->transaction()->sale([
                "amount" => $request->amount,
                'paymentMethodNonce' => $request->payment_method_nonce,
                'options' => [
                    'submitForSettlement' => True
                ]
            ]);
            $transaction = new Transaction;
            $transaction->slug = uniqid();
            $transaction->amount = $request->amount * 100;
            $transaction->save();
            return ['status' => 'success', 'result' => $result, 'transaction_id' => $transaction->slug];

        } catch (Exception $e) {

            return ['result' => ['msg' => 'failed']];
        }

    }

    public function addcard(Request $request)
    {
        $user = Auth::user();

        $stripe_id = $user->stripe_id;
        $token = $request->token;
        $customer = \Stripe\Customer::retrieve($stripe_id);
        try {
            $res = $customer->sources->create(array("source" => $token));

        } catch (\Exception $e) {
            return [
                'success' => false,
                'result' => ['msg' => 'no such token']
            ];
        }
        return [
            'success' => true,
            'result' => $res
        ];
    }

    public function cards(Request $request)
    {
        $user = Auth::user();
        $stripe_id = $user->stripe_id;
        $cards = \Stripe\Customer::retrieve($stripe_id)->sources->all(array(
            'limit' => 10, 'object' => 'card'));
        return $cards;
    }

    public function charge(Request $request)
    {
        $user = Auth::user();

        $stripe_id = $user->stripe_id;
        $card = $request->card;
        $amount = $request->amount * 100;
        $description = $request->description;
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $amount,
                "currency" => "gbp",
                "customer" => $stripe_id,
                "source" => $card, // obtained with Stripe.js
                "description" => $description
            ));
            $transaction = new Transaction;
            $transaction->slug = uniqid();
            $transaction->amount = $amount;
            $transaction->save();
            return ['status' => 'success', 'result' => $charge, 'transaction_id' => $transaction->slug];

        } catch (\Exception $e) {
            return [
                'status' => 'failed',
                'error' => $e,
                'result' => ['msg' => 'error charging the card']
            ];
        }


    }

    public function dob(Request $request)
    {
        $user = Auth::user();
        $account = \Stripe\Account::retrieve($user->stripe_account);
        $account->legal_entity->dob->day = $request->day;
        $account->legal_entity->dob->month = $request->month;
        $account->legal_entity->dob->year = $request->year;
        $account->save();
        return ['status' => 'success'];
    }

    public function identity(Request $request)
    {
        $user = Auth::user();

        $filename = $request->name;
        copy('https://s3.eu-central-1.amazonaws.com/chat.sumra.net/' . $filename, '/tmp/' . $filename);
        $fp = fopen('/tmp/' . $filename, 'r');
        $result = \Stripe\FileUpload::create(array(
            'purpose' => 'identity_document',
            'file' => $fp
        ));
        $account = \Stripe\Account::retrieve($user->stripe_account);
        $account->legal_entity->verification->document = $result->id;
        $account->save();
        return ['status' => 'success'];
    }

    public function add_address(Request $request)
    {
        $user = Auth::user();
        $account = \Stripe\Account::retrieve($user->stripe_account);
        $account->legal_entity->address->line1 = $request->line1;
        $account->legal_entity->address->city = $request->city;
        $account->legal_entity->address->postal_code = $request->postcode;
        $account->save();
        $address = new Address;
        $address->line1 = $request->line1;
        $address->city = $request->city;
        $address->postcode = $request->postcode;
        $address->code = rand(1000, 9999);
        $address->save();
        $user->addresses()->save($address);
        return ['status' => 'success'];
    }

    public function addresses(Request $request)
    {
        $user = Auth::user();

        return $user->addresses;
    }

    public function verify_address(Request $request, $id)
    {
        $address = Address::find($id);
        if ($address->code === $request->code) {
            $address->verified = 1;
            $address->save();
            return ['status' => 'success'];
        } else {
            return ['status' => 'failed'];
        }

    }

    public function account(Request $request)
    {
        $user = Auth::user();
        $account = \Stripe\Account::retrieve($user->stripe_account);
        $data['object'] = 'bank_account';
        $data['account_number'] = $request->number;
        $data['country'] = 'gb';
        $data['currency'] = 'gbp';
        $data['routing_number'] = $request->sortcode;
        $account->external_accounts->create(array("external_account" => $data));
        return ['status' => 'success'];
    }

    public function terms(Request $request)
    {
        $user = Auth::user();
        $account = \Stripe\Account::retrieve($user->stripe_account);
        $account->tos_acceptance->date = $request->date;
        $account->tos_acceptance->ip = $request->ip;
        $account->save();
        return ['status' => 'success'];
    }

    public function info()
    {
        $user = Auth::user();
        $account = \Stripe\Account::retrieve($user->stripe_account);
        /*
        $balance = \Stripe\Balance::retrieve(
            array("stripe_account" => $user->stripe_account)
        );
        */
        $stripe_id = $user->stripe_id;
        $cards = \Stripe\Customer::retrieve($stripe_id)->sources->all(array(
            'limit' => 10, 'object' => 'card'));
        return ['account' => $account, 'balance' => $user->balance, 'available' => $user->available, 'cards' => $cards];
    }

    public function withdraw(Request $request)
    {
        $user = Auth::user();
        $bank = $request->bank;
        $amount = $request->amount * 100;
        \Stripe\Transfer::create(array(
            "amount" => $amount,
            "currency" => "gbp",
            "destination" => $user->stripe_account
        ));
        \Stripe\Stripe::setApiKey($user->sk_key);
        try {
            \Stripe\Payout::create(array(
                "amount" => $amount,
                "currency" => "gbp",
                "destination" => $bank
            ));
            $user->balance -= $amount;
            $user->available -= $amount;
            $user->save();
        } catch (\Exception $e) {
            return [
                'success' => false,
                'result' => 'error withdrawing'
            ];
        }

        return ['status' => 'success'];
    }


    public function adverts(Request $request)
    {

        $user = Auth::user();
        $page = $request->page ? $request->page : 1;

        $pagesize = 10;
        $params = [
            'index' => 'adverts',
            'type' => 'advert',
            'body' => [
                'from' => ($page - 1) * $pagesize,
                'size' => $pagesize,
                'query' => [
                    'bool' => [
                        'must' => ['term' => ['user_id' => $user->id]],
                    ]
                ],
                "sort" => [
                    [
                        "created_at" => ["order" => "desc"]
                    ]
                ]
            ]
        ];
        $response = $this->client->search($params);
        $products = array_map(function ($a) {
            return $a['_source'];
        }, $response['hits']['hits']);

        return ['total' => $response['hits']['total'], 'adverts' => $products];
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $advert = new Advert;
        $advert->user_id = $user->id;
        $advert->save();
        $body = $request->json()->all();
        $body['source_id'] = $advert->id;
        $milliseconds = round(microtime(true) * 1000);
        $body['created_at'] = $milliseconds;
        $body['username'] = $user->name;
        $body['user_id'] = $user->id;
        $body['phone'] = $user->phone;
        if (!isset($body['meta']['price'])) {
            $body['meta']['price'] = -1;
        }
        unset($body['id']);
        $params = [
            'index' => 'adverts',
            'type' => 'advert',
            'body' => $body
        ];
        $response = $this->client->index($params);
        $advert->sid = $advert->id;
        $advert->elastic = $response['_id'];
        $advert->save();
        if ($user->offer === 0) {
            $user->balance += 500;
            $user->available += 500;
            $user->offer = 1;
            $user->save();
        }

        return ['body' => $body, 'response' => $response];
    }

    public function order(Request $request)
    {
        $user = Auth::user();
        $advert = Advert::find($request->id);
        if ($advert === null) {
            return ['msg' => 'Advert not found'];
        }

        $params = [
            'index' => 'adverts',
            'type' => 'advert',
            'id' => $advert->elastic
        ];

        $response = $this->client->get($params);

        $price = $response['_source']['meta']['price'];
        $transaction = Transaction::where('slug', $request->transaction_id)->first();
        if ($transaction === null || $transaction->used === 1) {
            return ['result' => ['msg' => 'Not a valid transaction id']];
        }

        if ($transaction->amount != $price) {
            return ['msg' => 'Wrong transaction amount'];
        }


        $order = new Order;
        $order->advert_id = $response['_source']['source_id'];
        $order->buyer_id = $user->id;
        $order->save();
        return ['success' => true, 'msg' => 'Order successfully placed'];
    }

    public function topup(Request $request)
    {
        $user = Auth::user();

        $transaction = Transaction::where('slug', $request->transaction_id)->first();
        if ($transaction === null || $transaction->used === 1) {
            return ['result' => ['msg' => 'Not a valid transaction id']];
        }

        $total = $transaction->amount;
        $transaction->used = 1;
        $transaction->save();
        $user->available += $total;
        $user->balance += $total;
        $user->save();

        return ['success' => true, 'result' => ['msg' => 'The amount is added to account']];
    }

    public function buy(Request $request)
    {
        $user = Auth::user();
        // return $user;
        // $body = $request->json()->all();

        $balance = (int)$request->balance;
        $total = $this->cprice($request);
        $subtract = 0;
        if ($balance === 1) {

            if ($total > $user->available) {
                $total -= $user->available;
                $subtract = $user->available;
            } else {
                $total = 0;
                $subtract = $total;
            }

        }
        if ($total === 0) {


            $user->available -= $subtract;
            $user->balance -= $subtract;
            $user->save();
            //     return ['success'=>true,'result'=>['msg'=>'The packs successfully added to account'],'featured'=>$user->featured,'urgent'=>$user->urgent,'spotlight'=>$user->spotlight,'balance'=>$user->balance,'available'=>$user->available,'shipping'=>$user->shipping];
        }

        if ($total > 0) {
            $transaction = Transaction::where('slug', $request->transaction_id)->first();
            if ($transaction === null || $transaction->used === 1) {
                return ['success' => false, 'result' => ['msg' => 'Not a valid transaction id']];
            }
            if ($transaction->amount < $total) {
                return ['success' => false, 'result' => ['msg' => 'Not enough amount in the transaction']];
            }
        }
        $featured = array();
        $urgent = array();
        $spotlight = array();
        $shipping = array();
        if ($request->featured > 0) {
            $fff = new Featured;
            $fff->count = $request->featured;
            $fff->days = 7;
            $fff->save();
            $user->featured()->save($fff);
            $featured[] = $fff;
        }
        if ($request->urgent > 0) {
            $uuu = new Urgent;
            $uuu->count = $request->urgent;
            $uuu->days = 7;
            $uuu->save();
            $user->urgent()->save($uuu);
            $urgent[] = $uuu;
        }
        if ($request->spotlight > 0) {
            $sss = new Spotlight;
            $sss->count = $request->spotlight;
            $sss->days = 7;
            $sss->save();
            $user->spotlight()->save($sss);
            $spotlight[] = $sss;
        }
        if ($request->featured_14 > 0) {
            $fff = new Featured;
            $fff->count = $request->featured_14;
            $fff->days = 14;
            $fff->save();
            $user->featured()->save($fff);
            $featured[] = $fff;
        }
        if ($request->shipping_1 > 0) {
            $fff = new Shipping;
            $fff->count = $request->shipping_1;
            $fff->weight = 2;
            $fff->save();
            $user->shipping()->save($fff);
            $shipping[] = $fff;
        }
        if ($request->shipping_2 > 0) {
            $fff = new Shipping;
            $fff->count = $request->shipping_2;
            $fff->weight = 5;
            $fff->save();
            $user->shipping()->save($fff);
            $shipping[] = $fff;
        }
        if ($request->shipping_3 > 0) {
            $fff = new Shipping;
            $fff->count = $request->shipping_3;
            $fff->weight = 10;
            $fff->save();
            $user->shipping()->save($fff);
            $shipping[] = $fff;
        }
        $user->available -= $subtract;
        $user->balance -= $subtract;
        $user->save();

        return ['success' => true, 'result' => ['msg' => 'The packs successfully added to account'], 'featured' => $featured, 'urgent' => $urgent, 'spotlight' => $spotlight, 'balance' => $user->balance, 'available' => $user->available, 'shipping' => $shipping];
    }

    public function transfer(Request $request)
    {
        $user = Auth::user();
        $params = [
            'index' => 'adverts',
            'type' => 'advert',
            'body' => [
                'size' => 2000,
                'query' => [
                    'bool' => [
                        'must' => ['term' => ['phone.keyword' => $user->phone]],
                    ]
                ]
            ]
        ];
        $response = $this->client->search($params);
        $products = array_map(function ($a) {
            $ans = $a['_source'];
            $ans['id'] = $a['_id'];
            return $ans;
        }, $response['hits']['hits']);

        foreach ($products as $product) {

            $params = [
                'index' => 'adverts',
                'type' => 'advert',
                'id' => $product['id'],
                'body' => [
                    'doc' => [
                        'user_id' => $user->id
                    ]
                ]
            ];

// Update doc at /my_index/my_type/my_id
            $response = $this->client->update($params);

        }
        return ['msg' => 'success'];
    }

    public function bump(Request $request)
    {
        $user = Auth::user();
        $advert = new Advert;

        $advert->save();
        $body = $request->json()->all();

        $featured = (int)$body['featured'];
        $urgent = (int)$body['urgent'];
        $spotlight = (int)$body['spotlight'];
        $canship = (int)$body['canship'];

        if ($featured === 1) {
            if (isset($body['featured_id'])) {
                $vd = Featured::find($body['featured_id']);
                if ($vd === null) {
                    return ['success' => false, 'msg' => 'Not valid featured id'];
                }
                $vd->count--;
                $vd->save();
            } else {
                return ['success' => false, 'msg' => 'No featured id'];
            }
        }

        if ($urgent === 1) {
            if (isset($body['urgent_id'])) {
                $vd = Urgent::find($body['urgent_id']);
                if ($vd === null) {
                    return ['success' => false, 'msg' => 'Not valid urgent id'];
                }
                $vd->count--;
                $vd->save();
            } else {
                return ['success' => false, 'msg' => 'No urgent id '];
            }
        }
        if ($spotlight === 1) {
            if (isset($body['spotlight_id'])) {
                $vd = Spotlight::find($body['spotlight_id']);
                if ($vd === null) {
                    return ['success' => false, 'msg' => 'Not valid spotlight id'];
                }
                $vd->count--;
                $vd->save();

            } else {
                return ['success' => false, 'msg' => 'No spotlight id '];
            }
        }
        if ($canship === 1) {
            if (isset($body['shipping_id'])) {
                $vd = Shipping::find($body['shipping_id']);
                if ($vd === null) {
                    return ['success' => false, 'msg' => 'Not valid shipping id'];
                }
                $vd->count--;
                $vd->save();
                $advert->canship = 1;
                $advert->save();

            } else {
                return ['success' => false, 'msg' => 'No shipping id '];
            }
        }
        unset($body['featured_id']);
        unset($body['urgent_id']);
        unset($body['spotlight_id']);
        unset($body['shipping_id']);
        // unset($body['canship']);
        $body['source_id'] = $advert->id;
        $milliseconds = round(microtime(true) * 1000);
        $body['created_at'] = $milliseconds;
        $body['expires_at'] = $milliseconds + 7 * 24 * 3600 * 1000;
        $body['username'] = $user->name;
        $body['user_id'] = $user->id;
        $body['phone'] = $user->phone;
        if (!isset($body['meta']['price'])) {
            $body['meta']['price'] = -1;
        }
        $params = [
            'index' => 'adverts',
            'type' => 'advert',
            'body' => $body
        ];
        $response = $this->client->index($params);
        $advert->sid = $advert->id;
        $advert->user_id = $user->id;
        $advert->elastic = $response['_id'];
        $advert->save();
        if ($user->offer === 0) {
            \Stripe\Transfer::create(array(
                "amount" => 500,
                "currency" => "gbp",
                "destination" => $user->stripe_account
            ));
            $user->offer = 1;
            $user->save();
        }

        return ['success' => true, 'body' => $body, 'response' => $response];
    }

    public function ccreate(Request $request)
    {
        $body = $request->json()->all();
        $category = Category::where('slug', $body['slug'])->first();
        if ($category === null) {
            $category = new Category;
            $category->slug = $body['slug'];
            $category->save();

        }
        $body['category'] = $category->id;
        $advert = Advert::where('sid', '=', (int)$body['source_id'])->first();
        if ($advert !== null) {
            return ['a' => 'b'];
        }

        $advert = new Advert;

        $advert->sid = (int)$body['source_id'];
        $advert->save();
        $params = [
            'index' => 'adverts',
            'type' => 'advert',
            'body' => $body
        ];
        $response = $this->client->index($params);
        $advert->elastic = $response['_id'];
        $advert->save();
        return ['response' => $response];
    }

    public function register(Request $request)
    {
        if (!$request->has('email'))
            return ['msg' => "Email can't be blank"];
        if (!$request->has('password'))
            return ['msg' => "Password can't be blank"];
        if (!$request->has('name'))
            return ['msg' => "Name can't be blank"];
        if (preg_match('/\s/', $request->name) === 0)
            return ['msg' => 'Should have full name'];
        if (!$request->has('phone'))
            return ['msg' => "Phone can't be blank"];
        $user = User::where('email', $request->email)->first();
        if ($user !== null) {
            return ['msg' => 'Email is already registered'];
        }
        $user = new User;


        $user->more(['email' => $request->email, 'name' => $request->name, 'password' => bcrypt($request->password), 'phone' => $request->phone]);
        $user->save();


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fire.sumra.net/updatetitle");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['id' => $user->id, 'title' => $user->name, "image" => ""]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        /*
        $names = explode(' ', $user->name);
        $account = \Stripe\Account::retrieve($user->stripe_account);
        $account->legal_entity->first_name = $names[0];
        $account->legal_entity->last_name = $names[1];
        $account->legal_entity->type = 'individual';
        $account->save();
        */


        //Creating a token without scopes...
        $token = $user->createToken('Token Name')->accessToken;

        return ['msg' => 'success', 'token' => $token, 'id' => $user->id, 'email' => $user->email, 'name' => $user->name];
    }

}
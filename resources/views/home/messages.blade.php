<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.business')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <ul class="nav nav-tabs top-main-nav">

                <li class="nav-item">
                    <a class="nav-link nav-color" href="/business/manage/ads"><span class="glyphicon glyphicon-folder-open"></span> &nbsp;&nbsp; Manage  ads</a>
                </li>
                <li class="nav-item">
                <a class="nav-link nav-color" href="/user/manage/images"><span class="glyphicon glyphicon-camera"></span>&nbsp;&nbsp;Images</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/user/manage/orders"><span class="glyphicon glyphicon-credit-card"></span> &nbsp;&nbsp; Orders</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link nav-color" href="#"><span class="glyphicon glyphicon-envelope"></span> &nbsp;&nbsp;Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/business/manage/details"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp; My Details</a>
                </li>
                @if($user->contract!==null)

                <li class="nav-item">
                    <a class="nav-link nav-color" href="/business/manage/company"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp; Company</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/business/manage/finance"><span class="glyphicon glyphicon-gbp"></span> &nbsp;&nbsp; Financials</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/business/manage/metrics"><span class="glyphicon glyphicon-stats"></span> &nbsp;&nbsp; Metrics</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/user/manage/favorites"><span class="glyphicon glyphicon-heart"></span> &nbsp;&nbsp; Favorites</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/user/manage/alerts"><span class="glyphicon glyphicon-bell"></span> &nbsp;&nbsp; Search Alerts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/business/manage/support"><span class="glyphicon glyphicon-earphone"></span> &nbsp;&nbsp; Support</a>
                </li>
            </ul>
            <div class="full-width">
                @if(count($user->rooms)>0)
                <div class="left-div-messages {{$leftclass}}" id="all-rooms">
                    @foreach($user->rooms as $room)
                        <div class="media @if($room->id===$cur->id) selected-room @endif ">
                            <div class="media-left">
                                <a href="#">
                                    <div class="listing-side">
                                        <div class="listing-thumbnail">
                                            <img src="{{env('AWS_WEB_IMAGE_URL')}}/{{$room->image}}" class="lazyload" alt="">
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="media-body">
                                <a href="/user/manage/messages/{{$room->id}}"><h4 class="media-heading">{{$room->title}}</h4></a>
                                @if($room->last_message())
                                <p class="@if($room->unread===1) unread-message @endif">{{$room->last_message()->message}}</p>
                                <strong>{{$room->last_message()->user->name}}</strong>
                                    @endif
                            </div>
                        </div>
                        @endforeach
                </div>
                <div class="right-div-messages {{$rightclass}}">
                    <div class="mtop">
                        <a class="message-back-button"  href="/user/manage/messages">Back</a>
                            <a class="listing-product" href="/p/{{$cur->advert->param('category')}}/{{$cur->advert->id}}"> <h4>{{$cur->advert->param('title')}}</h4></a>
                        <a class="btn btn-primary" href="/room/invoice/create/{{$cur->id}}">Create Invoice</a>
                            @if($cur->advert->meta('price')>=0)
                                <span class="product-price">£ {{$cur->advert->meta('price')/100}}{{$cur->advert->meta('price_frequency')}}
                                </span>
                            @endif

                    </div>

                    <div class="all-messages" id="all-msg">
                        @foreach($cur->messages as $message)
                            @if($message->previous()&&$message->previous()->day()!==$message->day()||!$message->previous())
                               <div class="day-seperator"><span class="day-seperator-text">{{$message->day()}}</span> </div>
                                @endif

                            @if($message->type==='invoice')
                                    @if($message->from_msg===$user->id)
                                        <div class="right-message"><span class="message"> Invoice Sent for {{$message->invoice->amount()}} &nbsp;&nbsp; <span class="message-time"> {{$message->timestamp()}}</span> </span></div>

                                    @else
                                        <div class="left-message"><span class="message"> Invoice received for {{$message->invoice->amount()}} @if($message->invoice->status==1)<span class="green-text">Paid</span> @else  <a class="btn btn-primary" href="/pay/invoice/{{$message->invoice->id}}">Pay Now</a> @endif &nbsp;&nbsp;  <span class="message-time"> {{$message->timestamp()}}</span></span></div>

                                    @endif

                                    @else

                            @if($message->from_msg===$user->id)

                            <div class="right-message"><span class="message"> {{$message->message}}&nbsp;&nbsp; <span class="message-time"> {{$message->timestamp()}}</span> </span></div>
                            @else
                                <div class="left-message"><span class="message">{{$message->message}}&nbsp;&nbsp;  <span class="message-time"> {{$message->timestamp()}}</span></span></div>
                            @endif
@endif
                        @endforeach
                    </div>


                    <div class="bottom-div-messages">
                        <form action="/user/message/rsend" method="post" id="login-form">
                            <input type="hidden" name="rid" value="{{$cur->id}}">
                            {{ csrf_field() }}                            <div class="message-input-div"><input type="text" class="form-control"  id="message" name="message" placeholder="Type Your Message here" required></div>
                            <div class="message-send-div"><button type="submit"  class="btn btn-primary g-recaptcha"
                                                                  data-sitekey="6Le7jzMUAAAAAERoH4JkYtt4pE8KASg0qTY7MwRt"
                                                                  data-callback="onSubmit">Send</button></div>
                        </form>
                    </div>
                </div>
                    @else
                    <h4>No Messages to Display</h4>
                    @endif
            </div>
        </div>
    </div>

    <script>
        function scroll_bottom() {
            var objDiv = document.getElementById("all-msg");
            objDiv.scrollTop = objDiv.scrollHeight;
        }
      scroll_bottom();

        function onSubmit(token) {


            document.getElementById("login-form").submit();



        }

        var room = @if($cur) {{$cur->id}} @else 0 @endif;

        function got_message(data) {
            var object = JSON.parse(data);
            if(object.message&&object.room_id==room)
            {
                $('#all-msg').append('<div class="left-message"><span class="message">'+object.message+'</span></div>');
                scroll_bottom()
            }else if(object.message){

                // location.reload();
                axios.get('/user/manage/rooms/'+room, {
                    params: {}
                })
                    .then(function (response) {
                        console.log(response);
                        $('#all-rooms').html(response.data);

                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            }
        }




    </script>

@endsection
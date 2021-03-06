<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="/user/manage/ads">Manage My ads</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/manage/orders">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="/user/manage/buying">Buying</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/manage/messages">Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/manage/favorites">Favorites</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">My Details</a>
                </li>
            </ul>
            <div class="well">
           <table class="table">
               <tr><td>Name</td><td>{{$user->name}}</td></tr>
               <tr><td>Email</td><td>{{$user->email}}</td></tr>
               <tr><td>Phone</td><td>{{$user->phone}}</td></tr>
           </table>
            </div>
            <div class="well">

            <h4>Adresses</h4>
            @foreach($user->addresses as $address)
                <ul class="list-group">
                    <li class="list-group-item"> {{$address->line1}}</li>
                    <li class="list-group-item">{{$address->city}}</li>
                    <li class="list-group-item">{{$address->postcode}}</li>
                </ul>
                <a class="glyphicon glyphicon-trash delete-icon" href="/user/address/delete/{{$address->id}}"></a>

                <br>
            <br>

            @endforeach
            </div>
                <div class="well">

                <h4>CVs</h4>
            <table class="table">
                <thead><th>Title</th><th>Category</th></thead>
            @foreach($user->cvs as $cv)
            <tr><td>{{$cv->title}}</td><td>{{$cv->category->title}}</td></tr>
            @endforeach
            </table>
                </div>

            <div class="well">

                <h4>Cover Letters</h4>
                <table class="table">
                    <thead><th>Title</th><th>Category</th></thead>
                    @foreach($user->covers as $cover)
                        <tr><td>{{$cover->title}}</td><td>{{$cover->category->title}}</td></tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


@endsection
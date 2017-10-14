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

            <ul class="nav nav-tabs">

                <li class="nav-item">
                    <a class="nav-link nav-color" href="/business/manage/ads"><span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;Manage  ads</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/user/manage/orders"><span class="glyphicon glyphicon-credit-card"></span> &nbsp;&nbsp; Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/user/manage/messages"><span class="glyphicon glyphicon-envelope"></span> &nbsp;&nbsp; Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/business/manage/details"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;My Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/business/manage/company"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Company</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link nav-color" href="#"><span class="glyphicon glyphicon-gbp"></span>&nbsp; &nbsp;Financials</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/business/manage/metrics"><span class="glyphicon glyphicon-stats"></span>&nbsp; &nbsp;Metrics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/user/manage/favorites"><span class="glyphicon glyphicon-heart"></span> &nbsp;&nbsp; Favorites</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/user/manage/alerts"><span class="glyphicon glyphicon-bell"></span> &nbsp;&nbsp; Search Alerts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/business/manage/support"><span class="glyphicon glyphicon-earphone"></span> &nbsp;&nbsp;Support</a>
                </li>
            </ul>
            <h4>Payment Schedule</h4>
            <table class="table">
                <tr><th>Title</th><th>Description</th><th>Postcode</th>@foreach($category->fields as $field)<th>{{$field->title}}</th>@endforeach</tr>
                <tr>
                    <td> <input class="form-control" type="text" name="title" required value=""></td>
                    <td> <textarea class="form-control" name="description" rows="10" cols="20" required></textarea></td>
                    <td> <input class="form-control" type="text" name="postcode" required value=""></td>

                @foreach($category->fields as $field)
                        <td>
                            @if($field->type==='integer')
                                <input class="form-control" type="text" name="{{$field->slug}}" required value="">
                            @elseif($field->type==='list')
                                <select class="form-control" name="{{$field->slug}}">
                                    @foreach($field->values as $value)
                                        <option value="{{$value->slug}}" >{{$value->title}}</option>
                                    @endforeach
                                </select>
                            @else
                                <input class="form-control" type="text" name="{{$field->slug}}" required  value="">
                            @endif
                        </td>
                @endforeach
                </tr>
            </table>
        </div>
    </div>


@endsection
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
                    <a class="nav-link nav-color" href="/user/manage/ads"><span class="glyphicon glyphicon-folder-open"></span> &nbsp;&nbsp; Manage  ads</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/user/manage/images"><span class="glyphicon glyphicon-camera"></span>&nbsp;&nbsp;Images</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/user/manage/orders"><span class="glyphicon glyphicon-credit-card"></span> &nbsp;&nbsp; Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-color" href="/user/manage/messages"><span class="glyphicon glyphicon-envelope"></span> &nbsp;&nbsp; Messages</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link nav-color" href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp; My Details</a>
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
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <br><br><br><br>
            <form action="/room/invoice/save" method="post" id="change-category">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" name="title" class="form-control" id="staticEmail" value="{{$room->title}}">
                    </div>
                </div>
                <div id="items">
                <div class="form-group row">
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputPassword" placeholder="Deposit" name="items[]">
                    </div>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" id="inputPassword" placeholder="500" name="prices[]">
                    </div>
                    <div class="col-sm-1">
                        <a class="btn btn-danger delete-item">Delete Item</a>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputPassword" placeholder="Admin Fee" name="items[]">
                    </div>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" id="inputPassword" placeholder="100" name="prices[]">
                    </div>
                    <div class="col-sm-1">
                        <a class="btn btn-danger delete-item">Delete Item</a>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputPassword" placeholder="Credit Check Fee" name="items[]">
                    </div>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" id="inputPassword" placeholder="35" name="prices[]">
                    </div>
                    <div class="col-sm-1">
                        <a class="btn btn-danger delete-item">Delete Item</a>
                    </div>
                </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                    </div>
                    <div class="col-sm-3">
                    </div>
                    <div class="col-sm-1">
                        <a class="btn btn-default add-more-items">Add Item</a>
                    </div>
                </div>

                <input type="submit" value="Create Invoice" class="btn btn-primary">
            </form>
        </div>
    </div>
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
            console.error( error );
        } );
        $('#items').on('click','.delete-item',function () {
            $(this).parent().parent().remove();
        });
        $('.add-more-items').click(function () {
            $('#items').append('<div class="form-group row">\n' +
                '                    <div class="col-sm-8">\n' +
                '                        <input type="text" class="form-control" id="inputPassword" placeholder="One More Item" name="items[]">\n' +
                '                    </div>\n' +
                '                    <div class="col-sm-3">\n' +
                '                        <input type="number" class="form-control" id="inputPassword" placeholder="100" name="prices[]">\n' +
                '                    </div>\n' +
                '                    <div class="col-sm-1">\n' +
                '                        <a class="btn btn-danger delete-item">Delete Item</a>\n' +
                '                    </div>\n' +
                '                </div>');
        });
    </script>
@endsection
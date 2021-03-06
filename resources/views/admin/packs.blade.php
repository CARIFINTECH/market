<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.admin')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">


            <div class="well">
                <table class="table">
                    <thead><th>Standard</th><th>Urgent</th><th>Spotlight</th><th>Featured(3 days)</th><th>Featured(7 days)</th><th>Featured(14 days)</th><th>Bump</th><th>Location</th><th>Category</th><th>(Edit)</th></thead>
                @foreach($prices as $price)

<tr>
    <td>£{{$price->standard/100}}</td>
    <td>£{{$price->urgent/100}}</td>
    <td>£{{$price->spotlight/100}}</td>
    <td>£{{$price->featured_3/100}}</td>
    <td>£{{$price->featured/100}}</td>
    <td>£{{$price->featured_14/100}}</td>
    <td>£{{$price->bump/100}}</td>
    <td>{{$price->location->title}}</td>
    <td>{{$price->category->title}}</td>
    <td><a href="/admin/manage/pricegroup/edit/{{$price->id}}" class="btn btn-primary">Edit</a> </td>
    <td><a  href="/admin/manage/pricegroup/delete/{{$price->id}}" class="btn btn-danger">Delete</a> </td>

</tr>
                @endforeach
                </table>
                <a class="btn-primary btn" href="/admin/manage/pricegroup">Add Price Group</a>
            </div>
        </div>


    </div>
@endsection
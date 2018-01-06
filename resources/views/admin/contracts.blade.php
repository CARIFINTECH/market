<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <div class="row">

        <div class="col-sm-4">
        </div>
        <div class="col-sm-4">
            <br><br><br>

            <h4 style="text-align: center">Total Contracts: {{$total}}</h4>


        </div>
        <div class="col-sm-4">
        </div>
        <div class="col-sm-2">
        </div>
        <div class="col-sm-8">

            <br><br><br>
            <h4>Contracts</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Business Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Pause/Resume</th>
                </tr>
                </thead>
                <tbody>
                @foreach($contracts as $contract)
                    @if($contract->user->business)
                    <tr>
                        <td>{{$contract->user->business->name}}</td>
                        <td>{{$contract->user->email}}</td>
                        <td>{{$contract->user->phone}}</td>
                        <td>{{$contract->total_before_discount()}}</td>
                        <td><a href="/admin" class="btn btn-danger">Pause</a> </td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>

    </div>


@endsection
<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@php
    $date = new Datetime();
    $dateMs = $date->getTimestamp();
@endphp
@section('styles')
<link href="{{ asset("/css/bulk-discard.css?q=$dateMs") }}" rel="stylesheet" type="text/css">
@endsection
@section('content')
<div class="body background-body">
    <div class="container">
        <div class="row">
            <div class="col-sm-10">
                <h3>Bulk Apply</h3>
                <form action="/user/jobs/apply/all" method="post" id="form-bulk-apply">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="radio-profile">Profile</label>
                        <input type="radio" name="apply_with" id="radio-profile" value="0" checked>
                        <label for="radio-profile">CV</label>
                        <input type="radio" name="apply_with" id="radio-cv" value="1">
                        <label for="radio-profile">Profile & CV</label>
                        <input type="radio" name="apply_with" id="radio-profile-cv" value="2">
                    </div>
                    <div class="form-group profile">
                        <label for="profile">Select Profile</label>
                        <select class="form-control" id="profile" name="profile">
                            @foreach($user->publishProfiles as $profile)
                                <option value="{{$profile->id}}">{{$profile->getType()}}</option>
                            @endforeach        
                        </select>
                    </div>
                    <div class="form-group cv">
                        <label>Select CV</label>
                        <select class="form-control" id="cv" name="cv">
                            @foreach($user->cvs as $cv)
                                <option value="{{$cv->id}}">{{$cv->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="validation">
                            <span>Please select at least one application</span>
                        </div>
                    </div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($adverts as $advert)
                            <tr>
                                <td><a href="{{$advert->url()}}" target="_black"> {{$advert->param('title')}}</a>
                                    <input required="Please select at least one appplication" class="select-request" type="hidden" name="ids[]" value="{{$advert->id}}">
                                </td>
                                <td>
                                    <button class="btn btn-danger" onclick="$(this).parent().parent().remove();">Delete</button> 
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Apply All</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $('#form-bulk-apply').submit(function(e){
        var length = $('.select-request').length;
        if(length == 0){
            e.preventDefault();
            $('.form-group').addClass('input-validation-error');
        }
    })
    $('input[type=radio]').change(function(){
        var value = $(this).val();
        if(value == 0){
            $('.cv').hide();
            $('.profile').show();
        }
        else if(value == 1){
            $('.cv').show();
            $('.profile').hide();
        }
        else{
            $('.cv').show();
            $('.profile').show();
        }
    })
</script>
@endsection
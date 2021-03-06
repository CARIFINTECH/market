<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', 'Create your cover letter')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection
@php
    $date = new Datetime();
    $dateMs = $date->getTimestamp();
@endphp
@section('content')
<link href="{{ asset("/css/private-profile.css?q=$dateMs") }}" rel="stylesheet" type="text/css">
<div class="body background-body">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="back-link">
          <a href="{{ URL::previous() }}"><i class="glyphicon glyphicon-menu-left"></i>Your profile</a>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="section">
          <header class="section-header">
            <h2 class="title">Cover letter</h2>
            <p class="summary">A good cover letter can greatly increase your chances of standing out to recruiters.</p>
          </header>
          <div class="content">
              <form action="/user/covers/add" method="post" id="add-cover">
                  <input name="redirect" type="hidden" value="/job/profile/edit/{{$profile->type}}">
                  {{ csrf_field() }}
                  <input name="profile" type="hidden" value="{{$profile->id}}">
              <div class="form-group">
                  <label for="title">Title</label> 
                  <span class="red-text" id="no-title" style="display: none">Please add a title to your Cover</span>
                  <input type="text" class="form-control" name="title" aria-describedby="emailHelp" placeholder="Cover for Part Time Job" required value="{{$cover != null ? $cover->title : ""}}">
                  <small id="emailHelp" class="form-text text-muted">With title you can easily locate Cover if you have many Covers </small>
              </div>
              <div class="form-group">
                  <label for="category">Select Category</label> <span class="red-text" id="no-category" style="display: none">Please choose a category to your CV</span>
                  <select class="form-control" name="category" required>
                      @foreach($jobs as $job)
                          <option value="{{$job->id}}" {{($profile->cover != null && $profile->cover->category->id == $job->id) ? 'selected' : ''}}>{{$job->title}}</option>
                      @endforeach
                  </select>
              </div>
                  <div class="form-group">
                      <label for="cover">Cover Letter</label>
                      <textarea class="form-control" id="cover" name="cover" rows="15">{{$cover != null ? $cover->cover: ""}}</textarea>
                      <div class="validation">
                         <span>Cover letter cannot be empty</span>
                      </div>
                  </div>
              <button type="submit" class="btn btn-submit" id="upload-cv-link">Add Cover</button>
              </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
  $('#add-cover').submit(function(e){
    var selectorCover = $('#cover');
    var cover = selectorCover.val();
    if(cover == ''){
      e.preventDefault();
      var parent = selectorCover.closest('.form-group');
      parent.addClass('input-validation-error');
    }
  });
  $('#cover').change(function(){
    var parent = $(this).closest('.form-group');
    if(parent.hasClass('input-validation-error')){
      parent.removeClass('input-validation-error');
    }
  })
</script>
@endsection
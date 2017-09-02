<!-- Stored in resources/views/child.blade.php -->

@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')

   <div class="row">
       <div class="col-lg-2"></div>
       <div class="col-lg-8  nopadding">
           <div class="select-category">
           <h3>Select Category</h3>
           @foreach($categories as $category)
               <div class="main-category" data-category="{{$category->id}}">
                   {{$category->title}}
               </div>
           @endforeach
           <div class="row nomargin">
               <div class="col-lg-3 sub-category">
                <ul class="list-group category-level-1  nomargin">

                </ul>
               </div>
               <div class="col-lg-3 sub-category">
                   <ul class="list-group category-level-2  nomargin">

                   </ul>
               </div>
               <div class="col-lg-3 sub-category">
                   <ul class="list-group category-level-3  nomargin">

                   </ul>
               </div>
               <div class="col-lg-3 sub-category">
                   <ul class="list-group category-level-4  nomargin">

                   </ul>
               </div>
           </div>
           <div class="row" style="margin-top: 30px;margin-bottom: 30px">
               <div class="col-sm-1 col-sm-offset-11">
                   <a class="btn btn-danger" disabled id="continue-button">Continue</a>
               </div>
           </div>
           </div>
           <div class="selected-category">
               <div class="row">
                   <div class="col-sm-12">
                   <div class="grayborder height100">
                       <div class="row">
                           <div class="col-sm-12">
                   <span class="glyphicon glyphicon-ok-sign"></span><span class="category-title">Category</span>
                           </div>
                       </div>
                           </div>
                   </div>
                   <div class="col-sm-12">
                       <div class="grayborder height100">
                           <div class="row">
                           <div class="col-sm-11"></div>
                           <div class="col-sm-1">
                               <a class="btn btn-default">Edit</a>
                           </div>
                           </div>
                       </div></div>

               </div>
           </div>
           <div class="selected-location">
               <div class="row">
                   <div class="col-sm-12">
                       <div class="grayborder height100">
                           <div class="row">
                               <div class="col-sm-12">
                                   <span class="glyphicon glyphicon-ok-sign"></span><span class="category-title">Location</span>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="col-sm-12">
                       <div class="grayborder height100">
                           <div class="row">
                               <div class="col-sm-11">
                                   <form class="form-inline">
                                       <label class="sr-only" for="inlineFormInput">Postcode</label>
                                       <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput" placeholder="Postcode">
                                       <button class="btn btn-danger">Go</button>
                                   </form>
                               </div>
                               <div class="col-sm-1">
                                   <a class="btn btn-default">Edit</a>
                               </div>
                           </div>
                       </div></div>

               </div>
           </div>
           <div class="selected-extras">
               <div class="row category-extras"></div>
           </div>
       </div>
       <div class="col-lg-2"></div>
   </div>
    @endsection
@extends('layouts.recruiters')

@section('title', env('APP_NAME').' | Contact - Template Uber')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection
@section('content')
 <link href="{{asset('/css/template-contact.css?q=874')}}" rel="stylesheet">
 <link href="{{ asset('/css/css/font-awesome.min.css?q=874') }}" rel="stylesheet">
 <div class="body">
	<div class="container-fluid">
		<div class="row header-container">
			<div class="col-sm-12">
				<div class="parallax-content">
					<h1 class="header-title">
						Sumra - Contact
					</h1>
					<p class="c-white">Uber - Company template</p>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="contact-title">
					Contact Us About the Uber Template
				</h2>
				<div class="contact-form-yellow">
				</div>
			</div>
			<div class="col-sm-5">
				<h3>Via Website:</h3>
				<form>
					
				</form>
			</div>
			<div class="col-sm-3">
			</div>
			<div class="col-sm-4">
			</div>
		</div>
	</div>
</div>
@endsection
@extends('layouts.app')

@section('title', env('APP_NAME'). ' Mobile Apps')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection
@section('styles')
<link href="{{ asset('/css/download.css?q=874') }}" rel="stylesheet">
@endsection

@section('content')
 
<div class="body">
	<div id="wrapper">
		<div class="main">
			<section id="banner-page" class="app-page">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<h1>Connect, search, find, buy - get it on the go</h1>
							<div class="instructions">
								<p class=instructions-sms active>Enter your number and we'll text you a link to download the app!</p>
							</div>
							<div class="form-wrapper">
								<form id="form-sms" action="" class="active">
									<div class="fields-container">
										<div class="field-wrapper phone-number-wrapper">
											<input type="tel" name="phone-number" id="phone-number">
										</div>
										<div class="field-action-wrapper">
											<button type="submit" class="btn btn-submit">Text me the link</button>
										</div>
									</div> 
								</form>
								<div class="field field-error">
									Something went wrong. Please check your phone number and try again.
								</div>
							</div>
							<div class="available-devices">
								<p>Available for</p>
								<ul>
									<li>
									</li>
									<li>
									</li>
								</ul>
							</div>
							<div class="clause">
								<p class="clause-sms active">Standard messaging and data fees may apply.</p>
								<p class="clause-email">Your email address will not be stored or used for any other purposes.</p>
							</div>
						</div>
						<div class="mobile-devices"></div>
					</div>
				</div>
			</section>
		</div>
		<div class="app-curve">
			<img src="https://about.canva.com/wp-content/themes/canvaabout/img/canva-app/app-curve.svg" alt="">
		</div>
	</div>
</div>
@endsection
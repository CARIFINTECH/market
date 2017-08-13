<!DOCTYPE html>
<html lang="en-US">
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">

</head>
	<body class="">
		<header>
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					        <span class="sr-only">Toggle navigation</span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
				     	</button>
				      <a class="navbar-brand" href="#"><img class="icon" src="css/logo.png"></a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
					        <li><a href="#">Link</a></li>
					        <li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
					          <ul class="dropdown-menu">
					            <li><a href="#">Action</a></li>
					            <li><a href="#">Another action</a></li>
					            <li><a href="#">Something else here</a></li>
					            <li role="separator" class="divider"></li>
					            <li><a href="#">Separated link</a></li>
					          </ul>
					        </li>
				      	</ul>
				    </div><!-- /.navbar-collapse -->
				</div>
			</nav>
		</header>
		<section class="categories">
			<div class ="row">
		 	@foreach($base as $cat)
		 		<div class="col-md-6 col-lg-1">
			 		<div class="panel panel-primary {{$cat->class}}">
			 			<div class="panel-heading">
			 				<img class="icon-category" src="css/icons/{{$cat->slug}}.png">
			 				<h1>{{$cat->title}}</h1>
			 			</div>
			 			<div class="panel-body .visible-md-*">
						 	<ul>
						 	@foreach($cat->children as $child)
						 		<li><a href="{{$child->slug}}">{{$child->title}}</a></li>
						 	@endforeach
						 	@if($cat->hasMore)
						 		<div class="read-more">
						 			<a href="#">more..</a>
						 		</div>
						 	@endif
						 	</ul>
						 </div>
					 </div>
				 </div>
		 	@endforeach
		</section>
		<section class="spotligth">
		</section>
	</body>
</html>
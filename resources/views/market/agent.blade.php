@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
 <link href="{{ asset('/css/agent.css?q=874') }}" rel="stylesheet">
<div class="container">
	<div class="row">
		<div class="col-sm-12 banner-agency">
			<img src="" class="img-banner">
		</div>
	</div> 
	<div class="row">
		<!-- div info-content -->
		<div class="col-md-8 col-sm-12">
			<div class="row">
				<div class="col-sm-12">
					<ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-overview">Overview</a></li>
                        <li><a data-toggle="tab" href="#tab-about">About Us</a></li>
                        <li><a data-toggle="tab" href="#tab-branch-loc">Branch location</a></li>
                        <li><a data-toggle="tab" href="#tab-contact">Contact Us</a></li>
                    </ul>
                    <div class="tab-content">
                    	<div id="tab-overview" class="tab-pane fade in active">
                    		<div class="content-text">
	                    		<p>
	                    		With over 140 years experience in selling and letting property, Hamptons International has a network of over 85 branches across the country and internationally, marketing a huge variety of properties from compact flats to grand country estates. We’re national estate agents, with local offices. We know our local areas as well as any local agent. But our network means we can market your property to a much greater number of the right sort of buyers or tenants. And selling and letting property is not all we do. If you want to find out more about any of our additional services including Property Finance, Property Management, International Sales and Investments or Residential Developments and Investments, give us a call. Whether you are buying or renting, have a property to sell or let, need property finance, or management services, the Hamptons International brand is one you can trust.
	                    		</p>
                    		</div>
                    		<div>
                    			<table class="averages">
                    				<tbody>
                    					<tr>
                    						<th>Properties</th>
                    						<th>Number of properties</th>
                    						<th>Avg. asking price</th>
                    						<th>Avg. listing age</th>
                    					</tr>
                    					<tr>
                    						<td><a>Residential to rent</a></td>
                    						<td class="text-center">6</td>
                    						<td class="text-center">1,010</td>
                    						<td class="text-center">6 weeks</td>
                    					</tr>
                    					<tr>
                    						<td><a>Residential to sale</a></td>
                    						<td class="text-center">6</td>
                    						<td class="text-center">1,010</td>
                    						<td class="text-center">6 weeks</td>
                    					</tr>
                    				</tbody>
                    			</table>
                    		</div>
                    	</div>
                    	<div id="tab-about" class="tab-pane fade">
                    	</div>
                    	<div id="tab-branch-loc" class="tab-pane fade">
                    		<h3>Agent's branch</h3>
                    		<div id="map">
                    		</div>
                    	</div>
                    	<div id="tab-contact" class="tab-pane fade">
                    		<h3>Contact</h3>
                    	</div>
                    </div>

				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<h3>See all ads by this advertiser</h3>
				</div>
				<div class="col-sm-12">
					<a href="#" class="btn btn-default">For Sale</a>
					<a href="#" class="btn btn-default">For Rent</a>
				</div>
			</div>
		</div>
		<!-- end info-content -->
		<!-- div col-agency-contact -->
		<div class="col-md-4 col-sm-12">
			<div class="row">
				<div class="col-sm-12 details-agent-title">
					<h3>Contact details</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 details-agent">
					<div class="agent-logo">
						<img src="">
					</div>
				</div>
			</div>
		</div>
		<!-- end col-agency-contact -->
	</div>
</div>
@endsection
<!-- Stored in resources/views/child.blade.php -->
@php
use App\Model\Advert;
@endphp
@extends('layouts.home')

@section('title', $category->title)

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('next-search')
    <div class="search-alert-div hidden-xs">
        <a class="btn search-alert" href="/user/create/alert/{{$category->id}}?id={{$location->id}}"><span class="glyphicon glyphicon-bell"></span>&nbsp;&nbsp;Set Search Alert </a>
    </div>
@endsection

@section('content')


<div class="listings background-body">
    <div class="container-fluid">
        <div class="row">
            <div class="banner">
                
            </div>
        </div>
        <div class="row">
        <div class="all">
            <div class="search-alert-div visible-xs">
                <a class="search-alert" href="/user/create/alert/{{$category->id}}?id={{$location->id}}"><span class="glyphicon glyphicon-bell"></span>&nbsp;&nbsp;Set Search Alert </a>
            </div>
            <div class="top-bar visible-xs">
                <a class="filter-button btn btn-default">Filter</a>
            </div>
    <div class="col-md-3 col-sm-3 col-xs-12">
    <div class="filter-container">
        <div class="all-filters">
        <!-- <div class="l-visible-large">
            <ul class="list-group">
                @foreach($lparents as $parent)
                    <li class="list-group-item"><a href="/{{$category->slug}}/{{$parent->slug}}">{{$parent->title}}</a>&nbsp;&nbsp;</li>
                @endforeach
            </ul>
        </div> -->
        <div class="l-visible-large">
            <h4>{{$location->title}}</h4>
            <ul class="list-group">
                @foreach($locs as $cat)
                    <li class="list-group-item"><a href="/{{$category->slug}}/{{$cat->slug}}">{{$cat->title}}</a>&nbsp{{$cat->count}}</li>
                @endforeach
            </ul>
        </div>
        @if(count($parents) > 0)
        <div class="l-visible-large">
            <ul class="list-group">
                @foreach($parents as $parent)
                    <li class="list-group-item"><a href="/{{$parent->slug}}/{{$location->slug}}">{{$parent->title}}</a>&nbsp;&nbsp;</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        <div class="l-visible-large">
            <h4>{{$category->title}}</h4>
            @if(count($categories) > 0)
            <ul class="list-group">
                @foreach($categories as $cat)
                        <li class="list-group-item"><a href="/{{$cat->slug}}/{{$location->slug}}">{{$cat->title}}</a>&nbsp;&nbsp;{{$cat->count}}</li>
                @endforeach
            </ul>
            @endif
        </div>
        <div class="l-visible-large">
            <form action="{{$url}}" >
                <div class="form-group">
                    <label for="distance">Distance:</label>
                    @foreach($input as $key=>$value)
                        @if($key!=='distance')
                            <input type="hidden" name="{{$key}}" value="{{$value}}">
                        @endif
                    @endforeach
                    <select class="form-control" data-autosubmit="" name="distance" id="distanceRefine" aria-invalid="false"  onchange="this.form.submit()">
                        @foreach($distances as $key=>$value)
                            <option value="{{$key}}" @if(isset($input['distance'])&&$input['distance']==$key)) selected @endif>
                                {{$value}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="l-visible-large">
            <form action="{{$url}}" >
                <div class="form-group">
                    <label for="sort"> Sort By:</label>
                @foreach($input as $key=>$value)
                    @if($key!=='sort')
                        <input type="hidden" name="{{$key}}" value="{{$value}}">
                    @endif
                @endforeach
                <select class="form-control" name="sort" data-autosubmit="" data-analytics="gaEvent:SRP-sortlistings,defer:true" aria-invalid="false" onchange="this.form.submit()">
                    @foreach($sorts as $st)
                        <option value="{{$st->key}}" @if(isset($input['sort'])&&$input['sort']===$st->key)) selected @endif>{{$st->title}}</option>
                    @endforeach
                </select>
                </div>
            </form>
        </div>
        <div class="l-visible-large">
            @if($category->id >= 4000000000 && $category->id <= 4999999999)
            <form action="{{$url}}">
                <label for="distance">Salary</label>
                @foreach($input as $key=>$value)
                    <input type="hidden" name="{{$key}}" value="{{$value}}">
                @endforeach
                    <div class="form-group">
                        <label class="control-label" for="sal_minimum">Salary min:</label>
                        <div class="">
                        <input class="form-control" placeholder="Any" type="number" id="sal_minimum" name="sal_minimum" value="@if(isset($input['sal_minimum'])){{$input['sal_minimun']}}@endif" aria-invalid="false">
                    </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="salary_max">Salary max:</label>
                        <div class=""><input class="form-control" placeholder="Any" type="number" name="sal_maximum" value="@if(isset($input['sal_maximum'])){{$input['sal_maximum']}}@endif" aria-invalid="false">
                        </div>
                        </div>
                    <div class="form-group">
                            <div class="col-sm-offset-6 col-sm-6">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </div>
            </form>
            @else
            <form action="{{$url}}">
                <label for="distance">Price</label>
                @foreach($input as $key=>$value)
                    <input type="hidden" name="{{$key}}" value="{{$value}}">
                @endforeach
                    <div class="form-group">
                        <label class="control-label" for="min_price">Minimum Price:</label>
                        <div class="">
                        <input class="form-control" placeholder="Min" type="number" id="min_price" name="min_price" value="@if(isset($input['min_price'])){{$input['min_price']}}@endif" aria-invalid="false">
                    </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="max_price">Maximum Price:</label>
                        <div class=""><input class="form-control" placeholder="Max" type="number" name="max_price" value="@if(isset($input['max_price'])){{$input['max_price']}}@endif" aria-invalid="false">
                        </div>
                        </div>
                    <div class="form-group clearfix">
                            <div class="col-sm-offset-6 col-sm-6">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </div>
            </form>
            @endif
        </div>
        @foreach($filters as $filter)
            <div class="l-visible-large">
                @if($filter->title === 'Salary Period')
                    <h4>Salary Bands</h4>
                @else
                    <h4>{{$filter->title}}</h4>
                @endif
                <ul class="list-group">
                    @foreach($filter->vals as $val)
                        @if($val->selected===1)
                            <li class="list-group-item">{{$val->title}}</li>
                        @else
                            <li class="list-group-item"><a href="{!! $val->url !!}">{{$val->title}}</a>&nbsp;&nbsp;{{$val->count}}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endforeach
        </div>
    </div>
</div>
<div class="col-lg-7 col-sm-9 col-xs-12">
    <div class="products">
        <h4 class="items-box-head">
            List of items for {{$category->title}}, {{number_format($total)}}
        </h4>
        @foreach($products as $product)
        <div class="listing-max-pro">
            <div class="product">
                @if($product['category'] < 4000000000 || $product['category'] > 4999999999)
                <div class="listing-side">
                    <div class="listing-thumbnail">
                        <img src="{{env('AWS_WEB_IMAGE_URL')}}/{{ count($product['images'])>0?$product['images'][0]:"noimage.png"}}" data-src="{{env('AWS_WEB_IMAGE_URL')}}/{{ count($product['images'])>0?$product['images'][0]:"noimage.png"}}" class="lazyload" alt="">

                        <!-- @if(isset($product['featured'])&&$product['featured']===1&&$product['featured_expires']>$milli&&isset($product['featured_x']))
                            <span class="ribbon-featured">
                                <strong class="ribbon" data-q="featuredProduct"><span class="hide-visually">This ad is</span>Featured</strong>
                            </span>
                        @endif -->
                        <div class="listing-meta txt-sub">
                            <span class="glyphicon glyphicon-camera"> </span> <span class="image-number"> {{count($product['images'])}}</span>
                        </div>
                    </div>
                </div>
                @else
                    @if(isset($product['featured'])&&$product['featured']===1&&$product['featured_expires']>$milli&&isset($product['featured_x']))
                        <span class="ribbon-featured">
                            <strong class="ribbon-job" data-q="featuredProduct"><span class="hide-visually">This ad is</span>Featured</strong>
                        </span>
                    @endif
                @endif
                <div class="info{{($product['category'] >= 4000000000 && $product['category'] <= 4999999999) ? ' margin-left' :''}}">
                    <div class="favor">
                        @if (in_array($product['source_id'],$sids))
                            <span class="heart favroite-icon" data-id="{{$product['source_id']}}"></span>
                            <span  class="favor-text" style="display: none">SAVE</span>
                        @else
                            <span class="heart-empty favroite-icon" data-id="{{$product['source_id']}}">
                            </span>
                            <span  class="favor-text">SAVE</span>

                        @endif
                    </div>
                            <a class="listing-product" href="/p/{{$product['category']}}/{{$product['source_id']}}"> <h4 class="product-title">{{$product['title']}}</h4></a>

                            <span class="listing-location">
                                    {{$product['location_name']}}
                                </span>
                            @if($product['category'] < 4000000000 || $product['category'] > 4999999999)
                            <div class="listing-description">
                                {!! $product['description'] !!}
                            </div>
                            @else
                                <div class="link-details">
                                    <a href="/p/{{$product['category']}}/{{$product['source_id']}}">> VIEW FULL POSTING</a>
                                </div>
                            @endif

                        @if($product['meta']['price']>=0)
                                <span class="product-price">£ {{number_format($product['meta']['price']/100)}}{{isset($product['meta']['price_frequency']) ? $product['meta']['price_frequency']:''}}
                                </span>
                            @endif
                @if(isset($product['featured'])&&$product['featured']===1&&$product['featured_expires']>$milli&&isset($product['featured_x']))
                @else
                    <span class="posted-text">{{$product['posted']}}</span>
                @endif
            </div>
        </div>
        <div class="clearfix extra-info">
            <hr>
             @if($product['category'] < 4000000000 || $product['category'] > 4999999999)
                <div class="ribbons">
                    @if(isset($product['sold']) && $product['sold'] == 1)
                        <span class="ribbon sold">
                           Sold
                        </span>
                    @else
                        @if(isset($product['spotlight'])&&$product['spotlight']===1&&$product['spotlight_expires']>$milli)
                        <span class="ribbon ribbon-spotlight">
                            <strong class="" data-q="featuredProduct"><span class="hide-visually">This ad is</span>Spotlight</strong> 
                        </span>
                        @endif
                        @if(isset($product['featured'])&&$product['featured']===1&&$product['featured_expires']>$milli&&isset($product['featured_x']))
                            <span class="ribbon ribbon-featured">
                                <strong class="" data-q="featuredProduct"><span class="hide-visually">This ad is</span>Featured</strong> 
                            </span>
                        @endif
                        @if(isset($product['urgent'])&&$product['urgent']===1&&$product['urgent_expires']>$milli)
                            <span class="ribbon urgent-span">
                                <span class="ribbon-text">
                                Urgent
                                </span>
                            </span>
                        @endif
                        @if(isset($product['canship'])&&$product['canship']===1)
                            <span class="ribbon ribbon-shipping">
                                <strong class="ship-ribbon" data-q="featuredProduct"><span class="hide-visually">This ad is</span>Can Ship</strong>
                            </span>
                        @endif
                        @if(isset($product['candeliver'])&&$product['candeliver']===1)
                            <span class="ribbon ribbon-delivery">
                                <strong class="deliver-ribbon" data-q="featuredProduct"><span class="hide-visually">This ad is</span>Local Delivery</strong>
                            </span>
                        @endif
                    @endif
                </div>
                <div class="extra-options">
                    <div class="make-offer">
                        <a href="#">
                        <div class="circle">
                            <div class="text-offer">
                                <span>Make an offer</span>
                            </div>
                        </div>
                        </a>
                    </div>
                    <div class="ratings">
                        <div class="stars">
                            <span>
                                <i class="fullstar"></i>
                                <i class="fullstar"></i>
                                <i class="fullstar"></i>
                                <i class="fullstar"></i>
                                <i class="fullstar"></i>
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="link-details">
                    <a href="/p/{{$product['category']}}/{{$product['source_id']}}">> LEARN MORE ABOUT THIS ADVERTISER</a>
                </div>
            @endif
        </div>
    </div>
    @endforeach
    <div class="listing-max-pro">
        <div class="container-emailme-header text-center">
            <h4>Let Us Help With Your Search</h4>
        </div>
        <div class="container-emailme-form text-center">
            <p>Submit and sit back. We'll send you opportunities you'll actually love and some helpful advice to help make the search suck less.</p>
            <div class="row">
                <div class="col-sm-offset-2 col-sm-8">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="email-sendme">Email</span>
                            <input type="text" class="form-control" placeholder="example@email.com" aria-describedby="email-sendme">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="phone-sendme">Mobile</span>
                            <input type="text" class="form-control" placeholder="00447777777777" aria-describedby="phone-sendme">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit-sendme" class="btn btn-submit">
                    </div>
                </div>
            </div>
            <small>By clicking Submit, you accept our <a>Terms & Conditions</a>, <a>Privacy policy</a> and consent to messages</small>
        </div>
    </div>


        <nav aria-label="Page navigation">
            <div class="text-center">
            <ul class="pagination">

                <li class=" @if($page==1)disabled @endif">
                    <a href="{{$pageurl}}&page={{$page-1}}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                @foreach($pages as $p)
                    <li class="{{$page==$p?'active':''}}">
                        @if($page===$p)
                            <span> {{$p}}<span class="sr-only">(current)</span></span>
                        @else
                            <a href="{{$pageurl}}&page={{$p}}">{{$p}}</a>
                        @endif
                    </li>
                @endforeach

                <li class=" @if($page==$max)disabled @endif">
                    <a href="{{$pageurl}}&page={{$page+1}}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
            </div>
        </nav>

    </div>
    </div>
    <div class="col-md-2 col-sm-12 col-xs-12">
    </div>
        </div>
    </div>
</div>
</div>


@endsection

@section('scripts')
<script>
    
</script>
@endsection

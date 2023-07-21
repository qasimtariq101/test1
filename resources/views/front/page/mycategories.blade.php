@extends('front.layouts.default')

@section('meta')
<meta name="description" content="{{config('settings.meta_description')}}">
<meta name="keywords" content="{{config('settings.meta_keywords')}}">
<meta name="author" content="{{config('settings.site_name')}}">
<meta property="og:title" content="@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}" />
<meta property="og:type" content="article" />
<meta property="og:url" content="{{Request::url()}}" />
<meta property="og:image" content="{{url(config('settings.site_image'))}}" />
<meta property="og:site_name" content="{{config('settings.site_name')}}" />
<link rel="canonical" href="{{Request::url()}}" />
<link rel="stylesheet" href="{{ asset('css/mycatg.css') }}">
{!! html_entity_decode(config('settings.header_code')) !!}
@yield('after_styles')

@stop

@section('content')
<div id="main-content">
  <section class="kopa-area kopa-area-17" style="margin-bottom: 40px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12" style="margin-bottom: 10px;">

          @include('front.includes.breadcrumb')

        </div>
      </div>
      @if(config('settings.ad') == 1 && !empty(config('settings.ad1')))
      <div class="row">
        <div class="col-md-12 text-center ad">@php echo html_entity_decode(config('settings.ad1'))  @endphp</div>
      </div>
      @endif 
      <div class="custom-row">
    <div class="custom-col-md-12 custom-col-sm-12 custom-col-xs-12">
        <div class="custom-widget">
            <div class="custom-woocommerce custom-widget-product-categories">
                <h1>Categories | All in One</h1>
                @php
    $categoryNames = [];
    foreach($categories as $category) {
        $categoryNames[] = $category->name;
    }
    $lastCategory = array_pop($categoryNames);
    $categoriesText = count($categoryNames) > 0 ? implode(', ', $categoryNames) . ' and ' . $lastCategory : $lastCategory;
@endphp

<p>Download {{ $categoriesText }} in PDF.</p>
<p>Please choose your desired category from below:</p>

                <div class="custom-product-categories">

                    @foreach($categories as $category)
                        @if($category->sub_categories->count() > 0)
                            <h3 class="custom-cat-parent @if(app('request')->get('category') == $category->slug || in_array(app('request')->get('category'), $category->sub_categories->pluck('slug')->toArray())) custom-open @endif"> <i class="fa fa-paperclip" aria-hidden="true"> </i> 
                                <a @if(app('request')->get('category') == $category->slug || in_array(app('request')->get('category'), $category->sub_categories->pluck('slug')->toArray())) class="custom-active" @endif href="{{$category->url}}">{{$category->name}}</a></h3>
                                <ul class="custom-children">
                                    @foreach($category->sub_categories as $sub_category)
                                        <li><a @if(app('request')->get('category') == $sub_category->slug) class="custom-active" @endif href="{{$sub_category->url}}"> {{$sub_category->name}} </a></li>
                                    @endforeach
                                </ul>
                            
                        @else
                            <h3 class="custom-cat-parent"> <i class="fa fa-paperclip" aria-hidden="true"> </i> <a @if(app('request')->get('category') == $category->slug) class="custom-active" @endif href="{{$category->url}}">{{$category->name}}</a></h3>
                        @endif
                    @endforeach
                </div>
            </div>
            <!-- custom-widget -->
        </div>
        <!-- custom-col-md-12 -->

    </div>
    <!-- custom-row -->

</div>

    <!-- container -->

@if(config('settings.ad') == 1 && !empty(config('settings.ad2')))
      <div class="row">
        <div class="col-md-12 text-center ad">@php echo html_entity_decode(config('settings.ad2')) @endphp</div>
      </div>
      @endif

    </div> 
    
  </section>
  <!-- kopa-area-17 --> 
  
</div>
@stop
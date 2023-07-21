@extends('front.layouts.default')

@section('meta')
<meta name="description" content="{{config('settings.meta_description')}}">
<meta name="keywords" content="{{config('settings.meta_keywords')}}">
<meta name="author" content="{{config('settings.site_name')}}">
<meta property="og:title" content="@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}" />
<meta property="og:type" content="article" />
<meta property="og:url" content="{{Request::url()}}" />
<meta property="og:image" content="{{url('img/image.png')}}" />
<meta property="og:site_name" content="{{config('settings.site_name')}}" />
<link rel="canonical" href="{{Request::url()}}" />
@stop

@section('after_styles')
<style>
.publisher_avatar{
  border-radius: 50%;
  padding-left: 10px;
  padding-right: 10px;
  padding-top: 5px;
}  
.entry-item{
  border-radius: 5%;
  border: 3px solid #f1f1f1 !important;
}
</style>
@stop

@section('content')
<div id="main-content">
  <section class="kopa-area kopa-area-15">
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
      
      <!--First row-->
      <div class="row">
        <div class="main-col style-01 col-md-12 col-sm-12 col-xs-12">
          <div class="woocommerce-main-primary">
            <header class="woocommerce-main-header mb-3">
              @if (config('settings.search_page') == 1)
              <div class="kopa-pull-left">
                <form method="get">
                  <input type="text" class="q_input" placeholder="{{ __('Search Publisher') }}" name="q" value="{{ old('q',request()->get('q')) }}">
                </form>
              </div>
              @endif
              <div class="kopa-pull-right">                 
                {{$users->appends(request()->input())->links('vendor.pagination.default')}} 
                <!-- woocommerce-pagination --> 
                
              </div>
            </header>
            <!-- woocommerce-main-header -->
            
            <div class="woocommerce-main-content">

<div class="widget reading-module-team-list-1">
<div class="widget-content2">
      <ul class="ul-mh row">
        @forelse($users as $user)

            <li class="col-md-2 col-sm-2 col-xs-6">
                <article class="entry-item">
                    <div class="entry-top">
                        <div class="entry-thumb">
                            <a href="{{ $user->url }}"><img class="publisher_avatar lazyload" src="{{ url('img/default-avatar.png') }}" data-src="{{ $user->avatar }}" alt="{{ $user->name }}"></a>
                        </div>
                        <div class="entry-content">
                            <h4 class="entry-title"><a href="{{ $user->url }}">{{ $user->name }}</a></h4>
                            <p class="entry-job">{{ ($user->role == 1)?__('Administrator'):__('Registered User') }}</p><br/>
                            <p class="entry-job">{{ number_format($user->books_count) }} {{ __('Books') }}</p>
                        </div>
                    </div>
                    <footer>
                        <div class="kopa-social-links style-03">
                            <ul class="clearfix">
                                <li><a href="{{ ($user->fb)?$user->fb:'#' }}" class="fa fa-facebook"></a></li>
                                <li><a href="{{ ($user->tw)?$user->tw:'#' }}" class="fa fa-twitter"></a></li>
                                <li><a href="{{ ($user->gp)?$user->gp:'#' }}" class="fa fa-google-plus"></a></li>
                            </ul>
                        </div>
                    </footer>
                </article>
            </li>


        @empty
            <div class="text-center">{{ __('No results') }}</div>
        @endforelse
      </ul>
</div>
</div>
       

            </div>
            <!-- woocommerce-main-content -->
            
            <footer class="woocommerce-main-footer">
              <div class="kopa-pull-left">
                <p class="woocommerce-result-count"> {{ __('Showing')}} {{$users->count()}} {{ __('of')}} {{$users->total()}} {{ __('results')}} </p>
              </div>
              <div class="kopa-pull-right"> {{$users->appends(request()->input())->links('vendor.pagination.default')}} 
                <!-- woocommerce-pagination --> 
                
              </div>
            </footer>
            <!-- woocommerce-main-footer --> 
            
          </div>
          <!-- woocommerce-main-primary --> 
          
        </div>
        <!-- col-md-12 --> 
        
      </div>
      @if(config('settings.ad') == 1 && !empty(config('settings.ad2')))
      <div class="row">
        <div class="col-md-12 text-center ad">@php echo html_entity_decode(config('settings.ad2')) @endphp</div>
      </div>
      @endif </div>
  </section>
</div>

@stop 
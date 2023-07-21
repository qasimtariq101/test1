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
@stop


@section('after_scripts')
@if(Auth::check()) 
<script type="text/javascript">
$('.add_to_favorite').on('click', function(event) {
    event.preventDefault();
    var $elm = $(this);
    var pid = $elm.data('pid');
    $.ajax({
        url: '{{route("books.add_to_favorite")}}',
        type: 'POST',
        data: {pid: pid},
    })
    .done(function(data) {  
        
        if(data == 'added'){
            $elm.find('i').addClass('fa-heart');
            $elm.find('i').removeClass('fa-heart-o');             
            $elm.attr('data-action','remove');
        }
        else if(data == 'removed'){
            $elm.find('i').addClass('fa-heart-o');  
            $elm.find('i').removeClass('fa-heart');            
            $elm.attr('data-action','add');     
        }

    });
    
}); 
</script> 
@else 
<script type="text/javascript">
$('.add_to_favorite').on('click', function(event) {
    window.location.href = '{{route("login")}}';
}); 
</script> 
@endif
@stop

@section('content')
<div id="main-content">
  <section class="kopa-area kopa-area-15">
    <div class="container">

      <div class="row">
        <div class="col-md-12" style="margin-bottom: 10px;">
          <h1>{{ $page_title}}</h1>            
          @include('front.includes.breadcrumb')
        </div>
      </div>

      <div class="row">
        <div class="main-col style-01 col-md-12 col-sm-12 col-xs-12">
          <div class="woocommerce-main-primary">
            <header class="woocommerce-main-header">
              <div class="kopa-pull-left">
                <ul class="ct-ul-2">
                  <li class="grid-view active"> <span class="fa fa-th"></span> </li>
                  <li class="list-view"> <span class="fa fa-list-ul"></span> </li>
                </ul>
                <!-- ct-ul-2 --> 
                
              </div>
              <div class="kopa-pull-right"> {{$favorite_books->appends(request()->input())->links('vendor.pagination.default')}} 
                <!-- woocommerce-pagination --> 
                
              </div>
            </header>
            <!-- woocommerce-main-header -->
            
            <div class="woocommerce-main-content">
              <ul class="ul-mh row">
                @forelse($favorite_books as $favorite_book)
                
                @php $book = $favorite_book->book; $rn = rand(1,8); @endphp
                <li class="col-md-3 col-sm-3 col-xs-3">
                  <article class="entry-item ct-item-4 style-0{{$rn}}">
                    <div class="entry-thumb"> <a href="{{$book->url}}"> <img class="lazyload" src="{{ url('images/default.png') }}" data-src="{{$book->thumbnail_f}}" alt="{{$book->title_f}}"> </a>
                      <div class="entry-content">
                        <header>
                          <h4 class="entry-title"><i class="fa {{book_icon($book->file)}} ct-alert-1 style-06"></i> @if(!empty($book->password))<i class="fa fa-lock ct-alert-1 style-03 small"></i>@endif <a href="{{$book->url}}">{{$book->title_f}}</a></h4>
                          @if(config('settings.allow_ratings') == 1)
                          <div class="kopa-rating">
                            <div class="star-rating" title="{{ __('Average Rating')}}"> @php
                              $p = ($book->average_rating * 100) / 5;
                              @endphp <span style="width: {{$p}}%;"> </span> </div>
                          </div>
                          @endif
                        </header>
                        <p>{{$book->short_overview}}</p>
                        <p class="ct-space-1"></p>
                        <div class="ct-icon-1" style="background: url({{(isset($book->user))?$book->user->avatar:'/img/default-avatar.png'}});background-size: 100%;"> </div>
                        <footer>
                          <div class="ft-wrap style-01">
                            <ul>
                              <li> <a href="@if(isset($book->user)){{$book->user->url}}@else{{'#'}}@endif"> <i class="fa fa-user"></i> {{ __('by')}} @if(isset($book->user)){{ (!empty($book->author_name))?$book->author_name:$book->user->name}}@else {{ (!empty($book->author_name))?$book->author_name:__('Guest')}}@endif </a> </li>
                              <li> <a href="{{$book->category->url}}"> <i class="fa fa-folder-o"></i> {{$book->category->name}} </a> </li>
                            </ul>
                          </div>
                          <div class="ft-wrap style-02">
                            <ul>
                              <li>
                                <div class="add-to-wishlist">
                                  <div> <a class="add_to_favorite" data-pid="{{$book->id}}" data-action="add" title="{{ __('Add to favorite')}}"> <i class="fa  @if(in_array($book->id,$favorites))  fa-heart @else   fa-heart-o @endif"></i> <span>{{ __('Add to favorite')}}</span> </a> </div>
                                </div>
                              </li>
                              <li> <a href="{{$book->url}}"> <i class="ti-new-window"></i> <span>{{ __('Details')}}</span> </a> </li>
                            </ul>
                          </div>
                        </footer>
                      </div>
                    </div>
                  </article>
                  @if(!empty($book->label))
                  <div class="badge-icon-1 style-0{{$rn}}"> {{$book->label}} <span></span> </div>
                  @endif </li>
                <!-- product-item --> 
                
                @empty
                <h1 class="text-center">{{ __('No results')}}</h1>
                @endforelse
              </ul>
            </div>
            <!-- woocommerce-main-content -->
            
            <footer class="woocommerce-main-footer">
              <div class="kopa-pull-left">
                <p class="woocommerce-result-count"> {{ __('Showing')}} {{$favorite_books->count()}} {{ __('of')}} {{$favorite_books->total()}} {{ __('results')}} </p>
              </div>
              <div class="kopa-pull-right"> {{$favorite_books->appends(request()->input())->links('vendor.pagination.default')}} 
                <!-- woocommerce-pagination --> 
                
              </div>
            </footer>
            <!-- woocommerce-main-footer --> 
            
          </div>
          <!-- woocommerce-main-primary --> 
          
        </div>
        <!-- col-md-12 --> 
        
      </div>
      <!-- row --> 
      
    </div>
    <!-- container --> 
    
  </section>
  <!-- kopa-area-15 --> 
  
</div>
<!-- main-content --> 
@stop 
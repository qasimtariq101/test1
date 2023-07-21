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
<style type="text/css">
#avatar{
  border-radius: 50%;
  height: 120px;
  width: 120px;
  margin-top: 10px;
}
.ct-btn-1{
  cursor: pointer;
}

article{
  border-radius: 5%;
  border: 3px solid #f1f1f1 !important;
}
</style>
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
    window.location.href = '{{url("login")}}';
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
          @include('front.includes.breadcrumb')
        </div>
      </div>
      @if(config('settings.ad') == 1 && !empty(config('settings.ad1')))
      <div class="row">
        <div class="col-md-12 text-center ad">@php echo html_entity_decode(config('settings.ad1')) @endphp</div>
      </div>
      @endif 
      
      <!--First row-->
      <div class="row">
        <div class="col-md-3 widget reading-module-team-list-1">
          <article class="entry-item">
            <div class="entry-top">
              <div class="entry-thumb"> <a href="{{$user->url}}"><img id="avatar" class="img-fluid" src="{{$user->avatar}}" alt="{{$user->name}}"></a> </div>
              <div class="entry-content">
                <h4 class="entry-title"><a href="{{$user->url}}">{{$user->name}}</a></h4>
                <p class="entry-job">@if($user->role == 1){{ __('Administrator')}}@else {{ __('Registered Member')}} @endif</p>
                <p class="dark-grey-text">{{ __('Joined')}} {{$user->created_ago}}</p>
                @if($user->status == 1)
                <p class="ct-alert-1 style-02 font-weight-bold">{{ __('Active')}}</p>
                @elseif($user->status == 0)
                <p class="ct-alert-1 style-01 font-weight-bold">{{ __('Pending')}}</p>
                @else
                <p class="ct-alert-1 style-03 font-weight-bold">{{ __('Banned')}}</p>
                @endif </div>
            </div>
            <footer> @if(!empty($user->fb) || !empty($user->tw) || !empty($user->gp))
              <div class="kopa-social-links style-03">
                <ul class="clearfix">
                  @if(!empty($user->fb))
                  <li><a href="{{$user->fb}}" class="fa fa-facebook"></a></li>
                  @endif
                  @if(!empty($user->tw))
                  <li><a href="{{$user->tw}}" class="fa fa-twitter"></a></li>
                  @endif
                  @if(!empty($user->gp))
                  <li><a href="{{$user->gp}}" class="fa fa-google-plus"></a></li>
                  @endif
                </ul>
              </div>
              @endif
              <p class="card-text mt-3">{{$user->about}}</p>
              <a class="ct-btn-1 style-05" data-toggle="modal" data-target="#modalContactForm">{{ __('Contact')}} <i class="fa fa-paper-plane ml-2"></i></a> </footer>
          </article>
        </div>
        <div class="main-col style-01 col-md-9 col-sm-9 col-xs-9">
          <div class="woocommerce-main-primary">
            <header class="woocommerce-main-header">
              <div class="kopa-pull-left">
                <form id="book_search_form" class="woocommerce-ordering" method="get">
                  @if (config('settings.search_page') == 1)
                   <input type="text" class="q_input mr-4" placeholder="{{ __('Search') }}" name="keyword" value="{{ old('keyword',request()->get('keyword')) }}">
                  @endif
                  <select name="s" class="orderby" onchange="document.getElementById('book_search_form').submit()" style="border: 2px solid #e9e9e9;">
                    <option @if(request()->input('s') == 1) selected @endif value="1">{{ __('Default sorting')}}</option>
                    <option @if(request()->input('s') == 2) selected @endif  value="2">{{ __('Sort by Popularit')}}</option>
                    <option @if(request()->input('s') == 3) selected @endif  value="3">{{ __('Sort by Average rating')}}</option>
                    <option @if(request()->input('s') == 4) selected @endif  value="4">{{ __('Sort by Featured')}}</option>
                  </select>

                  <input type="hidden" name="page" value="{{ old('page',request()->get('page')) }}">
                </form>
                <!-- woocommerce-ordering -->
                
                <ul class="ct-ul-2">
                  <li class="grid-view active"> <span class="fa fa-th"></span> </li>
                  <li class="list-view"> <span class="fa fa-list-ul"></span> </li>
                </ul>
                <!-- ct-ul-2 --> 
                
              </div>
              <div class="kopa-pull-right"> {{$books->appends(request()->input())->links('vendor.pagination.default')}} 
                <!-- woocommerce-pagination --> 
                
              </div>
            </header>
            <!-- woocommerce-main-header -->
            
            <div class="woocommerce-main-content">
              <ul class="ul-mh row">
                @forelse($books as $b)
                @include('front.books.item')
                @empty
                <h1 class="text-center mt-5">{{ __('No results')}}</h1>
                @endforelse
              </ul>
            </div>
            <!-- woocommerce-main-content -->
            
            <footer class="woocommerce-main-footer">
              <div class="kopa-pull-left">
                <p class="woocommerce-result-count"> {{ __('Showing')}} {{$books->count()}} {{ __('of')}} {{$books->total()}} {{ __('results')}} </p>
              </div>
              <div class="kopa-pull-right"> {{$books->appends(request()->input())->links('vendor.pagination.default')}} 
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

<!-- Modal: Contact form -->
<div class="modal" id="modalContactForm">
  <div class="modal-dialog"> 
    <!-- Content -->
    <div class="modal-content"> 
      
      <!-- Header -->
      <div class="modal-header light-blue darken-3 white-text">
        <h4 class=" pull-left"><i class="fas fa-pencil-alt"></i> {{ __('Contact')}} {{$user->name}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Body -->
      <div class="modal-body mb-0 ct-form-box">
        <div id="response" class="hidden"></div>
        <form class="eco_form" method="post" action="{{route('user.contact',['name'=>$user->name])}}">
          @csrf
          <p class="input-block">
            <input type="text" name="name" placeholder="{{ __('Name')}}" value="{{old('name')}}" class="valid" tabindex="1" required autofocus>
          </p>
          <p class="input-block">
            <input type="text" name="email" placeholder="{{ __('Your Email')}}" value="{{old('email')}}" class="valid" tabindex="2" required>
          </p>
          <p class="textarea-block">
            <textarea name="message" placeholder="{{ __('Your message')}}" minlength="10" maxlength="255" tabindex="3" required>{{old('message')}}</textarea>
          </p>

          @if(config('settings.captcha') == 1)
            @if(config('settings.captcha_type') == 1) @captcha
            @else
            <div class="input-group mt-5">
            <span class="input-group-addon p-0" style="width: 120px;text-align: left;"><img src="{{captcha_src(config('settings.custom_captcha_style'))}}" id="captchaCode" alt="" class="captcha"></span>  
            <input style="height: 5rem;" type="text" name="g-recaptcha-response" class="form-control" placeholder="{{ __('Security Check')}}" autocomplete="off" tabindex="4">
            <span class="input-group-addon"><a rel="nofollow" href="javascript:" onclick="document.getElementById('captchaCode').src='{{ url("captcha") }}/{{config('settings.custom_captcha_style')}}?'+Math.random()" class="refresh">
                                          <i class="fa fa-refresh"></i>
            </a></span>
            </div>
            @endif
          @endif 


          <p class="input-block btn-block clearfix text-center">
            <input type="submit" value="{{ __('Send')}}" class="ct-submit-1" tabindex="5">
          </p>
        </form>
      </div>
    </div>
    <!-- Content --> 
  </div>
</div>
<!-- Modal: Contact form --> 
@stop 
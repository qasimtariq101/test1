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

@section('content')
<div id="main-content">
  <section class="kopa-area kopa-area-17" style="margin-bottom: 40px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12" style="margin-bottom: 10px;">

          @include('front.includes.breadcrumb')

        </div>
      </div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="widget">
            <header class="widget-header style-01">
              <h3 class="widget-title style-02"> {{ __('Write to us')}}: </h3>
            </header>
            <div class="widget-content">
              <div class="ct-form-box">
                <div id="respond" class="comment-respond">
                  <form class="ct-form-1" action="" method="post">
                    @csrf
                    @include('front.includes.messages')
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <p class="input-block">
                          <input type="text" name="name" placeholder="{{ __('Your name')}}" value="{{old('name')}}" class="valid" autofocus tabindex="1" required>
                        </p>
                        <p class="input-block">
                          <input type="text" name="email" placeholder="{{ __('Your email')}}" value="{{old('email')}}" class="valid" tabindex="2" required>
                        </p>
                        <p class="input-block">
                          <input type="text" name="phone" placeholder="{{ __('Phone')}}" value="{{old('phone')}}" class="valid" tabindex="3">
                        </p>

                  @if(config('settings.captcha') == 1)
                    @if(config('settings.captcha_type') == 1) @captcha
                    @else
                    <div class="input-group mt-5">
                    <span class="input-group-addon p-0" style="width: 120px;text-align: left;"><img src="{{captcha_src(config('settings.custom_captcha_style'))}}" id="captchaCode" alt="" class="captcha"></span>  
                    <input style="height: 5rem;" type="text" name="g-recaptcha-response" class="form-control" placeholder="{{ __('Security Check')}}" autocomplete="off" tabindex="4" required>
                    <span class="input-group-addon"><a rel="nofollow" href="javascript:" onclick="document.getElementById('captchaCode').src='{{ url("captcha") }}/{{config('settings.custom_captcha_style')}}?'+Math.random()" class="refresh">
                                                  <i class="fa fa-refresh"></i>
                    </a></span>
                    </div>
                    @endif
                  @endif 

                      </div>
                      <!-- col-md-6 -->
                      
                      <div class="col-md-6 col-sm-6 col-xs-6">
                        <p class="textarea-block">
                          <textarea name="message" placeholder="{{ __('Your message')}}" cols="88" rows="8" tabindex="5">{{old('message')}}</textarea>
                        </p>
                      </div>
                      <!-- col-md-6 --> 
                      
                    </div>
                    <!-- row -->
                    
                    <p class="input-block btn-block clearfix text-center">
                      <input type="submit" value="{{ __('Send')}}" class="ct-submit-1" tabindex="6">
                    </p>
                  </form>
                </div>
              </div>
              <!-- form-box --> 
              
            </div>
          </div>
          <!-- widget --> 
          
        </div>
        <!-- col-md-12 --> 
        
      </div>
      <!-- row --> 
      
    </div>
    <!-- container --> 
    
  </section>
  <!-- kopa-area-17 --> 
  
</div>
@stop
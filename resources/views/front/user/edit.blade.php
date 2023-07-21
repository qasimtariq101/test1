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
.ct-form-box .input-block, .ct-form-box .textarea-block{
  margin:0 0 10px !important;
}  
#avatar{
    border-radius: 50%;
    min-height: 80px;
}
</style>
@stop

@section('after_scripts') 
<script type="text/javascript">
function loadFile(event, id){
    // alert(event.files[0]);
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById(id);
      output.src = reader.result;
       //$("#imagePreview").css("background-image", "url("+this.result+")");
    };
    reader.readAsDataURL(event.files[0]);
}    
</script> 
@stop

@section('content')
<div id="main-content">
  <section class="kopa-area kopa-area-15" style="margin-bottom: 40px;">
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
              <h3 class="widget-title style-02"> {{ __('Edit Profile')}} </h3>
            </header>
            <div class="widget-content">
              <div class="ct-form-box">
                <div id="respond" class="comment-respond">
                  <form class="eco_form" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-6 col-md-push-3"> @include('front.includes.messages')
                        <p class="input-block">
                          <label>{{ __('Username')}}</label>
                          <input type="text" value="{{$user->name}}" disabled>
                        </p>
                        <p class="input-block">
                          <label>{{ __('Email address')}}</label>
                          <input type="text" value="{{$user->email}}" disabled>
                        </p>
                        <p class="input-block">
                          <label>{{ __('Avatar')}}</label>
                          <br/>
                          <img src="{{$user->avatar}}" id="avatar" class="rounded-circle z-depth-1-half avatar-pic mb-4" height="80" width="80">
                          <input type="file" class="custom-file-input" name="avatar" id="inputGroupFile01" onchange="loadFile(this,'avatar')" aria-describedby="inputGroupFileAddon01">
                          <small>{{ __('Choose file jpg-png Max 1MB')}}</small> </p>
                        <p class="input-block">
                          <label>{{ __('About Me')}}</label>
                          <textarea name="about" class="valid" placeholder="{{ __('Write something about yourself')}}" tabindex="1" autofocus>{{old('about',$user->about)}}</textarea>
                        </p>
                        <p class="input-block">
                          <label>{{ __('Facebook Link')}}</label>
                          <input type="text" name="fb" placeholder="{{ __('Facebook Link')}}" class="valid" value="{{old('fb',$user->fb)}}" tabindex="2">
                        </p>
                        <p class="input-block">
                          <label>{{ __('Twitter Link')}}</label>
                          <input type="text" name="tw" placeholder="{{ __('Twitter Link')}}" class="valid" value="{{old('tw',$user->tw)}}" tabindex="3">
                        </p>
                        <p class="input-block">
                          <label>{{ __('Google Plus Link')}}</label>
                          <input type="text" name="gp" placeholder="{{ __('Google Plus Link')}}" class="valid" value="{{old('gp',$user->gp)}}" tabindex="4">
                        </p>
                        <p class="input-block">
                          <label>{{ __('Password')}}</label>
                          <input type="password" name="password" placeholder="{{ __('Password')}}" value="{{old('password')}}" class="valid" tabindex="5">
                        </p>
                        <p class="input-block">
                          <label>{{ __('Confirm Password')}}</label>
                          <input type="password" name="password_confirmation" placeholder="{{ __('Confirm Password')}}" value="{{old('password_confirmation')}}" class="valid" tabindex="6">
                        </p>
                      </div>
                      <!-- col-md-6 --> 
                      
                    </div>
                    <!-- row -->
                    
                    <p class="input-block btn-block clearfix text-center">
                      <input type="submit" value="{{ __('Save')}}" class="ct-submit-1" tabindex="7">
                    </p>
                  </form>
                </div>
              </div>
              <!-- form-box --> 

              <div class="text-center"><a class="ct-btn-2 style-01" data-toggle="modal" data-target="#deleteAccModal" style="background: #ff4157;cursor: pointer;"><i class="fa fa-trash"></i> {{ __('Delete Account') }}</a></div>
              
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


<!-- The Modal -->
<div class="modal" id="deleteAccModal">
  <div class="modal-dialog modal-md">
    <div class="modal-content"> 
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title pull-left">{{ __('Delete Account')}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <form method="post" action="{{route('profile.delete')}}">
        @csrf
      <!-- Modal body -->
      <div class="modal-body">
          <div class="form-group">
             <label>{{ __('Password')}}</label>
            <input type="password" name="password" class="form-control form-control-sm" placeholder="{{ __('Enter your password') }}" tabindex="8" required>
           
          </div>



          <img src="{{captcha_src(config('settings.custom_captcha_style'))}}" id="captchaCode" alt="" class="captcha">
              <a rel="nofollow" href="javascript:;" onclick="document.getElementById('captchaCode').src='{{url('captcha/'.config('settings.custom_captcha_style'))}}?'+Math.random()" class="refresh">

                <button type="button" class="btn btn-info btn-sm btn-refresh" tabindex="11"><i class="fa fa-refresh"></i></button>
              </a>

          <div class="form-group">
            <label> {{ __('Security Check')}}</label>            
            <input type="text" name="g-recaptcha-response" class="form-control" placeholder="{{ __('Enter Security Capthcha Code') }}" tabindex="9" required>
          </div>



      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger btn-sm" tabindex="10"><i class="fa fa-trash"></i> {{ __('Confirm Delete Account')}}</button>        
        <button class="btn btn-primary btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
      </div>
      </form>

    </div>


    </div>
  </div>

@stop
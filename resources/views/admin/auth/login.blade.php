<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="csrf-token" content="{{csrf_token()}}">
<title>@if(isset($page_title)){{$page_title.' | '}}@endif{{config('settings.site_name')}}</title>
<link rel="shortcut icon" href="{{url('favicon.ico')}}" />
@yield('before_styles')
<link rel="stylesheet" href="{{url('vendor/font-awesome-4.7.0/css/font-awesome.min.css')}}" />
<link href="{{url('mdb/css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{url('mdb/css/mdb.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{url('vendor/select2/select2.min.css')}}" />
@yield('after_styles')
</head>
<body>
<main> 
  
  <!--Main layout-->
  <div class="container">
    <h1 class="text-center mt-5 mb-4">{{config('settings.site_name')}} {{ __('Admin')}}</h1>
    <!--First row-->
    <div class="row wow fadeIn" data-wow-delay="0.2s">
      <div class="col-md-8 mx-auto"> 
        
        <!-- Default form login -->
        <form class="text-center border border-light p-5" method="post" action="{{route('login')}}">
          @csrf
          <p class="h4 mb-4">{{ __('Sign in')}}</p>
          
          <!-- Email -->
          <input type="text" name="email" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="{{ __('Username  or Email address')}}" tabindex="1" autofocus required>
          
          <!-- Password -->
          <input type="password" name="password" id="defaultLoginFormPassword" class="form-control mb-4" tabindex="2" placeholder="{{ __('Password')}}" required>

          
                @if(config('settings.captcha') == 1)
                    @if(config('settings.captcha_type') == 1) @captcha
                    @else
                      <div>
        
                        <div class="input-group mb-3">

                          <div class="input-group-prepend">
                            <span class="input-group-text p-0"><img src="{{captcha_src(config('settings.custom_captcha_style'))}}" id="captchaCode" alt="" class="captcha"></span>
                          </div>
                          <input type="text" name="g-recaptcha-response" class="form-control" placeholder="{{ __('Security Check')}}" autocomplete="off" tabindex="3" required>

                          <div class="input-group-append">
                            <span class="input-group-text">
                            <a rel="nofollow" href="javascript:" onclick="document.getElementById('captchaCode').src='{{ url("captcha") }}/{{config('settings.custom_captcha_style')}}?'+Math.random()" class="refresh">
                              <i class="fa fa-refresh"></i>
                            </a>
                            </span>
                          </div>
                        </div>
                      </div>
                    @endif
                  @endif 


          <div class="d-flex justify-content-around">
            <div> 
              <!-- Remember me -->
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="defaultLoginFormRemember" name="remember" value="on" tabindex="4">
                <label class="custom-control-label" for="defaultLoginFormRemember">{{ __('Remember me')}}</label>
              </div>
            </div>
            <div> 
              <!-- Forgot password --> 
              
              @if (Route::has('password.request')) <a href="{{ route('password.request') }}"> {{ __('Forgot Your Password?') }} </a> @endif </div>
          </div>
          <div class="mt-2">@include('front.includes.messages')</div>
          
          <!-- Sign in button -->
          <button class="btn btn-indigo btn-block my-4" type="submit" tabindex="5">{{ __('Sign in')}}</button>
        </form>
        <!-- Default form login --> 
        
      </div>
    </div>
  </div>
</main>

<!--Footer-->
<footer class="text-center font-small mt-4 wow fadeIn"> 
  
  <!--Copyright-->
  <div class="footer-copyright py-3"> © {{date('Y')}} <a href="{{url('/')}}">{{config('settings.site_name')}}</a>. 
    Developed By <a href="http://ecodevs.com">EcoDevs</a> </div>
  <!--/.Copyright--> 
  
</footer>
<!--/.Footer--> 

<!-- SCRIPTS --> 
@yield('before_scripts') 
<script src="{{url('js/jquery-3.3.1.min.js')}}"></script> 
<script src="{{url('mdb/js/popper.min.js')}}"></script> 
<script src="{{url('mdb/js/bootstrap.min.js')}}"></script> 
<script src="{{url('mdb/js/mdb.min.js')}}"></script> 
@yield('after_scripts') 
<script type="text/javascript">
new WOW().init();   
</script>
</body>
</html>
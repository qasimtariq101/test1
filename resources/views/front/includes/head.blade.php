<head>
<meta name="viewport" content="width=device-width, initial-scale=0.75, maximum-scale=1.0, user-scalable=yes">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="csrf-token" content="{{csrf_token()}}">
<meta property="fb:app_id" content="3575982109152639" />
@yield('meta')
@if(Route::currentRouteName() == 'home') <title>{{config('settings.site_name')}}@if(isset($page_title)){{' - '.$page_title}}@endif</title>
@else <title>@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}</title>
@endif
<link rel="shortcut icon" href="{{url('img/taleem360icon.ico')}}" />
<link rel="icon" sizes="192x192" href="{{url(config('settings.site_favicon'))}}" />
@yield('before_styles')
<link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}" media="all" />
@if($selected_locale->site_layout == 'rtl')
<link rel="stylesheet" href="{{url('css/bootstrap-rtl.min.css')}}" media="all" />
@endif
<!--<link rel="stylesheet" href="{{url('css/font-awesome.css')}}" media="all" />-->
<link rel="stylesheet" href="{{url('css/themify-icons.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/superfish.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/megafish.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/jquery.navgoco.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/jquery.mCustomScrollbar.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/owl.carousel.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/owl.theme.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/animate.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/jquery-ui.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/woocommerce.css')}}" media="all" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel='dns-prefetch' href='//www.googletagmanager.com' />
<link rel='dns-prefetch' href='//www.googletagservices.com' />
<link rel='dns-prefetch' href='//www.google.com'>
<link rel='dns-prefetch' href='//www.gstatic.com'>
<link rel='dns-prefetch' href='//www.recaptcha.net'>
<link rel='dns-prefetch' href='//adservice.google.com' />
<link rel='dns-prefetch' href='//pagead2.googlesyndication.com' />
<link rel='dns-prefetch' href='//tpc.googlesyndication.com' />
<link rel='dns-prefetch' href='//maps.googleapis.com' />
<link rel='dns-prefetch' href='//maps.gstatic.com' />
<link rel='dns-prefetch' href='//fonts.googleapis.com' />
<link rel='dns-prefetch' href='//fonts.gstatic.com' />
<link rel='dns-prefetch' href='//ajax.googleapis.com' />
<link rel='dns-prefetch' href='//apis.google.com' />
<link rel='dns-prefetch' href='//google-analytics.com' />
<link rel='dns-prefetch' href='//www.google-analytics.com' />
<link rel='dns-prefetch' href='//ssl.google-analytics.com' />
<link rel='dns-prefetch' href='//youtube.com' />
<link rel='dns-prefetch' href='//cdnjs.cloudflare.com' />
<link rel='dns-prefetch' href='//ajax.cloudflare.com' />
<link rel='dns-prefetch' href='//www.cloudflare.com' />
<link rel='dns-prefetch' href='//static.cloudflareinsights.com' />
<link rel='dns-prefetch' href='//connect.facebook.net' />
<link rel='dns-prefetch' href='//static.xx.fbcdn.net' />
<link rel='dns-prefetch' href='//platform.twitter.com' />
<link rel='dns-prefetch' href='//syndication.twitter.com' />
<link rel='dns-prefetch' href='//drive.google.com' />

@if(config('settings.cookie_consent_bar') == 1)
<link rel="stylesheet" href="{{url('vendor/cookie-consent/cookie.css')}}" />
@endif
<link rel="stylesheet" href="{{url('css/style.min.css')}}" media="all" >
<link rel="stylesheet" href="{{url('css/app.min.css?v=1.6')}}" media="all" >
@if($selected_locale->site_layout == 'rtl')
<link rel="stylesheet" href="{{url('css/app-rtl.min.css')}}" media="all" >
@endif
<script src="{{url('js/modernizr.custom.js')}}"></script>
<!--<script src="{{url('js/eleven.js')}}"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="apple-touch-icon" href="{{url('img/icons/apple-touch-icon.png')}}">
<link rel="apple-touch-icon" sizes="72x72" href="{{url('img/icons/apple-touch-icon-72x72.png')}}">
<link rel="apple-touch-icon" sizes="114x114" href="{{url('img/icons/apple-touch-icon-114x114.png')}}">
{!! html_entity_decode(config('settings.header_code')) !!}
@yield('after_styles')
</head>

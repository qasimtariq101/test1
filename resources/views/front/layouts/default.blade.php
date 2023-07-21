<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
@include('front.includes.head')
<body class="woocommerce woocommerce-page">
@yield('body_start')	
	<div class="main-container">
@include('front.includes.header')

@yield('content')

@include('front.includes.footer')
	</div>
     
@include('front.includes.foot')
</body>
</html>
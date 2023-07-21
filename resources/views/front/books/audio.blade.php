<!DOCTYPE html>
<html class="no-js">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>{{$book->title}} - {{config('settings.site_name')}}</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}" media="all" />
</head>
<body>
<div class="text-center" @if($book->padding == 1) style="padding-top: 15%;" @endif>
  <img class="img-fluid" src="{{$book->thumbnail_f}}" alt="{{ $book->title_f }}"><br/>
  <audio autoplay controls controlsList="nodownload" style="width: 100%;">
    	<source src="{{$book->file}}">
    	{{ __('Audio playback is not supported in your browser') }} 
	</audio>
</div>
</body>
</html>

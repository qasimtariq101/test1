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
<div class="text-center">
    <div class="embed-responsive embed-responsive-21by9" style="position: inherit;">
        <iframe class="embed-responsive-item" id="pdf_view" src="{{$book->file}}" >
            <p>{{ __('Loading')}}...</p>
        </iframe>
    </div>    
</div>
</body>
</html>

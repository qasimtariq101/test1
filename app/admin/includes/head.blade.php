<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.75, maximum-scale=1.0, user-scalable=yes">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@if(isset($page_title)){{$page_title.' | '}}@endif{{config('settings.site_name')}}</title>
    <link rel="shortcut icon" href="{{config('settings.site_favicon')}}" />
    @yield('before_styles')
    <link rel="stylesheet" href="{{url('vendor/font-awesome-4.7.0/css/font-awesome.min.css')}}" />
    <link href="{{url('mdb/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('mdb/css/mdb.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('vendor/select2/select2.min.css')}}" />
    <link href="{{url('mdb/css/admin.min.css')}}" rel="stylesheet">
    @yield('after_styles')

    {!! html_entity_decode(config('settings.header_code')) !!}
</head>
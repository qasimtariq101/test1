@extends('front.layouts.default')

@section('meta')
<meta name="description" content="{{$page->description}}">
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
  <section class="kopa-area kopa-area-15">
    <div class="container">
      <div class="row">
        <div class="col-md-12" style="margin-bottom: 10px;">
          <h1>{{$page_title}}</h1>
          @include('front.includes.breadcrumb')
        </div>

        <div class="col-md-12">@php echo html_entity_decode($page->content_f) @endphp</div>
      </div>
    </div>
  </section>
</div>
@stop 
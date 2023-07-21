<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
@include('front.includes.head')
<body class="woocommerce woocommerce-page">
  <div class="main-container">


<div id="main-content">
  <section class="kopa-area kopa-area-15">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center" style="margin-bottom: 10px;">
          <h1>{{$page_title}}</h1>
          @include('front.includes.breadcrumb')
        </div>
        <div class="col-md-12 text-center">{!! html_entity_decode(config('settings.maintenance_text')) !!}</div>
      </div>
    </div>
  </section>
</div>


  </div>
     
@include('front.includes.foot')
</body>
</html>
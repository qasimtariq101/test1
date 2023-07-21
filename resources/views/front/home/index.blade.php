@extends('front.layouts.default')

@section('meta')
<meta name="description" content="{{config('settings.meta_description')}}">
<meta name="keywords" content="{{config('settings.meta_keywords')}}">
<meta name="author" content="{{config('settings.site_name')}}">
<meta property="og:title" content="@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{Request::url()}}" />
<meta property="og:image" content="{{url('img/taleem360og.jpg')}}" />
<meta property="og:site_name" content="{{config('settings.site_name')}}" />
<link rel="canonical" href="{{Request::url()}}" />
@stop

@section('after_styles')
<style>
#owl-home .item img{
    display: block;
    width: 100%;
    height: auto;
}  
</style>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "{{config('settings.site_name')}}",
  "url": "{{url('/')}}",
  "description": "{{config('settings.meta_description')}}",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "{{url('/')}}/pages/search-results?q={search_term_string}",
    "query-input": "required name=search_term_string"
  },
  "sameAs": [
    @if(!empty(config('settings.social_fb')))"{{config('settings.social_fb')}}",@endif
    @if(!empty(config('settings.social_tw')))"{{config('settings.social_tw')}}",@endif
    @if(!empty(config('settings.social_insta')))"{{config('settings.social_insta')}}",@endif
	@if(!empty(config('settings.social_pin')))"{{config('settings.social_pin')}}",@endif
	@if(!empty(config('settings.social_yt')))"{{config('settings.social_yt')}}"@endif
  ]
}
</script>

@stop


@section('after_scripts')
<script type="text/javascript">
$(document).ready(function() {
 
  $("#owl-home").owlCarousel({
      lazyLoad : true,
      lazyFollow : true,
      navigation : true, // Show next and prev buttons
      slideSpeed : 300,
      paginationSpeed : 400,
      singleItem:true,
      pagination: false,
      navigationText : ["",""],
  });
 
});

</script>
@if(Auth::check())
<script type="text/javascript">
$('.add_to_favorite').on('click', function(event) {
    event.preventDefault();
    var $elm = $(this);
    var pid = $elm.data('pid');
    $.ajax({
        url: '{{route("books.add_to_favorite")}}',
        type: 'POST',
        data: {pid: pid},
    })
    .done(function(data) {

        if(data == 'added'){
            $elm.find('i').addClass('fa-heart');
            $elm.find('i').removeClass('fa-heart-o');
            $elm.attr('data-action','remove');
        }
        else if(data == 'removed'){
            $elm.find('i').addClass('fa-heart-o');
            $elm.find('i').removeClass('fa-heart');
            $elm.attr('data-action','add');
        }

    });

});
</script>
@else
<script type="text/javascript">
$('.add_to_favorite').on('click', function(event) {
    window.location.href = '{{url("login")}}';
});
</script>
@endif
@stop

@section('content')
<div id="main-content">
  <section class="kopa-area kopa-area-15">
    <div class="container">
	<h1 style="position:absolute;top:-9000px;left:-9000px;">Taleem360 - Books, Notes & PDF Collection</h1>
                    @if($slides->count() > 0)
                    <div class="row">
                    
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-5">
                    

                          <div id="owl-home" class="owl-carousel owl-theme">
                            @foreach($slides as $slide)
                            <div class="item">
                              <a href="https://www.taleem360.com/t-ads/click.php?id=taleem360app-9" target="_blank"><img class="lazyOwl" data-src="{{ url($slide->image) }}" alt="{{ $slide->name }}"></a>
                            </div>
                            @endforeach
                           
                          </div>


                        </div>
                        <!-- col-md-12 -->
                    
                    </div>
                    <!-- row --> 
                    @endif


      <div class="row">
        <div class="main-col col-md-9 col-sm-9 col-xs-9"> @if(config('settings.ad') == 1 && !empty(config('settings.ad1')))
          <div class="row">
            <div class="col-md-12 text-center ad">@php echo html_entity_decode(config('settings.ad1')) @endphp</div>
          </div>
          @endif

          @include('front.includes.messages')

          @if($featured_books->count() > 0)
          <div class="widget reading-module-product-list-1">
            <h2 class="widget-title style-07"><span>{{ __('Featured')}}</span> {{ __('Books')}}</h2>
            <div class="widget-content">
              <div class="row">
                <div class="owl-carousel owl-carousel-3 owl-btn-02"> @forelse($featured_books as $b)
                  @include('front.books.item_c')
                  @empty
                  <h3 class="text-center">{{ __('No results')}}</h3>
                  @endforelse </div>
                <!-- owl-carousel-3 -->

              </div>
              <!-- row -->

            </div>
          </div>
          <!-- widget -->
          @endif
          <div class="widget reading-module-product-list-1">
            <h2 class="widget-title style-07"><span>{{ __('Popular')}}</span> {{ __('Books')}}</h2>
            <div class="widget-content">
              <div class="row">
                <div class="owl-carousel owl-carousel-3 owl-btn-02"> @forelse($popular_books as $b)
                  @include('front.books.item_c')
                  @empty
                  <h3 class="text-center">{{ __('No results')}}</h3>
                  @endforelse </div>
                <!-- owl-carousel-3 -->

              </div>
              <!-- row -->

            </div>
          </div>
          <!-- widget -->

          <div class="widget reading-module-product-list-1">
            <h2 class="widget-title style-07"><span>{{ __('New')}}</span> {{ __('Books')}}</h2>
            <div class="widget-content">
              <div class="row">
                <div class="owl-carousel owl-carousel-3 owl-btn-02"> @forelse($books as $b)
                  @include('front.books.item_c')
                  @empty
                  <h3 class="text-center">{{ __('No results')}}</h3>
                  @endforelse </div>
                <!-- owl-carousel-3 -->

              </div>
              <!-- row -->

            </div>
          </div>
          <!-- widget -->

          @if(config('settings.ad') == 1 && !empty(config('settings.ad2')))
          <div class="row">
            <div class="col-md-12 text-center ad">@php echo html_entity_decode(config('settings.ad2')) @endphp</div>
          </div>
          @endif </div>
        <!-- col-md-9 -->

        @include('front.includes.sidebar') </div>
      <!-- row -->

    </div>
    <!-- container -->

  </section>
  <!-- kopa-area-15 -->

</div>
<!-- main-content -->
@stop

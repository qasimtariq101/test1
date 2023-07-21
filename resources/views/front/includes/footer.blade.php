<!-- The Modal -->
<div class="modal" id="localeModal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content"> 
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title pull-left">{{ __('Site Languages')}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
        <ul style="list-style-type: none !important;">
          @forelse($locales as $lang)
          <li style="list-style:none !important;"><a href="{{url('lang/'.$lang->code)}}" style="margin-left: 9.0rem!important;">{{$lang->name}}</a></li>
          @empty
          {{ __('No results')}}
          @endforelse
        </ul>
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button class="btn btn-danger btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
      </div>
    </div>
  </div>
</div>
<div class="bottom-sidebar kopa-area-15 white-text-style">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="widget reading-module-intro-2">
          <div class="widget-content"> <a href="#"><img src="{{url(config('settings.footer_logo'))}}" alt="Taleem360 Logo"></a>
            <p>@php echo html_entity_decode(config('settings.footer_text')) @endphp </p>
            <p><div id="ezoic-accreditation-container"></div></p>
            @if(!empty(config('settings.social_fb')) || !empty(config('settings.social_tw')) || !empty(config('settings.social_insta')) || !empty(config('settings.social_gp')))
            <div class="kopa-social-links style-02">
              <ul class="clearfix">
                @if(!empty(config('settings.social_fb')))<li><a href="{{config('settings.social_fb')}}" class="fa fa-facebook" rel="nofollow" target="_blank"></a></li>@endif
                @if(!empty(config('settings.social_tw')))<li><a href="{{config('settings.social_tw')}}" class="fa fa-twitter" rel="nofollow" target="_blank"></a></li>@endif
                @if(!empty(config('settings.social_insta')))<li><a href="{{config('settings.social_insta')}}" class="fa fa-instagram" rel="nofollow" target="_blank"></a></li>@endif
                @if(!empty(config('settings.social_yt')))<li><a href="{{config('settings.social_yt')}}" class="fa fa-youtube-play" rel="nofollow" target="_blank"></a></li>@endif
                @if(!empty(config('settings.social_wapp')))<li><a href="{{config('settings.social_wapp')}}" class="fa fa-whatsapp" rel="nofollow" target="_blank"></a></li>@endif
                @if(!empty(config('settings.social_lin')))<li><a href="{{config('settings.social_lin')}}" class="fa fa-linkedin" rel="nofollow" target="_blank"></a></li>@endif
                @if(!empty(config('settings.social_pin')))<li><a href="{{config('settings.social_pin')}}" class="fa fa-pinterest" rel="nofollow" target="_blank"></a></li>@endif
              </ul>
            </div>
            @endif
          </div>
        </div>
        <!-- widget --> 
        
      </div>
      <!-- col-md-3 -->
      
      <div class="col-md-3 col-sm-3 col-xs-3">
        <div class="widget widget_nav_menu ct-widget-1">
          <p class="widget-title style-04">{{ __('Useful')}}<span>{{ __('links')}}</span></p>
          <ul class="clearfix">
            @if(config('settings.publishers_page') == 1)
            <li class="@if(Route::currentRouteName() == 'publishers.index') current-menu-item @endif"> <a href="{{route('publishers.index')}}"> {{ __('Publishers')}} </a> </li>
            @endif          
            <li> <a href="{{route('contact')}}"> {{ __('Contact Us')}} </a> </li>
            <li> <a href="{{route('sitemaps')}}"> {{ __('Sitemap')}} </a> </li>
            <li> <a href="#" data-toggle="modal" data-target="#localeModal"> {{ __('Site Languages')}} </a> </li>
            <li> <a href="{{route('mycategories')}}"> {{ __('Categories')}} </a> </li>
          </ul>
        </div>
        <!-- widget --> 
        
      </div>
      <!-- col-md-3 -->
      
      <div class="col-md-3 col-sm-3 col-xs-3">
        <div class="widget widget_nav_menu ct-widget-1">
          <p class="widget-title style-04">{{ __('our')}}<span>{{ __('info')}}</span></p>
          <ul class="clearfix">
            @foreach($content_pages as $content_page)
            <li> <a href="{{ $content_page->url }}"> {{ $content_page->title }} </a> </li>
            @endforeach
          </ul>
        </div>
        <!-- widget --> 
        
      </div>
      <!-- col-md-3 --> 
      
    </div>
    <!-- row --> 
    
  </div>
  <!-- container --> 
  
</div>
<!-- bottom-sidebar -->

<footer class="kopa-footer">
  <div class="container">
    <div class="kopa-pull-left">
      <p class="copyright">&copy; Copyright {{date('Y')}} <a href="{{url('/')}}">{{config('settings.site_name')}}</a>. All Rights Reserved.</p>
    </div>
    <div class="kopa-pull-right">
      <p class="copyright">Powered by our <span style="color:red;">Students & Teachers</span> </p>
    </div>
  </div>
  <!-- container --> 
</footer>
<a href="#" class="scroll-up"><span class="ti-arrow-up"></span></a>
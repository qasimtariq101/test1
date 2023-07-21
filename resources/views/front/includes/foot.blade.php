
<div class="body-overlay"></div>
<div class="body-background"></div>
<section class="slide-area">
  <div class="close-btn"> <span class="close-icon ti-close"></span> </div>
  <div class="slide-container">

    <nav class="mobile-nav">
      <ul class="mobile-menu">
        <li class="@if(Route::currentRouteName() == 'home') current-menu-item @endif"> <a href="{{ route('home') }}">{{ __('Home')}}</a> </li>
        <li class="@if(Route::currentRouteName() == 'books.index') current-menu-item @endif"> <a href="{{ route('books.index') }}">{{ __('Books')}}</a> </li>
        <li class="@if(Route::currentRouteName() == 'mycategories') current-menu-item @endif"> <a href="{{route('mycategories')}}"> {{ __('Categories')}} </a> </li>
        
        <!--<li class="@if(Request::segment(2) == 'all-in-one') current-menu-item @endif"> <a href="{{route('page.show',['all-in-one'])}}"> {{ __('All in One')}} </a> </li>-->

        @if(config('settings.publishers_page') == 1)
        <li class="@if(Route::currentRouteName() == 'publishers.index') current-menu-item @endif"> <a href="{{route('publishers.index')}}"> {{ __('Publishers')}} </a> </li>
        @endif        
        <li class="@if(Request::segment(2) == 'about') current-menu-item @endif"> <a href="{{route('page.show',['about'])}}">{{ __('About Us')}}</a> </li>
        <li class="@if(Route::currentRouteName() == 'contact') current-menu-item @endif"> <a href="{{route('contact')}}">{{ __('Contact Us')}}</a> </li>
        <li> <a href="https://www.taleem360.com/pages/download-app"><i class="fa fa-android"></i> {{ __('Android App')}} </a> </li>
        <li class="@if(Route::currentRouteName() == 'upload') current-menu-item @endif"> <a href="{{route('upload')}}"><i class="fa fa-upload"></i> {{ __('Upload')}}</a> </li>
      </ul>
    </nav>
    <!-- mmobile-nav -->

    @if(!empty(config('settings.social_fb')) || !empty(config('settings.social_tw')) || !empty(config('settings.social_insta')) || !empty(config('settings.social_gp')))
    <div class="kopa-social-links style-01">
      <ul class="clearfix">
        @if(!empty(config('settings.social_fb')))
        <li><a href="{{config('settings.social_fb')}}" class="fa fa-facebook"></a></li>
        @endif
        @if(!empty(config('settings.social_tw')))
        <li><a href="{{config('settings.social_tw')}}" class="fa fa-twitter"></a></li>
        @endif
        @if(!empty(config('settings.social_insta')))
        <li><a href="{{config('settings.social_insta')}}" class="fa fa-instagram"></a></li>
        @endif
        @if(!empty(config('settings.social_gp')))
        <li><a href="{{config('settings.social_gp')}}" class="fa fa-google-plus"></a></li>
        @endif
      </ul>
    </div>
    <!-- social-links -->
    @endif </div>
</section>
<!-- slide-area -->

@yield('before_scripts')
<script>
var isAdBlockActive = true;  
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script src="{{url('js/bootstrap.min.js')}}"></script>
<script src="{{url('js/ads.js')}}"></script>
<script src="{{url('js/superfish.min.js')}}"></script>
<script src="{{url('js/jquery.navgoco.min.js')}}"></script>
<script src="{{url('js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
<script src="{{url('js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{url('js/masonry.pkgd.min.js')}}"></script>
<script src="{{url('js/owl.carousel.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.9.0/jquery.validate.min.js"></script>
<script src="{{url('js/jquery-ui.min.js')}}"></script>
<script src="{{url('js/jquery.matchHeight-min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/0.1.4/wow.min.js"></script>
<script src="{{url('vendor/lazyload/lazyload.min.js')}}"></script>
<script>
lazyload();    
</script>

<script type="text/javascript">
        // Off Canvas Open close
        $("#320Menu_a").on('click', function () {
            $("body").addClass('fix');
            $(".off-canvas-wrapper").addClass('open');
        });

        $(".btn-close-off-canvas,.off-canvas-overlay").on('click', function () {
            $("body").removeClass('fix');
            $(".off-canvas-wrapper").removeClass('open');
        });

        // offcanvas mobile menu
        var $offCanvasNav = $('.gobile-menu'),
            $offCanvasNavSubMenu = $offCanvasNav.find('.dropdown');

        /*Add Toggle Button With Off Canvas Sub Menu*/
        $offCanvasNavSubMenu.parent().prepend('<span class="menu-expand"><i></i></span>');

        /*Close Off Canvas Sub Menu*/
        $offCanvasNavSubMenu.slideUp();

        /*Category Sub Menu Toggle*/
        $offCanvasNav.on('click', 'li a, li .menu-expand', function (e) {
            var $this = $(this);
            if (($this.parent().attr('class').match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/)) && ($this.attr('href') === '#' || $this.hasClass('menu-expand'))) {
                e.preventDefault();
                if ($this.siblings('ul:visible').length) {
                    $this.parent('li').removeClass('active');
                    $this.siblings('ul').slideUp();
                } else {
                    $this.parent('li').addClass('active');
                    $this.closest('li').siblings('li').removeClass('active').find('li').removeClass('active');
                    $this.closest('li').siblings('li').find('ul:visible').slideUp();
                    $this.siblings('ul').slideDown();
                }
            }
        });
</script>

<script>
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navidstickymenu");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navidstickymenu.classList.add("stickymenuclass")
  } else {
    navidstickymenu.classList.remove("stickymenuclass");
  }
}
</script>

@if(config('settings.cookie_consent_bar') == 1)
<script>
var cookie_consent_message = 'This website uses cookies to ensure you get the best experience on our website';  
var cookie_consent_link = '{{ route("page.show",['privacy-policy']) }}';
</script>
<script src="{{url('vendor/cookie-consent/cookie.js?v=1')}}" data-cfasync="false"></script>
@endif
<script src="{{url('js/custom.js?v=1.2.1')}}" charset="utf-8"></script>
@if(config('settings.ad_block_detection') == 1)
<script>
var ad_block_message = '{{ __("AdBlock Detected") }}';  
if(isAdBlockActive){
  $('.kopa-area > .container').html('<div class="text-center" style="padding-bottom:250px;"><h1>'+ad_block_message+'</h1></div>')
}  
</script>
@endif
@yield('after_scripts')
{!! html_entity_decode(config('settings.analytics_code')) !!}
{!! html_entity_decode(config('settings.footer_code')) !!}

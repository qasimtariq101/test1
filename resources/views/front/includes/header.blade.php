@if(config('settings.header_style') == 1)
<header class="kopa-page-header-1">
  <div class="container">
    <div class="row">
      <div class="col-md-2 col-sm-6 col-xs-6 text-left">
        <div class="hamburger-menu hidden-lg"> <span class="ti-menu" style="font-size: 22px;"></span> </div>
        <!-- hamburger-menu -->

        <div class="kopa-logo"> <a href="{{url('/')}}" class="kopa-pull-left"> <img src="{{url(config('settings.site_logo'))}}" alt="{{config('settings.site_name')}}" style="height: 50px;">  </a> </div>
        <!-- logo -->

      </div>
      <!-- col-md-2 -->

      <div class="col-md-8 col-sm-0 col-xs-0">
        <nav class="main-nav">

          <ul class="main-menu sf-menu">
            <li class="@if(Route::currentRouteName() == 'home') current-menu-item @endif"> <a href="{{url('/')}}"> {{ __('Home')}} </a> </li>
            <li class="@if(Route::currentRouteName() == 'books.index') current-menu-item @endif"> <a href="{{route('books.index')}}"> {{ __('Books')}} </a> </li>
           @if(config('settings.publishers_page') == 1)
            <li class="@if(Route::currentRouteName() == 'publishers.index') current-menu-item @endif"> <a href="{{route('publishers.index')}}"> {{ __('Publishers')}} </a> </li>
            @endif
            <li class="@if(Route::currentRouteName() == 'mycategories') current-menu-item @endif"> <a href="{{route('mycategories')}}"> {{ __('Categories')}} </a> </li>
            <li class="@if(Route::currentRouteName() == 'upload') current-menu-item @endif"> <a href="{{route('upload')}}"><i class="fa fa-upload"></i> {{ __('Upload')}} </a> </li>
          </ul>

        </nav>
        <!-- main-nav -->

      </div>
      <!-- col-md-8 -->

      <div class="col-md-2 col-sm-6 col-xs-6 text-right">
        <div class="short-nav kopa-dropdown">
          
          <div class="cp kopa-dropdown-btn">
            @if(Auth::check())
              <img class="img-circle" src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" style="margin-top: -5px;height:32px;width:32px;">
            @else
              <i class="fa fa-user-circle-o auth_icon_2 {{ Auth::check() ? 'text-info' : '' }}"></i> 
            @endif

          </div>


          <div class="kopa-dropdown-content">
            <ul class="clearfix">
              @if(Auth::check())
              @if(Auth::user()->role == 1)
              <li><a href="{{url('admin/dashboard')}}"><i class="ti-dashboard"></i> {{ __('Admin Panel')}} </a></li>
              @endif
              <li><a href="{{Auth::user()->url}}"><i class="ti-user"></i> {{ __('My Profile')}} </a></li>
              <li><a href="{{route('my_books')}}"><i class="fa fa-book"></i> {{ __('My eBooks')}} </a></li>
              <li><a href="{{route('favorites')}}"><i class="ti-heart"></i> {{ __('Favorites')}} </a></li>
              <li><a href="{{route('profile')}}"><i class="fa fa-vcard-o"></i> {{ __('Edit Profile')}} </a></li>
              <li><a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="ti-share-alt"></i>{{ __('Logout')}} </a> </li>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
              @else
              <li><a href="{{route('register')}}"><i class="ti-user"></i> {{ __('Sign up')}} </a></li>
              <li><a href="{{route('login')}}"><i class="ti-lock"></i> {{ __('Login')}} </a></li>
              @endif
            </ul>
          </div>
        </div>
        <!-- short-nav -->

        <div class="short-nav kopa-dropdown">
          <div class="cp kopa-dropdown-btn lang-dropdown-2">
              <span class="fa fa-language"></span>
          </div>
          <div class="kopa-dropdown-content">
            <ul class="clearfix">
              @forelse($locales as $lang)
              <li><a class="{{ $selected_locale->code == $lang->code ? 'active' : '' }}" href="{{ url('lang/'.$lang->code) }}"> {{ $lang->name }} </a></li>
              @empty
                {{ __('No results') }}
              @endforelse
            </ul>
          </div>
      </div>
      <!-- short-nav -->   

        
        @if(config('settings.search_page') == 1)
        <div class="kopa-search-box-1 kopa-dropdown"> <span class="ti-search kopa-dropdown-btn"></span>

          <form action="{{route('books.index')}}" class="search-form-1 kopa-dropdown-content" method="get">
            <input class="search-text" type="text" onBlur="if (this.value == '')
                                    this.value = this.defaultValue;" onFocus="if (this.value == this.defaultValue)
                                    this.value = '';" value="{{ __('Search')}}..." placeholder="{{ __('Search')}}..." name="keyword">
          </form>

        </div>
        <!-- search-box -->
        @endif
      </div>
      <!-- col-md-2 -->

    </div>
    <!-- row -->

  </div>
</header>

@else



        <header class="kopa-page-header-3">

            <div class="kopa-header-top">

                <div class="container mr-auto">

                    <div class="kopa-pull-left">

                        <div class="kopa-social-links style-03">
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
                        <!-- social-links -->
                                        
                    </div>

                    <!--<div class="kopa-pull-right">
                        
                        <nav class="top-nav">
                            <ul class="top-menu sf-menu">
                                <li>
                                    <a href="{{ route('page.show',['about']) }}"> {{ __('About Us') }} </a>
                                </li>
                                <li>
                                    <a href="{{ route('contact') }}"> {{ __('Contact Us') }} </a>
                                </li>
                                @if(!Auth::check())
                                <li>
                                    <a href="{{ route('login') }}"> {{ __('Login') }} </a>
                                </li>
                                <li>
                                    <a href="{{ route('register') }}"> {{ __('Sign up') }} </a>
                                </li> 
                                @endif
                            </ul>                
                        </nav>

                    </div>-->
                
                </div>
                <!-- container -->

            </div>

            <div class="kopa-header-bottom style-01">

                <div class="container">

                    <div class="row">
                    
                        <div class="col-md-2 col-sm-6 col-xs-6 text-left">

                            <div class="hamburger-menu hidden-lg">
                                <span class="ti-menu" style="font-size:22px;"></span>
                            </div>
                            <!-- hamburger-menu -->

                            <div class="kopa-logo">
                                <a href="{{url('/')}}" class="kopa-pull-left"> 
                                  <img src="{{url(config('settings.site_logo'))}}" alt="{{config('settings.site_name')}}" style="height: 50px;"> 
                                </a> 
                            </div>
                            <!-- logo -->
                    
                        </div>
                        <!-- col-md-2 -->
                    
                        <div class="col-md-8 col-sm-0 col-xs-0">

                            <nav class="main-nav">

          <ul class="main-menu sf-menu">
            <li class="@if(Route::currentRouteName() == 'home') current-menu-item @endif"> <a href="{{url('/')}}"> {{ __('Home')}} </a> </li>
            <li class="@if(Route::currentRouteName() == 'books.index') current-menu-item @endif"> <a href="{{route('books.index')}}"> {{ __('Books')}} </a> </li>
            <li class="@if(Route::currentRouteName() == 'mycategories') current-menu-item @endif"> <a href="{{route('mycategories')}}"> {{ __('Categories')}} </a> </li>
           @if(config('settings.publishers_page') == 1)
            <li class="@if(Route::currentRouteName() == 'publishers.index') current-menu-item @endif"> <a href="{{route('publishers.index')}}">{{ __('Publishers')}} </a> </li>
            @endif
            <!--<li class="@if(Request::segment(2) == 'all-in-one') current-menu-item @endif"> <a href="{{route('page.show',['all-in-one'])}}"> {{ __('All in One')}} </a> </li>
            <li class="@if(Request::segment(2) == 'advertise-with-us') current-menu-item @endif"> <a href="{{route('page.show',['advertise-with-us'])}}"> {{ __('Advertise')}} </a> </li>-->
            <li> <a href="https://www.taleem360.com/pages/download-app"><i class="fa fa-android"></i> {{ __('Android App')}} </a> </li>
            <li class="@if(Route::currentRouteName() == 'upload') current-menu-item @endif"> <a href="{{route('upload')}}"><i class="fa fa-upload"></i> {{ __('Upload')}} </a> </li>
          </ul>

                            </nav>
                            <!-- main-nav -->
                    
                        </div>
                        <!-- col-md-8 -->
                    
                        <div class="col-md-2 col-sm-6 col-xs-6 text-right">

                            <div class="short-nav kopa-dropdown">
                                <div class="cp kopa-dropdown-btn">
                                  @if(Auth::check())
                                    <img class="img-circle" src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" style="margin-top: -5px;height:32px;width:32px;">
                                  @else
                                    <i class="fa fa-user-circle-o auth_icon {{ Auth::check() ? 'text-info' : '' }}"></i> 
                                  @endif

                                </div>

                                
                                <div class="kopa-dropdown-content">
                                  <ul class="clearfix">
                                    @if(Auth::check())
                                    @if(Auth::user()->role == 1)
                                    <li><a href="{{url('admin/dashboard')}}"><i class="ti-dashboard"></i> {{ __('Admin Panel')}} </a></li>
                                    @endif
                                    <li><a href="{{Auth::user()->url}}"><i class="ti-user"></i> {{ __('My Profile')}} </a></li>
                                    <li><a href="{{route('my_books')}}"><i class="fa fa-book"></i> {{ __('My eBooks')}} </a></li>
                                    <li><a href="{{route('favorites')}}"><i class="ti-heart"></i> {{ __('Favorites')}} </a></li>
                                    <li><a href="{{route('profile')}}"><i class="fa fa-vcard-o"></i> {{ __('Edit Profile')}} </a></li>
                                    <li><a href="{{ route('logout') }}"
                                                             onclick="event.preventDefault();
                                                                           document.getElementById('logout-form').submit();"><i class="ti-share-alt"></i> {{ __('Logout')}} </a> </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                      @csrf
                                    </form>
                                    @else
                                    <li><a href="{{route('register')}}"><i class="ti-user"></i> {{ __('Sign up')}} </a></li>
                                    <li><a href="{{route('login')}}"><i class="ti-lock"></i> {{ __('Login')}} </a></li>
                                    @endif
                                  </ul>
                                </div>
                            </div>
                            <!-- short-nav -->


                            <div class="short-nav kopa-dropdown">
                              <div class="cp kopa-dropdown-btn lang-dropdown-1">
                                  <span class="fa fa-language"></span>
                              </div>
                              <div class="kopa-dropdown-content">
                                <ul class="clearfix">
                                  @forelse($locales as $lang)
                                  <li><a class="{{ $selected_locale->code == $lang->code ? 'active' : '' }}" href="{{ url('lang/'.$lang->code) }}"> {{ $lang->name }} </a></li>
                                  @empty
                                    {{ __('No results') }}
                                  @endforelse
                                </ul>
                              </div>
                          </div>
                          <!-- short-nav -->                            

                            <div class="kopa-search-box-1 kopa-dropdown">
                                <span class="ti-search kopa-dropdown-btn"></span>
                                <form action="{{route('books.index')}}" class="search-form-1 kopa-dropdown-content" method="get">
                                  <input class="search-text" type="text" onBlur="if (this.value == '')
                                                          this.value = this.defaultValue;" onFocus="if (this.value == this.defaultValue)
                                                          this.value = '';" value="{{ __('Search')}}..." placeholder="{{ __('Search')}}..." name="keyword">
                                </form>
                            </div>
                            <!-- search-box -->
                    
                        </div>
                        <!-- col-md-2 -->
                    
                    </div>
                    <!-- row --> 

                </div>   

            </div>

        </header>
		
<div class="sml-dvice-menu">
    <ul class="mini-menu">
        <li>
            <a id="320Menu_a" style="cursor: pointer;">
                <img src="https://www.taleem360.com/img/navcons/hamburger/blue-white.jpg" alt="Hamburger Icon - Taleem360">
            </a>
            <div class="off-canvas-wrapper">
                <div class="off-canvas-overlay"></div>
                <div class="off-canvas-inner-content">
                    <div class="btn-close-off-canvas"><span>×</span></div>
                    <div class="off-canvas-inner">
                        <div class="mobile-navigation">
                            <ul class="gobile-menu">
                                <li>
                                    <a href="{{url('/')}}" class="child-menu">
                                        <div class="icodiv icon-home-4-xl"></div>
                                        Home
                                    </a>

                                </li>
                                <li class="menu-item-has-children"><span class="menu-expand"><i></i></span>
                                    <a href="{{url('textbooks')}}" class="child-menu">
                                        <div class="icodiv icon-book-xl"></div>
                                        Text Books
                                    </a>
                                    <ul class="dropdown" style="display: none;">
                                        <li><a href="{{url('punjabtextbooks')}}">Punjab Text Books</a></li>
										<li><a href="{{url('sindhtextbooks')}}">Sindh Text Books</a></li>
										<li><a href="{{url('balochistantextbooks')}}">Balochistan Text Books</a></li>
										<li><a href="{{url('categories/text-books-kpk')}}">KPK Text Books</a></li>
										<li><a href="{{url('categories/text-books-federal')}}">Federal Text Books</a></li>
										<li><a href="{{url('categories/snc-books')}}">SNC Text Books</a></li>
                                    </ul>
                                </li>
								<li class="menu-item-has-children"><span class="menu-expand"><i></i></span>
                                    <a href="{{url('categories/helping-notes')}}" class="child-menu">
                                        <div class="icodiv icon-edit-11-xl"></div>
                                        Notes
                                    </a>
                                    <ul class="dropdown" style="display: none;">
                                        <li class="menu-item-has-children"><span class="menu-expand"><i></i></span>
                                            <a href="{{url('categories/helping-notes')}}">Chapterwise Notes</a>
                                            <ul class="dropdown" style="display: none;">
                                                <li><a href="{{url('categories/9th-biology-notes')}}">9th Biology (EM) Notes</a></li>
												<li><a href="{{url('categories/9th-chemistry-notes')}}">9th Chemistry (EM) Notes</a></li>
												<li><a href="{{url('categories/9th-physics-notes')}}">9th Physics (EM) Notes</a></li>
												<li><a href="{{url('categories/9th-maths-notes')}}">9th Maths (EM) Notes</a></li>
												<li><a href="{{url('categories/10th-biology-notes')}}">10th Biology (EM) Notes</a></li>
												<li><a href="{{url('categories/10th-chemistry-notes')}}">10th Chemistry (EM) Notes</a></li>
												<li><a href="{{url('categories/10th-physics-notes')}}">10th Physics (EM) Notes</a></li>
												<li><a href="{{url('categories/10th-maths-notes')}}">10th Maths (EM) Notes</a></li>
												<li><a href="{{url('categories/11th-english-notes')}}">11th English Notes</a></li>
												<li><a href="{{url('categories/12th-english-notes')}}">12th English Notes</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-item-has-children"><span class="menu-expand"><i></i></span>
                                            <a href="{{url('categories/full-book-notes')}}">Full Book Notes</a>
                                            <ul class="dropdown" style="display: none;">
												<li><a href="{{url('categories/9th-helping-notes')}}">9th Class Notes</a></li>
												<li><a href="{{url('categories/10th-helping-notes')}}">10th Class Notes</a></li>
												<li><a href="{{url('categories/11th-helping-notes')}}">11th Class Notes</a></li>
												<li><a href="{{url('categories/12th-helping-notes')}}">12th Class Notes</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
								<li class="menu-item-has-children"><span class="menu-expand"><i></i></span>
                                    <a href="{{url('categories/helping-books')}}" class="child-menu">
                                        <div class="icodiv icon-literature-xl"></div>
                                        Helping Books
                                    </a>
                                    <ul class="dropdown" style="display: none;">
                                        <li><a href="{{url('categories/11th-helping-books')}}">11th Class Helping Books</a></li>
										<li><a href="{{url('categories/12th-helping-books')}}">12th Class Helping Books</a></li>
                                    </ul>
                                </li>
								<li class="menu-item-has-children"><span class="menu-expand"><i></i></span>
                                    <a href="{{url('categories/pairing-schemes')}}" class="child-menu">
                                        <div class="icodiv icon-pages-2-xl"></div>
                                        Pairing Schemes
                                    </a>
                                    <ul class="dropdown" style="display: none;">
                                        <li><a href="https://www.taleem360.com/9th-punjab-boards-pairing-scheme-for-all-subjects-in-pdf-lre">9th Pairing Scheme 2023</a></li>
										<li><a href="https://www.taleem360.com/10th-class-all-subjects-updated-pairing-scheme-pdf-g2g">10th Pairing Scheme 2023</a></li>
										<li><a href="https://www.taleem360.com/11th-class-pairing-scheme-of-all-subjects-in-pdf-hz1">11th Pairing Scheme 2023</a></li>
										<li><a href="https://www.taleem360.com/fsc-12th-class-all-subjects-pairing-scheme-pdf-lz3">12th Pairing Scheme 2023</a></li>
                                    </ul>
                                </li>
								<li class="menu-item-has-children"><span class="menu-expand"><i></i></span>
                                    <a href="{{url('categories/guess-papers')}}" class="child-menu">
                                        <div class="icodiv icon-inbox-4-xl"></div>
                                        Guess Papers
                                    </a>
                                    <ul class="dropdown" style="display: none;">
                                        <li><a href="{{url('categories/9th-guess-papers')}}">9th Class Guess Papers</a></li>
										<li><a href="{{url('categories/10th-guess-papers')}}">10th Class Guess Papers</a></li>
										<li><a href="{{url('categories/11th-guess-papers')}}">11th Class Guess Papers</a></li>
										<li><a href="{{url('categories/12th-guess-papers')}}">12th Class Guess Papers</a></li>
                                    </ul>
                                </li>
								<li class="menu-item-has-children"><span class="menu-expand"><i></i></span>
                                    <a href="{{url('categories/mcqs')}}" class="child-menu">
                                        <div class="icodiv icon-mouse-xl"></div>
                                        MCQs
                                    </a>
                                    <ul class="dropdown" style="display: none;">
                                        <li><a href="{{url('categories/9th-class-mcqs')}}">9th Class MCQs Collection</a></li>
										<li><a href="{{url('categories/10th-class-mcqs')}}">10th Class MCQs Collection</a></li>
										<li><a href="{{url('categories/1st-year-mcqs')}}">11th Class MCQs Collection</a></li>
										<li><a href="{{url('categories/2nd-year-mcqs')}}">12th Class MCQs Collection</a></li>
                                    </ul>
                                </li>
								<li class="menu-item-has-children"><span class="menu-expand"><i></i></span>
                                    <a href="{{url('categories/test-papers')}}" class="child-menu">
                                        <div class="icodiv icon-clipboard-8-xl"></div>
                                        Test Papers
                                    </a>
                                    <ul class="dropdown" style="display: none;">
                                        <li class="menu-item-has-children"><span class="menu-expand"><i></i></span>
                                            <a href="{{url('categories/test-papers')}}">Chapter Wise Tests</a>
                                            <ul class="dropdown" style="display: none;">
                                                <li><a href="{{url('categories/9th-test-papers')}}">9th Class Chapterwise Test Papers </a></li>
												<li><a href="{{url('categories/10th-test-papers')}}">10th Class Chapterwise Test Papers </a></li>
												<li><a href="{{url('categories/11th-test-papers')}}">11th Class Chapterwise Test Papers </a></li>
												<li><a href="{{url('categories/12th-test-papers')}}">12th Class Chapterwise Test Papers </a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-item-has-children"><span class="menu-expand"><i></i></span>
                                            <a href="{{url('categories/tests-full-half-book')}}">Full & Half Book Tests</a>
                                            <ul class="dropdown" style="display: none;">
												<li><a href="{{url('categories/9th-tests-fb-hb')}}">9th Full & Half Book Test Papers </a></li>
												<li><a href="{{url('categories/10th-tests-fb-hb')}}">10th Full & Half Book Test Papers </a></li>
												<li><a href="{{url('categories/11th-tests-fb-hb')}}">11th Full & Half Book Test Papers </a></li>
												<li><a href="{{url('categories/12th-tests-fb-hb')}}">12th Full & Half Book Test Papers </a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
								<li class="menu-item-has-children"><span class="menu-expand"><i></i></span>
                                    <a href="{{url('categories/oa-level-books')}}" class="child-menu">
                                        <div class="icodiv icon-globe-4-xl"></div>
                                        O/A-Level
                                    </a>
                                    <ul class="dropdown" style="display: none;">
                                        <li><a href="{{url('categories/cambridge-books')}}">Cambridge Books</a></li>
										<li><a href="{{url('categories/edexcel-books')}}">Edexcel Books</a></li>
										<li><a href="{{url('categories/aqa-books')}}">AQA Books</a></li>
										<li><a href="{{url('categories/ocr-books')}}">OCR Books</a></li>
										<li><a href="{{url('categories/ocr-books')}}">OCR Books</a></li>
										<li><a href="{{url('categories/language-books')}}">Language Books</a></li>
                                    </ul>
                                </li>
								<li>
                                    <a href="{{url('categories/entry-test')}}" class="child-menu">
                                        <div class="icodiv icon-classroom-xl"></div>
                                        MDCAT/ECAT
                                    </a>

                                </li>
                                <li>
                                    <a href="https://play.google.com/store/apps/details?id=com.epm.taleem360" target="_blank" class="child-menu">
                                        <div class="icodiv icon-android-xl"></div>
                                        Android App
                                    </a>

                                </li>

                            </ul>
                        </div>
                        <div class="offcanvas-widget-area">
                            <div class="off-canvas-social-widget">
                                @if(!empty(config('settings.social_fb')))<a href="{{config('settings.social_fb')}}" target="_blank"><img src="https://www.taleem360.com/img/navcons/navsocial/facebook-3-xl.png"  alt="Facebook Icon - Taleem360"></a>@endif
                                @if(!empty(config('settings.social_tw')))<a href="{{config('settings.social_tw')}}" target="_blank"><img src="https://www.taleem360.com/img/navcons/navsocial/twitter-3-xl.png"  alt="Twitter Icon - Taleem360"></a>@endif
								@if(!empty(config('settings.social_insta')))<a href="{{config('settings.social_insta')}}" target="_blank"><img src="https://www.taleem360.com/img/navcons/navsocial/instagram-3-xl.png"  alt="Instagram Icon - Taleem360"></a>@endif
								@if(!empty(config('settings.social_yt')))<a href="{{config('settings.social_yt')}}" target="_blank"><img src="https://www.taleem360.com/img/navcons/navsocial/youtube-3-xl.png"  alt="Youtube Icon - Taleem360"></a>@endif
								@if(!empty(config('settings.social_wapp')))<a href="{{config('settings.social_wapp')}}" target="_blank"><img src="https://www.taleem360.com/img/navcons/navsocial/whatsapp-xl.png"  alt="Whatsapp Icon - Taleem360"></a>@endif
								@if(!empty(config('settings.social_pin')))<a href="{{config('settings.social_pin')}}" target="_blank"><img src="https://www.taleem360.com/img/navcons/navsocial/pinterest-3-xl.png"  alt="Pinterest Icon - Taleem360"></a>@endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </li>
    </ul>
</div>

        <!--navbar custom-->
<div id="navidstickymenu" class="navigation">
    <div class="menubox">
        <div class="menu style-1">
            <ul class="menu" id="mainmenu">
                <li>
                    <a href="{{url('/')}}" class="menu_main" id="home">
                        <div class="icodiv icon-home-4-xl">
                        </div>
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{url('textbooks')}}" class="menu_main" id="Menuli_Textbooks">
                        <div class="icodiv icon-book-xl">
                        </div>
                        Textbooks
                    </a>
                    <div class="mega-menu full-width">
                        <div class="menu-left-box">
                            <div class="col-1">
	<div class="culmn-two">
		<ol>
			<li><a href="{{url('punjabtextbooks')}}">Punjab Text Books</a></li>
			<li><a href="{{url('sindhtextbooks')}}">Sindh Text Books</a></li>
			<li><a href="{{url('balochistantextbooks')}}">Balochistan Text Books</a></li>
			
		</ol>
	</div>
	<div class="culmn-two" style="margin-right: 0px;">
		<ol>
			<li><a href="{{url('categories/text-books-kpk')}}">KPK Text Books</a></li>
			<li><a href="{{url('categories/text-books-federal')}}">Federal Text Books</a></li>
			<li><a href="{{url('categories/snc-books')}}">SNC Text Books</a></li>
			
		</ol>
	</div>
</div>


                            <div class="menuimages"><div class="mega-menu-icons">
	<div class="icobox">
		<a href="{{url('categories/text-books')}}"><img src="https://www.taleem360.com/img/navcons/cities/lahore.png" alt="Lahore City Picture - Taleem360"><br>
		PCTB</a></div>
	<div class="icobox">
		<a href="{{url('categories/text-books-sindh')}}"><img src="https://www.taleem360.com/img/navcons/cities/karachi.png" alt="Karchi City Picture - Taleem360"><br>
		STBB</a></div>
	<div class="icobox">
		<a href="{{url('categories/text-books-balochistan')}}"><img src="https://www.taleem360.com/img/navcons/cities/quetta.png" alt="Quetta City Picture - Taleem360"><br>
		BTBB</a></div>
	<div class="icobox">
		<a href="{{url('categories/text-books-kpk')}}"><img src="https://www.taleem360.com/img/navcons/cities/peshawar.png" alt="Peshawar City Picture - Taleem360"><br>
		KPTBB</a></div>
	<div class="icobox">
		<a href="{{url('categories/text-books-federal')}}"><img src="https://www.taleem360.com/img/navcons/cities/isb.png" alt="Islamabad City Picture - Taleem360"><br>
		FBISE</a></div>
</div></div>
                        </div>
                        <div class="menu-image-story">
                            <div id="myDiv_Menuli_Textbooks">
<div>
    <p style="margin: 10px 0;font-size: 17px;font-weight:600;line-height: normal;z-index: 1;">
        Text Books of All Boards & All Classes</p>
    <p>
        Download textbooks of all boards (i.e Punjab, Sindh, KPK, Federal, Balochistan, Single National Curriculum SNC) & all classes in PDF.</p>
	<p>
        <a href="https://play.google.com/store/apps/details?id=com.epm.taleem360" target="_blank"> <i class="fa fa-download"> </i> Download Android App</a></p>
</div>

<div class="col-3">
    <div>
        <a href="{{url('books')}}">
            <img src="https://www.taleem360.com/img/navcons/navbgs/navblueboxes.jpg" alt="Taleem360 Navbar Background"></a>
    </div>
</div>

</div>
                        </div>
                    </div>
                </li>
				<li>
                    <a href="{{url('categories/helping-notes')}}" class="menu_main" id="Menuli_Notes">
                        <div class="icodiv icon-edit-11-xl">
                        </div>
                        Notes
                    </a>
                    <div class="mega-menu full-width">

                        

<div class="menu-left-box">
    <div class="col-1">
        <p style="font-size: 28px;line-height: 36px;"><a class="ds-heading" href="{{url('categories/helping-notes')}}"> Chapterwise Notes</a></p>
        <div class="culmn-two">
            <ol>
                <li><a href="{{url('categories/9th-biology-notes')}}">9th Biology (EM) Notes</a></li>
                <li><a href="{{url('categories/9th-chemistry-notes')}}">9th Chemistry (EM) Notes</a></li>
				<li><a href="{{url('categories/9th-physics-notes')}}">9th Physics (EM) Notes</a></li>
				<li><a href="{{url('categories/9th-maths-notes')}}">9th Maths (EM) Notes</a></li>
            </ol>
        </div>
        <div class="culmn-two" style="margin-right: 0px;">
            <ol>
                <li><a href="{{url('categories/10th-biology-notes')}}">10th Biology (EM) Notes</a></li>
                <li><a href="{{url('categories/10th-chemistry-notes')}}">10th Chemistry (EM) Notes</a></li>
				<li><a href="{{url('categories/10th-physics-notes')}}">10th Physics (EM) Notes</a></li>
				<li><a href="{{url('categories/10th-maths-notes')}}">10th Maths (EM) Notes</a></li>
            </ol>
        </div>
    </div>
    <div class="menuimages">
    </div>
</div>
<div style="width: 50%; float: right;">
    <div class="col-1">
        <p style="font-size: 28px;line-height: 36px;"><a class="ds-heading" href="{{url('categories/full-book-notes')}}">Full Book Notes</a></p>
        <div class="culmn-two">
            <ol>
                <li><a href="{{url('categories/9th-helping-notes')}}">9th Class Notes</a></li>
                <li><a href="{{url('categories/10th-helping-notes')}}">10th Class Notes</a></li>
                <li><a href="{{url('categories/11th-helping-notes')}}">11th Class Notes</a></li>
				<li><a href="{{url('categories/12th-helping-notes')}}">12th Class Notes</a></li>
            </ol>
        </div>
        <div class="culmn-two" style="margin-right: 0px;">
            <ol>
				<li><a href="{{url('categories/11th-english-notes')}}">11th English Notes</a></li>
				<li><a href="{{url('categories/12th-english-notes')}}">12th English Notes</a></li>
            </ol>
        </div>
    </div>
</div>

                        <div class="menuimages">
                        </div>

                        <div class="menu-image-story">
                            <div id="myDiv_Menuli_Notes">
                            </div>
                        </div>
                    </div>
                </li>
				<li>
                    <a href="{{url('categories/helping-books')}}" class="menu_main" id="Menuli_Helpingbooks">
                        <div class="icodiv icon-literature-xl">
                        </div>
                        Helping Books
                    </a>
					<div class="mega-menu full-width">
                        <div class="menu-left-box">
                            <!--ltrNewsMenu-->
                            <div class="col-1">
	<ol>
		<li><a href="{{url('categories/9th-helping-books')}}">9th Class Helping Books PDF</a></li>
		<li><a href="{{url('categories/10th-helping-books')}}">10th Class Helping Books PDF</a></li>
		<li><a href="{{url('categories/11th-helping-books')}}">11th Class Helping Books PDF</a></li>
		<li><a href="{{url('categories/12th-helping-books')}}">12th Class Helping Books PDF</a></li>
	</ol>
</div>
                        </div>
                        <div class="menu-image-story">
                            <div id="myDiv_Menuli_Helpingbooks">

<div>
    <p style="margin: 10px 0;font-size: 17px;font-weight:600;line-height: normal;z-index: 1;">
        Helping Books & Guides</p>
    <p>
        Download Intermediate (Part-I & Part-II) best helping books collection of all subjects of different boards.</p>
    <p>
        <a href="https://play.google.com/store/apps/details?id=com.epm.taleem360" target="_blank"> <i class="fa fa-download"> </i> Download Android App</a></p>
		<br><br>
</div>
<div class="col-3">
    <div>
        <a href="{{url('categories/helping-books')}}">
            <img src="https://www.taleem360.com/img/navcons/navbgs/navblueboxes.jpg" alt="Taleem360 Navbar Background"></a>
    </div>
</div>

</div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="{{url('categories/pairing-schemes')}}" class="menu_main" id="Menuli_Pairing">
                        <div class="icodiv icon-pages-2-xl">
                        </div>
                        Pairing
                    </a>
                    <div class="mega-menu full-width">
                        <div class="menu-left-box">
                            <!--ltrNewsMenu-->
                            <div class="col-1">
	<ol>
		<li><a href="https://www.taleem360.com/9th-punjab-boards-pairing-scheme-for-all-subjects-in-pdf-lre">9th Pairing Scheme 2023</a></li>
		<li><a href="https://www.taleem360.com/10th-class-all-subjects-updated-pairing-scheme-pdf-g2g">10th Pairing Scheme 2023</a></li>
	    <li><a href="https://www.taleem360.com/11th-class-pairing-scheme-of-all-subjects-in-pdf-hz1">11th Pairing Scheme 2023</a></li>
		<li><a href="https://www.taleem360.com/fsc-12th-class-all-subjects-pairing-scheme-pdf-lz3">12th Pairing Scheme 2023</a></li>
	</ol>
</div>
                        </div>
                        <div class="menu-image-story">
                            <div id="myDiv_Menuli_Pairing">

<div>
    <p style="margin: 10px 0;font-size: 17px;font-weight:600;line-height: normal;z-index: 1;">
        Latest Pairing Schemes</p>
    <p>
        Download Matriculation & Intermediate (Part-I & Part-II) Updated Pairing Schemes of all subjects</p>
    <p>
        <a href="https://play.google.com/store/apps/details?id=com.epm.taleem360" target="_blank"> <i class="fa fa-download"> </i> Download Android App</a></p>
		<br><br>
</div>
<div class="col-3">
    <div>
        <a href="{{url('categories/pairing-schemes')}}">
            <img src="https://www.taleem360.com/img/navcons/navbgs/navblueboxes.jpg" alt="Taleem360 Navbar Background"></a>
    </div>
</div>

</div>
                        </div>
                    </div>
                </li>
				<li>
                    <a href="{{url('categories/aiou-books')}}" class="menu_main" id="Menuli_AIOU">
                        <div class="icodiv icon-hotel-2-xl">
                        </div>
                        AIOU
                    </a>
                    <div class="mega-menu full-width">                  
<div class="menu-left-box">
    <div class="col-1">
        <div class="culmn-two">
		<p style="font-size: 28px;line-height: 36px;"><a class="ds-heading">Past Papers</a></p>
            <ol>
                <li><a href="{{url('categories/aiou-matric-past-papers')}}">AIOU Matric Past Papers</a></li>
				<li><a href="{{url('categories/aiou-ba-past-papers')}}">AIOU BA Past Papers</a></li>
            </ol>
        </div>
        <div class="culmn-two" style="margin-right: 0px;">
		<h2><a class="ds-heading" href="{{url('categories/aiou-books')}}">PDF Books</a></h2>
            <ol>
				<li><a href="{{url('categories/aiou-matric-books')}}">AIOU Matric Books</a></li>
				<li><a href="{{url('categories/aiou-fa-books')}}">AIOU F.A Books</a></li>
            </ol>
        </div>
    </div>
</div>
<div style="width: 50%; float: right;">
	<div class="col-1">
        <p style="font-size: 28px;line-height: 36px;"><a class="ds-heading" href="{{url('categories/aiou-solved-assignments')}}"> Solved Assignments</a></p>
            <ol>
                <li><a href="{{url('categories/aiou-matric-assignments')}}">AIOU Matric Solved Assignments</a></li>
            </ol>
    </div>
</div>
                    </div>
                </li>
				<li>
                    <a href="{{url('categories/oa-level-books')}}" class="menu_main" id="Menuli_OALevel">
                        <div class="icodiv icon-globe-4-xl">
                        </div>
                        O/A-Level
                    </a>
                    <div class="mega-menu full-width">
                        <div class="menu-left-box">
                            <div class="col-1">
	<div class="culmn-two">
		<ol>
			<li><a href="{{url('categories/cambridge-books')}}">Cambridge Books</a></li>
			<li><a href="{{url('categories/edexcel-books')}}">Edexcel Books</a></li>
			<li><a href="{{url('categories/aqa-books')}}">AQA Books</a></li>
			<li><a href="{{url('categories/ocr-books')}}">OCR Books</a></li>
			
		</ol>
	</div>
	<div class="culmn-two" style="margin-right: 0px;">
		<ol>
			<li><a href="{{url('categories/ocr-books')}}">OCR Books</a></li>
			<li><a href="{{url('categories/language-books')}}">Language Books</a></li>
			
		</ol>
	</div>
</div>


                            <div class="menuimages"><div class="mega-menu-icons">
	<div class="icobox">
		<a href="{{url('categories/text-books-kpk')}}"><img src="https://www.taleem360.com/img/navcons/cities/peshawar.png" alt="Peshawar City Picture - Taleem360"><br>
		KPTBB</a></div>
	<div class="icobox">
		<a href="{{url('categories/text-books-federal')}}"><img src="https://www.taleem360.com/img/navcons/cities/isb.png" alt="Islamabad City Picture - Taleem360"><br>
		FBISE</a></div>
</div></div>
                        </div>
                        <div class="menu-image-story">
                            <div id="myDiv_Menuli_OALevels">
<div>
    <p style="margin: 10px 0;font-size: 17px;font-weight:600;line-height: normal;z-index: 1;">
        O/A/AS/IGCSE/GCSE Books</p>
    <p>
        Download O Level, A Level, AS, IGCSE, GCSE and other international books in PDF.</p>
	<p>
        <a href="https://play.google.com/store/apps/details?id=com.epm.taleem360" target="_blank"> <i class="fa fa-download"> </i> Download Android App</a></p>
</div>

<div class="col-3">
    <div>
        <a href="{{url('categories/oa-level-books')}}">
            <img src="https://www.taleem360.com/img/navcons/navbgs/navblueboxes.jpg" alt="Taleem360 Navbar Background"></a>
    </div>
</div>

</div>
                        </div>
                    </div>
                </li>
				<li>
                    <a href="{{url('categories/test-papers')}}" class="menu_main" id="Menuli_OTS">
                        <div class="icodiv icon-clipboard-8-xl">
                        </div>
                        Test Papers
                    </a>
                    <div class="mega-menu full-width">

                        
<div class="menu-left-box">
    <div class="col-1">
        <p style="font-size: 28px;line-height: 36px;"><a class="ds-heading" href="{{url('categories/test-papers')}}"> Chapterwise Tests</a></p>
            <ol>
                <li><a href="{{url('categories/9th-test-papers')}}">9th Class Chapterwise Test Papers </a></li>
				<li><a href="{{url('categories/10th-test-papers')}}">10th Class Chapterwise Test Papers </a></li>
				<li><a href="{{url('categories/11th-test-papers')}}">11th Class Chapterwise Test Papers </a></li>
				<li><a href="{{url('categories/12th-test-papers')}}">12th Class Chapterwise Test Papers </a></li>
                
            </ol>
    </div>
    <div class="menuimages">
    </div>
</div>
<div style="width: 50%; float: right;">
    <div class="col-1">
        <p style="font-size: 28px;line-height: 36px;"><a class="ds-heading" href="{{url('categories/tests-full-half-book')}}"> Full & Half Book Tests</a></p>
            <ol>
                <li><a href="{{url('categories/9th-tests-fb-hb')}}">9th Full & Half Book Test Papers </a></li>
				<li><a href="{{url('categories/10th-tests-fb-hb')}}">10th Full & Half Book Test Papers </a></li>
				<li><a href="{{url('categories/11th-tests-fb-hb')}}">11th Full & Half Book Test Papers </a></li>
				<li><a href="{{url('categories/12th-tests-fb-hb')}}">12th Full & Half Book Test Papers </a></li>
                
            </ol>
    </div>
</div>
                    </div>
                </li>
				
                <li>
                    <a href="{{url('categories/mcqs')}}" class="menu_main" id="Menuli_MCQs">
                        <div class="icodiv icon-mouse-xl">
                        </div>
                        MCQs
                    </a>
                    <div class="mega-menu full-width">
                        <div class="menu-left-box">
                            <!--ltrNewsMenu-->
                            <div class="col-1">
	<ol>
		<li><a href="{{url('categories/9th-class-mcqs')}}">9th Class All Subjects MCQs Collection</a></li>
		<li><a href="{{url('categories/10th-class-mcqs')}}">10th Class All Subjects MCQs Collection</a></li>
		<li><a href="{{url('categories/1st-year-mcqs')}}">11th Class All Subjects MCQs Collection</a></li>
		<li><a href="{{url('categories/2nd-year-mcqs')}}">12th Class All Subjects MCQs Collection</a></li>
	</ol>
</div>
                        </div>
                        <div class="menu-image-story">
                            <div id="myDiv_Menuli_MCQs">

<div>
    <p style="margin: 10px 0;font-size: 17px;font-weight:600;line-height: normal;z-index: 1;">
        Multiple Choice Questions</p>
    <p>
        Download Matriculation & Intermediate (Part-I & Part-II) all subjects complete chapter mqcs collection in PDF.</p>
    <p>
        <a href="https://play.google.com/store/apps/details?id=com.epm.taleem360" target="_blank"> <i class="fa fa-download"> </i> Download Android App</a></p>
		<br><br>
</div>
<div class="col-3">
    <div>
        <a href="{{url('categories/mcqs')}}">
            <img src="https://www.taleem360.com/img/navcons/navbgs/navblueboxes.jpg" alt="Taleem360 Navbar Background"></a>
    </div>
</div>

</div>
                        </div>
                    </div>
                </li>
				<li>
                    <a href="{{url('categories/guess-papers')}}" class="menu_main" id="Menuli_Guess">
                        <div class="icodiv icon-inbox-4-xl">
                        </div>
                        Guess Papers
                    </a>
					<div class="mega-menu full-width">
                        <div class="menu-left-box">
                            <!--ltrNewsMenu-->
                            <div class="col-1">
	<ol>
		<li><a href="{{url('categories/9th-guess-papers')}}">9th Class All Subjects Guess Papers</a></li>
		<li><a href="{{url('categories/10th-guess-papers')}}">10th Class All Subjects Guess Papers</a></li>
		<li><a href="{{url('categories/11th-guess-papers')}}">11th Class All Subjects Guess Papers</a></li>
		<li><a href="{{url('categories/12th-guess-papers')}}">12th Class All Subjects Guess Papers</a></li>
	</ol>
</div>
                        </div>
                        <div class="menu-image-story">
                            <div id="myDiv_Menuli_Guess">

<div>
    <p style="margin: 10px 0;font-size: 17px;font-weight:600;line-height: normal;z-index: 1;">
        Updated Guess Papers</p>
    <p>
        Download Matriculation & Intermediate (Class 9th, 10th, 11th & 12th) all subjects updated guess papers in PDF.</p>
    <p>
        <a href="https://play.google.com/store/apps/details?id=com.epm.taleem360" target="_blank"> <i class="fa fa-download"> </i> Download Android App</a></p>
		<br><br>
</div>
<div class="col-3">
    <div>
        <a href="{{url('categories/guess-papers')}}">
            <img src="https://www.taleem360.com/img/navcons/navbgs/navblueboxes.jpg" alt="Taleem360 Navbar Background"></a>
    </div>
</div>

</div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="{{url('categories/date-sheets')}}" class="menu_main" id="Menuli_Datesheets">
                        <div class="icodiv icon-calendar-7-xl">
                        </div>
                        Datesheets
                    </a>
                </li>
				<li>
                    <a href="{{url('categories/past-papers-alp')}}" class="menu_main" id="Menuli_Pastpapers">
                        <div class="icodiv icon-paper-xl">
                        </div>
                        Past Papers
                    </a>
                </li>
				<li>
                    <a href="{{url('categories/chartered-accountancy')}}" class="menu_main" id="Menuli_CA">
                        <div class="icodiv icon-briefcase-7-xl">
                        </div>
                        CA
                    </a>
                </li>
				<li>
                    <a href="{{url('categories/entry-test')}}" class="menu_main" id="Menuli_EntryTest">
                        <div class="icodiv icon-classroom-xl">
                        </div>
                        MDCAT/ECAT
                    </a>
					<div class="mega-menu full-width">

                        

<div class="menu-left-box">
    <div class="col-1">
        <div class="culmn-two">
            <ol>
                <li><a href="{{url('categories/step-by-pgc')}}">STEP Books</a></li>
                <li><a href="{{url('categories/kips-academy')}}">KIPS Books</a></li>
				<li><a href="{{url('categories/stars-academy')}}">Stars Academy Books</a></li>
				<li><a href="{{url('categories/redspot-books')}}">Redspot Books</a></li>
				<li><a href="{{url('categories/pgc-books')}}">Punjab College Books</a></li>
				<li><a href="{{url('categories/dogar-entry-test-books')}}">Dogar Entry Test Books</a></li>
            </ol>
        </div>
        <div class="culmn-two" style="margin-right: 0px;">
            <ol>
                <li><a href="{{url('categories/entry-test-tips-tricks')}}">Entry Test Tips & Tricks</a></li>
                <li><a href="{{url('categories/nearpeer-books')}}">Nearpeer Books</a></li>
				<li><a href="{{url('categories/knack-institue')}}">KNACK Books</a></li>
				<li><a href="{{url('categories/era-institute')}}">ERA Books</a></li>
				<li><a href="{{url('categories/scienta-vision-books')}}">Scienta Vision Books</a></li>
				<li><a href="{{url('categories/grip-institute')}}">Grip Books</a></li>
            </ol>
        </div>
    </div>
    <div class="menuimages">
    </div>
</div>
<div style="width: 50%; float: right;">
    <div class="col-1">
        <div class="culmn-two">
            <ol>
				<li><a href="{{url('categories/nmdcat-feedback-mcqs')}}">NMDCAT Feedback MCQs</a></li>
				<li><a href="{{url('categories/pmc-practice-tests-nmdcat')}}">PMC Practice Tests</a></li>                
                <li><a href="{{url('categories/alrehman-series')}}">Alrehman Series</a></li>
                <li><a href="{{url('categories/anees-hussain-books')}}">Anees Hussain Books</a></li>
				<li><a href="{{url('categories/salman-ul-waheed-books')}}">Salman Ul Waheed Books</a></li>
				<li><a href="{{url('categories/nmdcat-worksheets-by-skn')}}">SKN Academy</a></li>
            </ol>
        </div>
        <div class="culmn-two" style="margin-right: 0px;">
            <ol>
				<li><a href="{{url('categories/mdcat-past-papers')}}">MDACT Past Papers</a></li>
				<li><a href="{{url('categories/ecat-past-papers')}}">ECAT Past Papers</a></li>
				<li><a href="{{url('categories/nust-past-papers')}}">NUST Past Papers</a></li>

            </ol>
        </div>
    </div>
</div>
                    </div>
                </li>
				<li>
                    <a href="{{url('categories/css-preparations')}}" class="menu_main" id="Menuli_News">
                        <div class="icodiv icon-trophy-xl">
                        </div>
                        CSS
                    </a>
                </li>

				<li>
                    <a href="{{url('/books')}}" class="menu_main" id="Menuli_News">
                        <div class="icodiv icon-teacher-xl">
                        </div>
                        More
                    </a>
                </li>
            </ul>
        </div>
        <div class="clr">
        </div>
    </div>
</div>
<!--navbar custom-->

@endif

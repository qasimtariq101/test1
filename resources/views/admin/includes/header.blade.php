<header> 
  
  <!-- Navbar -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
    <div class="container-fluid"> 
      
      <!-- Brand --> 
      <a class="navbar-brand waves-effect" href="{{url('admin/dashboard')}}"> <strong class="blue-text">{{config('settings.site_name')}}</strong> </a> 
      
      <!-- Collapse -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
      
      <!-- Links -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent"> 
        
        <!-- Left -->
        <ul class="navbar-nav mr-auto d-md-none">
          <li class="nav-item @if(Request::segment(2) == 'dashboard') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i> {{ __('Dashboard')}} </a> </li>
          <li class="nav-item @if(Request::segment(2) == 'categories') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/categories')}}"><i class="fa fa-list"></i> {{ __('Categories')}} </a> </li>
		  <li class="nav-item @if(Request::segment(2) == 'categories') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/categories')}}"><i class="fa fa-list"></i> {{ __('Menus')}} </a> </li>
          <li class="nav-item @if(Request::segment(2) == 'books') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/books')}}"><i class="fa fa-book"></i> {{ __('eBooks')}} </a> </li>
          <li class="nav-item @if(Request::segment(2) == 'reported-books') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/reported-books')}}"><i class="fa fa-flag"></i>{{ __('Reported Books')}} </a> </li>
          <li class="nav-item @if(Request::segment(2) == 'users') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/users')}}"><i class="fa fa-users"></i> {{ __('Users')}} </a> </li>
          <li class="nav-item @if(Request::segment(2) == 'pages') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/pages')}}"><i class="fa fa-file"></i> {{ __('Pages')}} </a> </li> 
          <li class="nav-item @if(Request::segment(2) == 'slider') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/slider')}}"><i class="fa fa-image"></i> {{ __('Slider')}} </a> </li>        
        <li class="nav-item @if(Request::segment(2) == 'site-languages') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/site-languages')}}"><i class="fa fa-language"></i> {{ __('Site Languages')}} </a> </li>            
        <li class="nav-item @if(Request::segment(2) == 'settings') active @endif"> <a class="nav-link waves-effect" href="{{url('admin/settings')}}"><i class="fa fa-cogs"></i> {{ __('Settings')}} </a> </li>
       
        </ul>
        
        <!-- Right -->
        <ul class="navbar-nav nav-flex-icons">
          <li class="nav-item btn-group"> <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-user"></i> {{Auth::user()->name}} </a>
            <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink"> <a class="dropdown-item" href="{{url('profile')}}">{{ __('Edit Profile')}}</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout')}}</a> </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Navbar -->
  
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
  
  <!-- Sidebar -->
  <div class="sidebar-fixed position-fixed"> <a class="logo-wrapper waves-effect"> <img src="{{\Auth::user()->avatar}}" class="rounded-circle z-depth-1-half avatar-pic" alt="avatar" style="height: 130px;max-height: 130px !important;"> </a>
    <div class="list-group list-group-flush"> <a href="{{url('admin/dashboard')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'dashboard') active @endif"> <i class="fa fa-dashboard mr-3"></i>{{ __('Dashboard')}} </a> <a href="{{url('admin/categories')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'categories') active @endif"> <i class="fa fa-list mr-3"></i>{{ __('Categories')}}</a> 
	<a href="{{url('admin/menus')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'menus') active @endif"> <i class="fa fa-bars mr-3"></i>{{ __('Menus')}}</a>
	<a href="{{url('admin/books')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'books') active @endif"> <i class="fa fa-book mr-3"></i>{{ __('eBooks')}}</a> <a href="{{url('admin/reported-books')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'reported-books') active @endif"> <i class="fa fa-flag mr-3"></i>{{ __('Reported Books')}}</a> <a href="{{url('admin/users')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'users') active @endif"> <i class="fa fa-users mr-3"></i>{{ __('Users')}}</a> <a href="{{url('admin/pages')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'pages') active @endif"> <i class="fa fa-file mr-3"></i>{{ __('Pages')}}</a><a href="{{url('admin/slider')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'slider') active @endif"> <i class="fa fa-image mr-3"></i>{{ __('Slider')}}</a> <a href="{{url('admin/site-languages')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'site-languages') active @endif"> <i class="fa fa-language mr-3"></i>{{ __('Site Languages')}}</a> <a href="{{url('admin/settings')}}" class="list-group-item list-group-item-action waves-effect @if(Request::segment(2) == 'settings') active @endif"> <i class="fa fa-cogs mr-3"></i>{{ __('Settings')}}</a>   <a onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action waves-effect"> <i class="fa fa-power-off mr-3"></i>{{ __('Logout')}}</a> </div>
  </div>
  <!-- Sidebar --> 
  
</header>
<!--Main Navigation-->
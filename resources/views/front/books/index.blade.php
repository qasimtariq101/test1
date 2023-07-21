@extends('front.layouts.default')

@section('meta')
@if(!empty($category))<meta name="description" content="@if(!empty($category->catgdesc)){{$category->catgdesc}}@else{{config('settings.meta_description')}}@endif">@else<meta name="description" content="{{config('settings.meta_description')}}">@endif

@if(!empty($category))<meta name="keywords" content="@if(!empty($category->catgtags)){{$category->catgtags}}@else{{config('settings.meta_keywords')}}@endif">@else<meta name="keywords" content="{{config('settings.meta_keywords')}}">@endif	
<meta name="author" content="{{config('settings.site_name')}}">
<meta property="og:title" content="@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}" />
<meta property="og:type" content="article" />
<meta property="og:url" content="{{Request::url()}}" />
<meta property="og:image" content="{{url(config('settings.site_image'))}}" />
<meta property="og:site_name" content="{{config('settings.site_name')}}" />
<link rel="canonical" href="{{Request::url()}}" />
@stop

@section('after_scripts')
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
    window.location.href = '{{route("login")}}';
}); 
</script> 
@endif
@stop

@section('content')
<div id="main-content">
  <section class="kopa-area kopa-area-15">
    <div class="container">
        <div class="row">
        <div class="col-md-12" style="margin-bottom: 10px;">
            
            
            @if(config('settings.ad') == 1 && !empty(config('settings.ad1')))
            <div class="row">
                <div class="col-md-12 text-center ad">@php echo html_entity_decode(config('settings.ad1')) @endphp</div>
            </div>
             @endif
          


        </div>
        </div>

      <div class="row">
        <div class="main-col style-01 col-md-9 col-sm-9 col-xs-9">
            
                <div class="breadcrumb-content" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="{{url('/')}}" class="active">
                            <span itemprop="name">{{ __('Home')}}</span>
                        </a>
                        <meta itemprop="position" content="1">
                    </span>
                    <span>&nbsp;&nbsp;/&nbsp;&nbsp;</span>
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="{{route('books.index')}}" class="@if(!empty($category))active @else current-page @endif">
                            <span itemprop="name">{{ __('Books')}}</span>
                        </a>
                        <meta itemprop="position" content="2">
                    </span>
                
                    @if(!empty($category))
                    <span>&nbsp;&nbsp; / &nbsp;&nbsp;</span>
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" class="current-page">
                            <span itemprop="name">{{ $category->name }}</span>
                        </a>
                        <meta itemprop="position" content="3">
                    </span>
                    @endif
                </div>


          
              @if(!empty($category))
    		  <div style="background: url(https://www.taleem360.com/img/background/headerbgblue.jpg);padding: 40px 0px;text-align: center;margin: 10px auto;color:white;">
				<h1 style="color:white;">{{ $category->name }}</h1>
				<p style="margin:auto 30px;">{{ $category->catgdesc }}</p>
			  </div>
    		  @else
    		  <h1 style="background: url(https://www.taleem360.com/img/background/headerbgblue.jpg);padding: 40px 0px;text-align: center;margin: 10px auto;color:white;">{{ __('PDF Books Collection')}}</h1>
    		  @endif
            
          @include('front.includes.messages')
          <div class="woocommerce-main-primary">
            <header class="woocommerce-main-header">
              <div class="kopa-pull-left">
                <form id="book_search_form" class="woocommerce-ordering" method="get">
                  @if (config('settings.search_page') == 1)
                  <input type="text" class="q_input mr-4" placeholder="{{ __('Search') }}" name="keyword" value="{{ old('keyword',request()->get('keyword')) }}">
                  @endif
                  <select name="s" class="orderby" onchange="document.getElementById('book_search_form').submit()" style="border: 2px solid #e9e9e9;">
                    <option @if(request()->input('s') == 1) selected @endif value="1">{{ __('Default sorting')}}</option>
                    <option @if(request()->input('s') == 2) selected @endif  value="2">{{ __('Sort by Popularit')}}</option>
                    <option @if(request()->input('s') == 3) selected @endif  value="3">{{ __('Sort by Average rating')}}</option>
                    <option @if(request()->input('s') == 4) selected @endif  value="4">{{ __('Sort by Featured')}}</option>
                  </select>

                  <input type="hidden" name="page" value="{{ old('page',request()->get('page')) }}">
                </form>
                <!-- woocommerce-ordering -->
                
                <ul class="ct-ul-2">
                  <li class="grid-view {{ (config('settings.default_books_page_view') == 'grid')?'active':'' }}"> <span class="fa fa-th"></span> </li>
                  <li class="list-view {{ (config('settings.default_books_page_view') == 'list')?'active':'' }}"> <span class="fa fa-list-ul"></span> </li>
                </ul>
                <!-- ct-ul-2 --> 
                
              </div>
              <div class="kopa-pull-right"> {{$books->appends(request()->input())->links('vendor.pagination.default')}} 
                <!-- woocommerce-pagination --> 
                
              </div>
            </header>
            <!-- woocommerce-main-header -->
            
            <div class="woocommerce-main-content {{ (config('settings.default_books_page_view') == 'list')?'style-01':'' }}">
              <ul class="ul-mh row">
                @forelse($books as $b)
                @include('front.books.item')
                @empty
                <h3 class="text-center mt-4">{{ __('No results')}}</h3>
                @endforelse
              </ul>
            </div>
            <!-- woocommerce-main-content -->
            
            <footer class="woocommerce-main-footer">
			@if(!empty($category->catgtags))
                                <div class="kopa-tag-box" style="margin-bottom: 30px;border-top: 1px solid #f1f1f1;">
                                    <span><i class="fa fa-tag"></i>{{ __('Tags')}}: </span>
                                    {!!$category->catgtags!!}
                                </div>
                                <!-- kopa-tag-box -->
                                @endif
              <div class="kopa-pull-left">
                <p class="woocommerce-result-count"> {{ __('Showing')}} {{$books->count()}} {{ __('of')}} {{$books->total()}} {{ __('results')}} </p>
              </div>
              <div class="kopa-pull-right"> {{$books->appends(request()->input())->links('vendor.pagination.default')}} 
                <!-- woocommerce-pagination --> 
                
              </div>
            </footer>
            <!-- woocommerce-main-footer --> 
            
          </div>
          <!-- woocommerce-main-primary --> 
          
          @if(config('settings.ad') == 1 && !empty(config('settings.ad2')))
          <div class="row">
            <div class="col-md-12 text-center ad">@php echo html_entity_decode(config('settings.ad2')) @endphp</div>
          </div>
          @endif </div>
        <!-- col-md-9 -->
        
        @include('front.includes.sidebar') 
        
      </div>
      <!-- row --> 
      
    </div>
    <!-- container --> 
    
  </section>
  <!-- kopa-area-15 --> 
  
</div>
<!-- main-content --> 
@stop 
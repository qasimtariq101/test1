@extends('front.layouts.default')

@section('meta')
<meta name="description" content="{{$book->seo_description}}">
<meta name="keywords" content="{{$book->tags}}">
<meta name="author" content="{{config('settings.site_name')}}">
<meta property="og:title" content="@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}" />
<meta property="og:type" content="article" />
<meta property="og:url" content="{{Request::url()}}" />
<meta property="og:image" content="{{$book->thumbnail_f}}" />
<meta property="og:description" content="{{$book->seo_description}}" />
<meta property="og:site_name" content="{{config('settings.site_name')}}" />
<link rel="canonical" href="{{Request::url()}}" />
@stop

@section('after_styles')
<link href="{{url('vendor/semantic-ui/components/icon.min.css')}}" rel="stylesheet">
<link href="{{url('vendor/semantic-ui/components/comment.min.css')}}" rel="stylesheet">
<link href="{{url('vendor/semantic-ui/components/form.min.css')}}" rel="stylesheet">
<link href="{{url('vendor/semantic-ui/components/button.min.css')}}" rel="stylesheet">
<link href="{{ asset('/vendor/laravelLikeComment/css/style.css') }}" rel="stylesheet">
<script type="application/ld+json">
{
  "@context":  "https://schema.org/",
  "@id": "#{{ $book->id }}",
  "@type": "Book",
  "additionalType": "Product",
  "name": "{{ $book->title_f }}",
  "author": "{{ $book->author_name }}",
  "publisher": "{{ config('settings.site_name') }}",
  "description": "{{ $book->seo_description }}",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{ $book->average_rating }}",
    "reviewCount": "{{ $book->ratings_count }}"
  }  
}
</script>
@stop

@section('after_scripts') 
<script src="{{ asset('/vendor/laravelLikeComment/js/script.js') }}"></script> 
<script type="text/javascript">
function CopyToClipboard(text,response_field) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(text).select();
    document.execCommand("copy");
    $temp.remove();
    $('#'+response_field).html("{{ __('Copied')}}");
}

$(document).ready(function($) {
    $('#showComment').trigger('click');

@if(Auth::check())

    $('input[name="rating"]').on('change', function(event) {
        event.preventDefault();
        var rate = $(this).val();
        var pid = '{{$book->id}}';
        $.ajax({
            url: '{{route("books.rate_now")}}',
            type: 'POST',
            data: {pid: pid, rate: rate},
        })
        .done(function(data) {  
            
            if(data != 'error'){
                $('#rate_response').html(data);
            }

        });

    });

@else

    $('input[name="rating"]').on('change', function(event) {
        window.location = '{{route("login")}}';
    });

@endif


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
    window.location.href = '{{route("login")}}';
}); 
</script> 
@endif 
<script type="text/javascript">
    function PrintElem(elem)
    {
        var objFra = document.getElementById(elem);
        objFra.contentWindow.focus();
        objFra.contentWindow.print();
    }
</script> 
@if(!empty($book->password)) 
<script type="text/javascript">
$(document).ready(function($) {
  
  $('#passwordModal').modal('toggle');

  $('#passwordBtn').on('click', function(event) {
    event.preventDefault();
    $("#passwordBtn").prop('disabled','disabled');
    $("#password_response").html(' ');
    $.ajax({
      url: '{{route("book.get")}}',
      type: 'POST',
      data: {slug: '{{$book->slug}}',password: $('#password').val(), _token: '{{ csrf_token() }}'},
    })
    .done(function(data) {
      if(data.status == 'success')
      { 
        var obj = $('#book_view');
        var container = $(obj).parent();
        @if($book->storage == 'embed_code')
        $(obj).html(data.file);
        @else
        $(obj).attr('src', data.file);
        @endif
        var newobj    = $(obj).clone();
        $(obj).remove();
        $(container).append( newobj );
        $("#book_loader").remove();
        $("#passwordModal").modal('toggle');
        $("#unlock_link").remove();
        $('#fs_link').attr('href', data.file);
        $('#fs_link').removeClass('disabled');
      }
      else{
        $("#password_response").html(data.message);
      }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
      $("#passwordBtn").removeAttr('disabled');
    });
    

  });

});
</script> 
@else 
<script type="text/javascript">
$(document).ready(function($) {
  
    $.ajax({
      url: '{{route("book.get")}}',
      type: 'POST',
      data: {slug: '{{$book->slug}}',password: $('#password').val(), _token: '{{ csrf_token() }}'},
    })
    .done(function(data) {
      if(data.status == 'success')
      { 
        var obj = $('#book_view');
        var container = $(obj).parent();
        @if($book->storage == 'embed_code')
        $(obj).html(data.file);
        @else
        $(obj).attr('src', data.file);
        @endif

        var newobj    = $(obj).clone();
        $(obj).remove();
        $(container).append( newobj ); 
        $("#book_loader").remove();
        $('#fs_link').attr('href', data.file);         
        $('#fs_link').removeClass('disabled');       
      }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
      $("#passwordBtn").removeAttr('disabled');
    });
    

});
</script> 
@endif
@stop

@section('body_start')
@if(config('settings.facebook_comments') == 1)
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v9.0&appId={{ config('settings.facebook_app_id') }}&autoLogAppEvents=1" nonce="34H3q5xx"></script>
@endif
@stop

@section('content')
<div id="main-content">
  <section class="kopa-area kopa-area-15">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="breadcrumb-content" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" class="active" href="{{url('/')}}">
                            <span itemprop="name">{{ __('Home')}}</span>
                        </a>
                        <meta itemprop="position" content="1">
                    </span>
                    <span>&nbsp;&nbsp;/&nbsp;&nbsp;</span>
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" class="active" href="{{route('books.index')}}">
                            <span itemprop="name">{{ __('Books')}}</span>
                        </a>
                        <meta itemprop="position" content="2">
                    </span>
                    @if(!empty($book->category))
                    <span>&nbsp;&nbsp; / &nbsp;&nbsp;</span>
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" class="active" href="{{ $book->category->url }}">
                            <span itemprop="name">{{ $book->category->name }}</span>
                        </a>
                        <meta itemprop="position" content="3">
                    </span>
                    @endif
                    <span>&nbsp;&nbsp;/&nbsp;&nbsp;</span>
                    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" class="current-page">
                            <span itemprop="name">{{$page_title}}</span>
                        </a>
                        <meta itemprop="position" content="4">
                    </span>
                </div>
            </div>
        </div>      
      <div class="row">
        <div class="main-col style-01 @if(config('settings.book_page_layout') == 1) col-md-9 @else col-md-12 @endif"> @if(config('settings.ad') == 1 && !empty(config('settings.ad1')))
          <div class="row">
            <div class="col-md-12 text-center ad">@php echo html_entity_decode(config('settings.ad1')) @endphp</div>
          </div>
          @endif 
          
          @include('front.includes.messages')
          <div itemscope="" itemtype="http://schema.org/Product" class="product">
            <div class="woocommerce-area-1">
              <div class="media mt-4">
                <div class="media-left"> <a href="@if(isset($book->user)){{$book->user->url}}@else{{'#'}}@endif"> <img class="media-object" src="@if(isset($book->user)){{$book->user->avatar}}@else{{url('img/default-avatar.png')}}@endif" alt="{{$book->title_f}}"> </a> </div>
                <div class="media-body">
                    <div class="media-heading bookshowhead">
                        <i class="fa {{book_icon($book->file)}} ct-alert-1 style-06" style="float: right;"></i>
                        @if(!empty($book->password))<i class="fa fa-lock ct-alert-1 style-03 small"></i>@endif
                        <h1 itemprop="name" class="product_title entry-title" style="margin: 0px;padding-left: 10px;">{{$book->title_f}}</h1>
                        <div class="kopa-pull-right">
                            <a class="add_to_favorite" data-pid="{{$book->id}}" data-action="add" title="{{ __('Add to favorite')}}">
                                <i class="fa @if(in_array($book->id,$favorites)) fa-heart @else fa-heart-o @endif pink"></i>
                            </a>
                            @if(Auth::check())
                                @if($book->user_id == Auth::user()->id)
                                    <a href="{{route('book.edit',[$book->slug])}}" class="badge badge-info mr-2">
                                        <i class="fa fa-edit"></i> {{ __('Edit')}}
                                    </a>
                                    <a href="{{route('book.delete',[$book->slug])}}" class="badge badge-danger">
                                        <i class="fa fa-trash"></i> {{ __('Delete')}}
                                    </a>
                                @else
                                    @if(Auth::user()->role == 1)
                                        <a href="{{url('admin/books/'.$book->id.'/edit')}}" class="badge badge-info mr-2">
                                            <i class="fa fa-edit"></i> {{ __('Edit')}}
                                        </a>
                                        <a href="{{url('admin/books/'.$book->id.'/delete')}}" class="badge badge-danger">
                                            <i class="fa fa-trash"></i> {{ __('Delete')}}
                                        </a>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>

                  <p class="text-muted small"> @if(isset($book->category))<a href="{{$book->category->url}}"><i class="fa fa-folder-o"></i> {{$book->category->name}}</a>@endif 

                    <i class="fa fa-user"></i> 
                    @if(!empty($book->author_name)) <a href="{{ route('books.index',['author' => $book->author_name]) }}">{{ $book->author_name }}</a>
                    @elseif(isset($book->user)) <a href="{{$book->user->url}}"> {{ (!empty($book->author_name))?$book->author_name:$book->user->name}} </a> 
                    @else {{ (!empty($book->author_name)) ? $book->author_name:__('Guest')}}  @endif 


                    <i class="fa fa-eye"></i> {{$book->views_f}} <i class="fa fa-calendar"> {{$book->created_at->format('jS M, Y')}}</i> @if($book->status == 2) <span class="badge badge-warning">{{ __('Unlisted')}}</span> @elseif($book->status == 3) <span class="badge badge-danger">{{ __('Private')}}</span> @endif </p>
                  @if(config('settings.allow_ratings') == 1)
                  <div class="woocommerce-product-rating">
                    <div class="star-rating" title="{{ __('Average Rating')}}"> <span style="width: {{($book->average_rating * 100) / 5}}%;"> </span> </div> ({{ number_format($book->ratings_count) }})
                  <div class="book-fb-like-button" style="float:right;">
                  <div class="fb-like" data-href="https://facebook.com/taleem360" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="false"></div>
                  </div>
                  </div>
                  @endif
                </div>
              </div>
              @if(Auth::check()) @if($book->user_id == Auth::user()->id)
              <p class="text-muted text-center"><small>{{ __('This is one of your book')}}</small></p>
              @endif @endif
              
              @if(!empty($book->password))
              <div class="text-center" id="unlock_link"><a class="badge badge-warning" data-toggle="modal" data-target="#passwordModal"><i class="fa fa-lock"></i> {{ __('Unlock')}}</a></div>
              @endif
              <div class="pull-left mb-2" style="margin-left: 20px;"> @if(!empty($book->type))<span class="badge badge-light text-uppercase">{{ $book->type }}</span>@endif @if(!empty($book->size))<small>{{$book->size}}</small>@endif </div>
              <div class="pull-right mb-2">
                <!--<a href="https://play.google.com/store/apps/details?id=com.epm.taleem360" target="_blank" class="badge badge-success"><i class="fa fa-android"></i> Android App</a>-->
                @if(config('settings.feature_share') == 1)<a class="badge badge-warning" data-toggle="modal" data-target="#shareModal">{{ __('share')}}</a> @endif 
                @if(config('settings.feature_download') == 1 && empty($book->password) && in_array($book->storage, ['uploads','ftp','google_drive_link']))<a @if(config('settings.public_download') == 1 || Auth::check()) href="{{route('download',[$book->slug])}}" @else href="{{route('login')}}" @endif class="badge badge-primary"><i class="fa fa-download"></i> {{ __('download')}} ({{$book->downloads_f}})</a> @endif
                @if(config('settings.feature_embed') == 1)<a class="badge badge-success" data-toggle="modal" data-target="#embedModal">{{ __('Iframe / Embed')}}</a> @endif

                @if(config('settings.feature_full_screen') == 1 && in_array($book->storage, ['uploads','ftp','s3']))<a id="fs_link" class="badge badge-info disabled" href="" target="_blank">{{ __('full screen')}}</a> @endif                
                @if(config('settings.feature_report') == 1)<a class="badge badge-danger" @if(\Auth::check()) data-toggle="modal" data-target="#reportModal" @else href="{{route('login')}}" @endif>{{ __('report')}}</a> @endif
                @if(config('settings.feature_print') == 1 && empty($book->password) && in_array($book->type, ['pdf','txt']))<a class="badge badge-info" onclick="PrintElem('book_view')">{{ __('print')}}</a> @endif </div>
              <div class="summary">
                <h4 class="text-center" id="book_loader"><i class="fa fa-spinner fa-spin"></i> {{ __('Loading please wait')}}...</h4>
                  @if($book->storage == 'embed_code')
                    <div id="book_view"></div>
                  @else
                  <iframe id="book_view" style="width:100%;height:700px;"></iframe>       
                  @endif
              </div>
              @if(!empty($book->overview))
              <div class="summary">
                <h2 class="product_title entry-title"> {{ __('Overview')}} </h2>
                <div itemprop="description">
                  <p>{!!$book->overview!!}</p>
                </div>
              </div>
              <!-- summary --> 
              @endif

            </div>  
            @if(config('settings.feature_download') == 1 && empty($book->password) && in_array($book->storage, ['uploads','ftp','google_drive_link']))<a @if(config('settings.public_download') == 1 || Auth::check()) href="{{route('download',[$book->slug])}}" @else href="{{route('login')}}" @endif class="badge badge-primary" style="width:100%;padding:20px;font-size:16px;background:#4192ff;"><i class="fa fa-download"></i> {{ __('download')}} ({{$book->downloads_f}})</a>  @endif
			
			<!--Alternative Button Start-->
			@if(!empty($book->app_download_link))
				<a download="{{$book->app_download_link}}" href="{{$book->app_download_link}}"  class="badge badge-warning" style="width:100%;padding:20px;font-size:16px;margin: 1px 0px 1px 0px;"><i class="fa fa-download"></i> {{ __('download')}} <span style="font-size:12px;">({{('If Blue Button is not working')}})<span></a>
			@endif
			<!--Alternative Button End-->
			
			<!--App Button Start-->
			@if(config('settings.feature_download') == 1 && empty($book->password) && in_array($book->storage, ['uploads','ftp','google_drive_link']))
				<a href="https://www.taleem360.com/t-ads/click.php?id=taleem360app-7" target="_blank" class="badge badge-success" style="width:100%;padding:10px;font-size:16px;margin: 1px 0px 1px 0px;"><i class="fa fa-android"></i> {{ __('Download Taleem360 Android App')}}</a>
			@endif
			<!--App Button End-->
            
                                @if(!empty($book->tags))
                                <div class="kopa-tag-box">
                                    <span><i class="fa fa-tag"></i>{{ __('Tags')}}: </span>
                                    {!!$book->tags_f!!}
                                </div>
                                <!-- kopa-tag-box -->
                                @endif	
								
			<!-- Playstore App -->
			<img src="https://www.taleem360.com/img/ads/taleem360appad2.jpg" alt="Taleem 360 Android App" style="width:100%;margin-top: 30px;"/>
            <!--<a href="https://www.taleem360.com/t-ads/click.php?id=taleem360app-2" target="_blank" class="badge badge-primary" style="width:100%;padding:5px;font-size:16px;background:#3e9f2a;margin: 1px 0px 1px 0px;"><i class="fa fa-android"></i> Download Taleem360 Android App (12MB)</a>-->
            <!-- Playstore App -->

<p style="background: #fff;padding: 20px;font-size: 12px;color: #a86f53;border: 1px solid #f1f1f1;text-align: justify;margin: 30px 0px;"><i class="fa fa-copyright" aria-hidden="true"></i> Copyright Policy: This website has been created only for educational purpose. The data has been posted by general public as well. Our intention is not to infringe any copyright policy. If you are the copyright holder of any of the content uploaded on this site, and don't want it to be here. Instead of taking any other action, Please <a href="https://taleem360.com/contact">contact us</a>. Your complaint would be honored, and the highlighted content will be removed instantly. <br/> Here we would say "<a href="https://taleem360.com/pages/special-thanks">Special Thanks</a>" to all those copyright owners who allowed us to share their content and did not ask to take down their content.</p>

                                @if(!empty($book->user))
                                <div class="single-post-author">
                                    <div class="author-avatar kopa-pull-left">
                                        <a href="{{$book->user->url}}">
                                            <img src="{{$book->user->avatar}}" alt="{{$book->user->name}}" style="height: 80px;">
                                        </a>
                                    </div>
                                    <div class="author-content-wrap">
                                        <header class="clearfix">
                                            <div class="kopa-pull-right">
                                                <div class="kopa-social-links style-03">
                                                    <ul class="clearfix">
                                                      @if(!empty($book->user->fb))
                                                      <li><a href="{{$book->user->fb}}" class="fa fa-facebook"></a></li>
                                                      @endif
                                                      @if(!empty($book->user->tw))
                                                      <li><a href="{{$book->user->tw}}" class="fa fa-twitter"></a></li>
                                                      @endif
                                                      @if(!empty($book->user->gp))
                                                      <li><a href="{{$book->user->gp}}" class="fa fa-google-plus"></a></li>
                                                      @endif
                                                    </ul>
                                                </div>
                                            </div>  
                                            <div class="clearfix"></div>
                                            <div class="kopa-pull-left">
                                                <h5>
                                                    <a href="{{$book->user->url}}">{{$book->user->name}}</a>
                                                    <a>@if($book->user->role == 1){{ __('Administrator')}}@else {{ __('Registered Member')}} @endif</a>
                                                </h5>
                                            </div>
                                        </header>
                                        <div class="author-content">
                                            <p>@if(empty($book->user->about)){{ (!empty($book->user->created_at)) ? __('Joined') .' '. $book->user->created_ago : '' }}@else{{$book->user->about}}@endif</p>
                                        </div>                          
                                    </div>
                                </div>
                                <!-- author -->
                                @endif
            @if(config('settings.custom_comments') == 1 || config('settings.disqus') == 1 || config('settings.facebook_comments') == 1 || config('settings.allow_ratings') == 1)
            <div class="woocommerce-tabs wc-tabs-wrapper">
              <ul class="tabs wc-tabs">
                @if(config('settings.custom_comments') == 1 || config('settings.disqus') == 1 || config('settings.facebook_comments') == 1)
                <li class="description_tab active"> <a href="#tab-description">{{ __('Comments')}}</a> </li>
                @endif

                @if(config('settings.allow_ratings') == 1)
                <li class="reviews_tab @if(config('settings.custom_comments') != 1 && config('settings.disqus') != 1 && config('settings.facebook_comments') != 1) active @endif"> <a href="#tab-reviews">{{ __('Rate Now')}}</a> </li>
                @endif
              </ul>
              @if(config('settings.custom_comments') == 1 || config('settings.disqus') == 1 || config('settings.facebook_comments') == 1)
              <div class="panel entry-content wc-tab active" id="tab-description"> 
              @if(config('settings.custom_comments') == 1)
                @include('laravelLikeComment::comment', ['comment_item_id' => $book->id]) 
              @endif

              @if(config('settings.disqus') == 1)
                @php echo html_entity_decode(config('settings.disqus_code')) @endphp
              @endif              

              @if(config('settings.facebook_comments') == 1)
                <div class="fb-comments" data-href="{{ $book->url }}" data-numposts="5" data-width="100%"></div>
              @endif


              </div>
              @endif
              @if(config('settings.allow_ratings') == 1)
              <div class="panel entry-content wc-tab  @if(config('settings.custom_comments') != 1 && config('settings.disqus') != 1 && config('settings.facebook_comments') != 1) active @endif" id="tab-reviews">
                <div>
                  <fieldset class="rating">
                    <input type="radio" id="star5" name="rating" value="5" />
                    <label class = "full" for="star5" title="{{ __('Awesome')}} - 5 {{ __('stars')}}"></label>
                    <input type="radio" id="star4half" name="rating" value="4.5" />
                    <label class="half" for="star4half" title="{{ __('Pretty good')}} - 4.5 {{ __('stars')}}"></label>
                    <input type="radio" id="star4" name="rating" value="4" />
                    <label class = "full" for="star4" title="{{ __('Pretty good')}} - 4 {{ __('stars')}}"></label>
                    <input type="radio" id="star3half" name="rating" value="3.5" />
                    <label class="half" for="star3half" title="{{ __('Meh')}} - 3.5 {{ __('stars')}}"></label>
                    <input type="radio" id="star3" name="rating" value="3" />
                    <label class = "full" for="star3" title="{{ __('Meh')}} - 3 {{ __('stars')}}"></label>
                    <input type="radio" id="star2half" name="rating" value="2.5" />
                    <label class="half" for="star2half" title="{{ __('Kinda bad')}} - 2.5 {{ __('stars')}}"></label>
                    <input type="radio" id="star2" name="rating" value="2" />
                    <label class = "full" for="star2" title="{{ __('Kinda bad')}} - 2 {{ __('stars')}}"></label>
                    <input type="radio" id="star1half" name="rating" value="1.5" />
                    <label class="half" for="star1half" title="{{ __('Meh')}} - 1.5 {{ __('stars')}}"></label>
                    <input type="radio" id="star1" name="rating" value="1" />
                    <label class = "full" for="star1" title="{{ __('Sucks big time')}} - 1 {{ __('star')}}"></label>
                    <input type="radio" id="starhalf" name="rating" value="0.5" />
                    <label class="half" for="starhalf" title="{{ __('Sucks big time')}} - 0.5 {{ __('stars')}}"></label>
                  </fieldset>
                </div>
                <div class="clearfix"></div>
                <div id="rate_response"></div>
              </div>
              @endif

            </div>
            @endif
            
            @if($related_books->count() > 0)
            <div class="related products">
              <div class="widget reading-module-product-list-1">
                <h3 class="widget-title style-07"><span>{{ __('Related')}}</span> {{ __('Books')}}</h3>
                <div class="widget-content">
                  <div class="row">
                    <div class="owl-carousel owl-carousel-3 owl-btn-02"> 
                      @forelse($related_books as $b)
                        @include('front.books.item_c')
                      @empty
                      <h1 class="text-center">{{ __('No results')}}</h1>
                      @endforelse </div>
                    <!-- owl-carousel-3 --> 
                    
                  </div>
                  <!-- row --> 
                  
                </div>
              </div>
              <!-- widget -->               
            </div>
            @endif
          </div>
          @if(config('settings.ad') == 1 && !empty(config('settings.ad2')))
          <div class="row">
            <div class="col-md-12 text-center ad">@php echo html_entity_decode(config('settings.ad2')) @endphp</div>
          </div>
          @endif </div>
        <!-- col-md-9 --> 
        
        @if(config('settings.book_page_layout') == 1)
          @include('front.includes.sidebar')
        @endif 

      </div>
      <!-- row --> 
      
    </div>
    <!-- container --> 
    
  </section>
  <!-- kopa-area-15 --> 
  
</div>
<!-- main-content --> 

@if(config('settings.feature_share') == 1) 
<!-- The Modal -->
<div class="modal" id="shareModal">
  <div class="modal-dialog">
    <div class="modal-content"> 
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title pull-left">{{ __('Share')}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body text-center">
    @if(config('settings.qr_code_share') == 1)
    <div class="mb-2"><img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{urlencode($book->url)}}"  alt="{{$book->title_f}}"></div>
    @endif
    <a href="#" onclick="MyWindow=window.open('https://www.facebook.com/dialog/share?app_id={{config('settings.facebook_app_id')}}&amp;display=popup&amp;href={{$book->url}}','Facebook share','width=600,height=300'); return false;" class="btn btn-primary btn-sm waves-effect waves-light"><i class="fa fa-facebook"></i></a>
    <a href="#" onclick="MyWindow=window.open('https://twitter.com/share?url={{$book->url}}','Twitt this','width=600,height=300'); return false;" class="btn btn-info btn-sm waves-effect waves-light"><i class="fa fa-twitter"></i></a>
    <a href="#" onclick="MyWindow=window.open('https://pinterest.com/pin/create/button/?url={{$book->url}}&media={{$book->cover}}&description={{$book->title_f}} - Author: {{ $book->author_name }} - Category: {{$book->category->name}} - Are you looking for {{$book->title_f}}? Now you can download {{$book->title_f}} from taleem360.com or Use Taleem360 android app from google playstore.','Pinterest share','width=600,height=300'); return false;" class="btn btn-danger btn-sm waves-effect waves-light"><i class="fa fa-pinterest"></i></a>

    <a href="whatsapp://send?text={{$book->url}}" data-action="share/whatsapp/share" class="btn btn-success btn-sm waves-effect waves-light"><i class="fa fa-whatsapp"></i></a>
    @if(config('settings.feature_copy') == 1)
    <div>
        <small class="text-muted">{{ __('To share this ebook, please copy this url and send to your friends.')}}</small>
        <p class="input-block">
            <div class="input-group-prepend">
                <button class="btn btn-md btn-blue-grey m-0 px-3" type="button" onclick="CopyToClipboard('{{$book->url}}','share_response')">{{ __('Copy')}}</button>
            </div>
            <input type="text" class="form-control" value="{{$book->url}}" disabled>
        </p>
        <div id="share_response" class="text-success"></div>
    </div>
    @endif
</div>

      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button class="btn btn-danger btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
      </div>
    </div>
  </div>
</div>
@endif


@if(!empty($book->password)) 
<!-- The Modal -->
<div class="modal" id="passwordModal">
  <div class="modal-dialog">
    <div class="modal-content"> 
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title pull-left">{{ __('Password')}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body text-center">
        <div class="form-group"> <small class="text-muted">{{ __('To unlock this ebook, please enter password')}}</small>
          <input type="password" class="form-control" id="password" placeholder="{{ __('Password')}}">
        </div>
        <div id="password_response"></div>
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button class="btn btn-sm btn-warning" type="button" id="passwordBtn">{{ __('Unlock')}}</button>
        <button class="btn btn-danger btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
      </div>
    </div>
  </div>
</div>
@endif 

<!-- The Modal -->
<div class="modal" id="embedModal">
  <div class="modal-dialog">
    <div class="modal-content"> 
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title pull-left">{{ __('Embed Code')}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
        <textarea class="form-control" id="embed_code"><iframe src="{{route('embed',[$book->slug])}}" style="border:none;width:100%;min-height:700px;"></iframe>
</textarea>
        <span id="embed_response" class="text-success"></span> </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button class="btn btn-success btn-sm" onclick="CopyToClipboard(document.getElementById('embed_code').value,'embed_response');">{{ __('Copy')}}</button>
        <button class="btn btn-danger btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
      </div>
    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal" id="reportModal">
  <div class="modal-dialog">
    <div class="modal-content"> 
      
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title pull-left">{{ __('Report Issue')}}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form class="eco_form" method="post" action="{{route('book.report')}}">
        <!-- Modal body -->
        <div class="modal-body"> @csrf
          <input type="hidden" name="id" value="{{$book->id}}">
          <label>{{ __('Reason')}}</label>
          <textarea class="form-control" name="reason" placeholder="{{ __('Write your reason')}}.."></textarea>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning btn-sm">{{ __('Report')}}</button>
          <button class="btn btn-danger btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
        </div>
      </form>
    </div>
  </div>
</div>
@stop 
<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
<meta name="viewport" content="width=device-width, initial-scale=0.75, maximum-scale=1.0, user-scalable=yes">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="csrf-token" content="{{csrf_token()}}">
@yield('meta')
@if(Route::currentRouteName() == 'home')
<title>{{config('settings.site_name')}}@if(isset($page_title)){{' - '.$page_title}}@endif</title>
@else
<title>@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}</title>
@endif
<link rel="shortcut icon" href="{{config('settings.site_favicon')}}" />
@yield('before_styles')
<link rel="stylesheet" href="{{url('css/bootstrap.min.css')}}" media="all" />
@if($selected_locale->site_layout == 'rtl')
<link rel="stylesheet" href="{{url('css/bootstrap-rtl.min.css')}}" media="all" />
@endif
<link rel="stylesheet" href="{{url('css/font-awesome.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/themify-icons.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/superfish.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/megafish.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/jquery.navgoco.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/jquery.mCustomScrollbar.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/owl.carousel.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/owl.theme.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/animate.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/jquery-ui.css')}}" media="all" />
<link rel="stylesheet" href="{{url('css/woocommerce.css')}}" media="all" />
<link rel="stylesheet" href="{{url('vendor/font-awesome-4.7.0/css/font-awesome.min.css')}}" />
<link rel="stylesheet" href="{{url('css/style.css?v=1.1')}}" media="all" >
<link rel="stylesheet" href="{{url('css/app.min.css?v=1')}}" media="all" >
@if($selected_locale->site_layout == 'rtl')
<link rel="stylesheet" href="{{url('css/app-rtl.min.css')}}" media="all" >
@endif
<script src="{{url('js/modernizr.custom.js')}}"></script>
<link rel="apple-touch-icon" href="{{url('img/icons/apple-touch-icon.png')}}">
<link rel="apple-touch-icon" sizes="72x72" href="{{url('img/icons/apple-touch-icon-72x72.png')}}">
<link rel="apple-touch-icon" sizes="114x114" href="{{url('img/icons/apple-touch-icon-114x114.png')}}">
@yield('after_styles')
</head>

<body class="woocommerce woocommerce-page">
<div class="main-container">
  <div class="main-col style-01 col-md-12 col-sm-12 col-xs-12">
    <div itemscope="" itemtype="https://schema.org/Product" class="product">
      <div class="woocommerce-area-1" style="border:1px solid #f1f1f1;">
        <div class="media">
          <div class="media-left"> <a @if(!empty($book->user)) href="{{$book->user->url}}" target="_blank" @else href="#" @endif> <img class="media-object" src="@if(!empty($book->user)){{$book->user->avatar}}@else{{url('img/default-avatar.png')}}@endif" alt="{{$book->title_f}}"> </a> </div>
          <div class="media-body">
            <h4 class="media-heading"> <i class="fa {{book_icon($book->file)}} ct-alert-1 style-06 small"></i> @if(!empty($book->password))<i class="fa fa-lock ct-alert-1 style-03 small"></i>@endif <a href="{{$book->url}}" target="_blank">{{$book->title_f}}</a> </h4>
            <p class="text-muted small"> @if(isset($book->category))<a href="{{$book->category->url}}"><i class="fa fa-folder-o"></i> {{$book->category->name}}</a>@endif <i class="fa fa-user"></i> @if(isset($book->user)) <a href="{{$book->user->url}}"> {{ (!empty($book->author_name))?$book->author_name:$book->user->name}} </a> @else {{ (!empty($book->author_name))?$book->author_name:__('Guest')}}  @endif <i class="fa fa-eye" title="{{ __('Views')}}"></i> {{$book->views_f}} @if($book->status == 2) <span class="badge badge-warning">{{ __('Unlisted')}}</span> @elseif($book->status == 3) <span class="badge badge-danger">{{ __('Private')}}</span> @endif </p>
            <div class="woocommerce-product-rating" itemprop="aggregateRating" itemscope="" itemtype="https://schema.org/AggregateRating">
              <div class="star-rating" title="{{ __('Average Rating')}}"> <span style="width: {{($book->average_rating * 100) / 5}}%;"> </span> </div>
            </div>
          </div>
        </div>
        @if(!empty($book->password))
        <div class="text-center" id="unlock_link"><a class="badge badge-warning" data-toggle="modal" data-target="#passwordModal"><i class="fa fa-lock"></i> {{ __('Unlock')}}</a></div>
        @endif
        <div class="pull-left mb-2" style="margin-left: 20px;"> <span class="badge badge-light text-uppercase">{{$book->type}}</span> <small>{{$book->size}}</small> </div>
        <div class="pull-right mb-2"> @if(config('settings.feature_download') == 1 && empty($book->password))<a href="{{route('download',[$book->slug])}}" class="badge badge-info"><i class="fa fa-download"></i> {{ __('download')}}</a> @endif
          @if(config('settings.feature_print') == 1 && empty($book->password) && in_array($book->type, ['pdf','txt']))<a class="badge badge-info" onclick="PrintElem('book_view')">{{ __('print')}}</a> @endif </div>
        <div class="summary">
          <h4 class="text-center" id="book_loader"><i class="fa fa-spinner fa-spin"></i> {{ __('Loading please wait')}}...</h4>
           @if($book->storage != 'embed_code')
              <iframe id="book_view" style="width:100%;height:500px;"></iframe>
           @else
          <iframe id="book_view" style="width:100%;height:500px;"></iframe>   
          @endif
        </div>
        <div class="text-center">{{ __('eBook Hosted With')}} <i class="fa fa-heart text-primary"></i> {{ __('By')}} <a href="{{url('/')}}" target="_blank">{{config('settings.site_name')}}</a></div>
      </div>
    </div>
  </div>
  <!-- col-md-9 --> 
  
</div>
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



@yield('before_scripts') 
<script src="{{url('js/jquery-1.12.4.min.js')}}"></script> 
<script src="{{url('js/bootstrap.min.js')}}"></script> 
<script src="{{url('js/superfish.min.js')}}"></script> 
<script src="{{url('js/jquery.navgoco.min.js')}}"></script> 
<script src="{{url('js/jquery.mCustomScrollbar.concat.min.js')}}"></script> 
<script src="{{url('js/jquery.mousewheel.min.js')}}"></script> 
<script src="{{url('js/imagesloaded.pkgd.min.js')}}"></script> 
<script src="{{url('js/masonry.pkgd.min.js')}}"></script> 
<script src="{{url('js/owl.carousel.min.js')}}"></script> 
<script src="{{url('js/jquery.sliderPro.min.js')}}"></script> 
<script src="{{url('js/jquery.validate.min.js')}}"></script> 
<script src="{{url('js/jquery-ui.min.js')}}"></script> 
<script src="{{url('js/jquery.matchHeight-min.js')}}"></script> 
<script src="{{url('js/jquery.wow.js')}}"></script> 
<script src="{{url('js/custom.js?v=1')}}" charset="utf-8"></script> 
@yield('after_scripts')
@php echo html_entity_decode(config('settings.analytics_code')) @endphp 
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
          var fileId = data.file.replace('https://drive.google.com/file/d/', '').replace('/preview', '');
          var fileUrl = 'https://drive.google.com/u/0/uc?id=' + fileId + '&export=preview';
          $(obj).attr('src', fileUrl);
          @else
          $(obj).attr('src', data.file);
          @endif

          var newobj    = $(obj).clone();
          $(obj).remove();
          $(container).append( newobj );
          $("#book_loader").remove();
          $("#passwordModal").modal('toggle');
          $("#unlock_link").remove();
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
        var fileId = data.file.replace('https://drive.google.com/file/d/', '').replace('/preview', '');
        var fileUrl = 'https://drive.google.com/u/0/uc?id=' + fileId + '&export=preview';
        $(obj).attr('src', fileUrl);
        @else
        $(obj).attr('src', data.file);
        @endif

        var newobj    = $(obj).clone();
        $(obj).remove();
        $(container).append( newobj );
        $("#book_loader").remove();
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

</body>
</html>
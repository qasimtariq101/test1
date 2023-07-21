@extends('front.layouts.default')

@section('meta')
<meta name="description" content="Download all classes and all subjects text books from One Class to Intermediate Level in PDF by Balochistan Text Book Board (BTBB), Quetta.">
<meta name="keywords" content="Balochsitan Textbooks PDF, BTBB Text Books PDF, PDF Text Books, FSc Text Books, Matric textbooks, Baluchistan Text Books, Single National Curriculum, SNC Books PDF, BTBB eBooks, Balochistan Board Books, Primary Textbooks, Secondary Textbooks, Taleem360">
<meta name="author" content="{{config('settings.site_name')}}">
<meta property="og:title" content="@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}" />
<meta property="og:type" content="article" />
<meta property="og:url" content="{{Request::url()}}" />
<meta property="og:image" content="{{url(config('settings.site_image'))}}" />
<meta property="og:site_name" content="{{config('settings.site_name')}}" />
<link rel="canonical" href="{{Request::url()}}" />
{!! html_entity_decode(config('settings.header_code')) !!}
@yield('after_styles')


@stop

@section('content')
<div id="main-content">
  <section class="kopa-area kopa-area-15">
    <div class="container">
        <div class="row">
        <div class="col-md-12" style="margin-bottom: 10px;">

          @include('front.includes.breadcrumb')

        </div>
      </div>

      <div class="row">
        <div class="main-col style-01 col-md-9 col-sm-9 col-xs-9"> @if(config('settings.ad') == 1 && !empty(config('settings.ad1')))
          <div class="row">
            <div class="col-md-12 text-center ad">@php echo html_entity_decode(config('settings.ad1')) @endphp</div>
          </div>
          @endif
          @include('front.includes.messages')

<!--HTML PAGE EDIT START-->
<div class="woocommerce-main-primary">
<h1 style="margin: 20px auto;">Balochistan Text Books in PDF</h1>
<p>Download Balochistan Boards Text Books of all classes (From Class One to Intermediate) and all subjects in PDF format from taleem360. All Balochistan Text Book Board (BTBB), Quetta Textbooks of Class 1, Class 2, Class 3, Class 4, Class 5, Class 6, Class 7, Class 8, Class 9, Class 10, Class 11 & Class 12 are available here. <br> Here is the categories list of your desired content, please choose from below:</p>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/class-1-textbooks-btbb"><img src="https://www.taleem360.com/img/navcons/classeswebp/1.webp" alt="balochistan text books class 1" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/class-1-textbooks-btbb">One Class Balochistan Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 1 all subjects Balochistan text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/class-1-textbooks-btbb"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/class-2-textbooks-btbb"><img src="https://www.taleem360.com/img/navcons/classeswebp/2.webp" alt="balochistan text books class 2" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/class-2-textbooks-btbb">Two Class Balochistan Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 2 all subjects Balochistan text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/class-2-textbooks-btbb"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/class-3-textbooks-btbb"><img src="https://www.taleem360.com/img/navcons/classeswebp/3.webp" alt="balochistan text books class 3" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/class-3-textbooks-btbb">Three Class Balochistan Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 3 all subjects Balochistan text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/class-3-textbooks-btbb"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/4th-books-balochistan"><img src="https://www.taleem360.com/img/navcons/classeswebp/4.webp" alt="balochistan text books class 4" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/4th-books-balochistan">4th Class Balochistan Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 4 all subjects Balochistan text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/4th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/5th-books-balochistan"><img src="https://www.taleem360.com/img/navcons/classeswebp/5.webp" alt="balochistan text books class 5" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/5th-books-balochistan">5th Class Balochistan Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 5 all subjects Balochistan text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/5th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/6th-books-balochistan"><img src="https://www.taleem360.com/img/navcons/classeswebp/6.webp" alt="balochistan text books class 6" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/6th-books-balochistan">6th Class Balochistan Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 6 all subjects Balochistan text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/6th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/7th-books-balochistan"><img src="https://www.taleem360.com/img/navcons/classeswebp/7.webp" alt="balochistan text books class 7" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/7th-books-balochistan">7th Class Balochistan Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 7 all subjects Balochistan text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/7th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/8th-books-balochistan"><img src="https://www.taleem360.com/img/navcons/classeswebp/8.webp" alt="balochistan text books class 8" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/8th-books-balochistan">8th Class Balochistan Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 8 all subjects Balochistan text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/8th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/9th-books-balochistan"><img src="https://www.taleem360.com/img/navcons/classeswebp/9.webp" alt="balochistan text books class 9" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/9th-books-balochistan">9th Class Balochistan Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 9 all subjects Balochistan text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/9th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/10th-books-balochistan"><img src="https://www.taleem360.com/img/navcons/classeswebp/10.webp" alt="balochistan text books class 10" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/10th-books-balochistan">10th Class Balochistan Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 10 all subjects Balochistan text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/10th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/11th-books-balochistan"><img src="https://www.taleem360.com/img/navcons/classeswebp/11.webp" alt="balochistan text books class 11" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/11th-books-balochistan">11th Class Balochistan Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 11 all subjects Balochistan text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/11th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/12th-books-balochistan"><img src="https://www.taleem360.com/img/navcons/classeswebp/12.webp" alt="balochistan text books class 12" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/12th-books-balochistan">12th Class Balochistan Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 12 all subjects Balochistan text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/12th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>
</div>
<!--HTML PAGE EDIT END-->
          
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
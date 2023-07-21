@extends('front.layouts.default')

@section('meta')
<meta name="description" content="Download all classes and all subjects text books from KG to HSSC Level in PDF by Punjab Curriculum and Textbook Board (PCTB), Lahore.">
<meta name="keywords" content="Punjab Textbooks PDF, PCTB Text Books PDF, PDF Text Books, FSc Text Books, Matric textbooks, SNC Text Books, Single National Curriculum Books PDF, SNC Books PDF, PCTB eBooks, Punjab Boards Books, Primary Textbooks, Secondary Textbooks, Taleem360">
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
<h1 style="margin: 20px auto;">Punjab Text Books in PDF</h1>
<p>Download Punjab Boards Text Books of all classes (From Nursery to Intermediate) and all subjects in PDF format from taleem360. All Punjab Curriculum &amp; Text Book Board (PCTB), Lahore Textbooks of Class 1, Class 2, Class 3, Class 4, Class 5, Class 6, Class 7, Class 8, Class 9, Class 10, Class 11 & Class 12 are available here. <br> Here is the categories list of your desired content, please choose from below:</p>
<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/kachi-class-books"><img src="https://www.taleem360.com/img/navcons/classeswebp/k.webp" alt="punjab text books class nursery" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/kachi-class-books">Kachi Class Punjab Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class Nursery (KG) all subjects Punjab text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/kachi-class-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/class-one-books"><img src="https://www.taleem360.com/img/navcons/classeswebp/1.webp" alt="punjab text books class 1" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/class-one-books">One Class Punjab Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 1 all subjects Punjab text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/class-one-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/two-class-books"><img src="https://www.taleem360.com/img/navcons/classeswebp/2.webp" alt="punjab text books class 2" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/two-class-books">Two Class Punjab Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 2 all subjects Punjab text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/two-class-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/class-three-text-books"><img src="https://www.taleem360.com/img/navcons/classeswebp/3.webp" alt="punjab text books class 3" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/class-three-text-books">Three Class Punjab Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 3 all subjects Punjab text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/class-three-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/4th-text-books"><img src="https://www.taleem360.com/img/navcons/classeswebp/4.webp" alt="punjab text books class 4" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/4th-text-books">4th Class Punjab Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 4 all subjects Punjab text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/4th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/5th-text-books"><img src="https://www.taleem360.com/img/navcons/classeswebp/5.webp" alt="punjab text books class 5" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/5th-text-books">5th Class Punjab Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 5 all subjects Punjab text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/5th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/6th-text-books"><img src="https://www.taleem360.com/img/navcons/classeswebp/6.webp" alt="punjab text books class 6" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/6th-text-books">6th Class Punjab Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 6 all subjects Punjab text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/6th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/7th-text-books"><img src="https://www.taleem360.com/img/navcons/classeswebp/7.webp" alt="punjab text books class 7" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/7th-text-books">7th Class Punjab Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 7 all subjects Punjab text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/7th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/8th-text-books"><img src="https://www.taleem360.com/img/navcons/classeswebp/8.webp" alt="punjab text books class 8" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/8th-text-books">8th Class Punjab Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 8 all subjects Punjab text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/8th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/9th-text-books"><img src="https://www.taleem360.com/img/navcons/classeswebp/9.webp" alt="punjab text books class 9" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/9th-text-books">9th Class Punjab Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 9 all subjects Punjab text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/9th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/10th-text-books"><img src="https://www.taleem360.com/img/navcons/classeswebp/10.webp" alt="punjab text books class 10" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/10th-text-books">10th Class Punjab Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 10 all subjects Punjab text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/10th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/11th-text-books"><img src="https://www.taleem360.com/img/navcons/classeswebp/11.webp" alt="punjab text books class 11" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/11th-text-books">11th Class Punjab Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 11 all subjects Punjab text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/11th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>

<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/12th-text-books"><img src="https://www.taleem360.com/img/navcons/classeswebp/12.webp" alt="punjab text books class 12" style="display: inline-block; border-radius:50%;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/12th-text-books">12th Class Punjab Textbooks PDF</a><br></span></h2>
<p style="text-align: center;">Download Class 12 all subjects Punjab text books in PDF format.</p>
<br><a href="https://www.taleem360.com/categories/12th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-book" aria-hidden="true"></i> View Books</span></button></a></div>
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
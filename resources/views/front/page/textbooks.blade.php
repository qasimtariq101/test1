@extends('front.layouts.default')

@section('meta')
<meta name="description" content="Download text books of all boards (i.e Punjab, Sindh, KPK, Federal, Balochistan) and all classes (From Nursery to Intermediate) in PDF from taleem360.">
<meta name="keywords" content="Punjab Textbooks PDF, Sindh Text Books PDF, KPK Text Books PDF, Baluchistan textbooks PDF, Federal text books PDF, PCTB, STBB, BTBB, FBISE, KPTBB, PDF Text Books, NBF, National Book Foundation Books PDF, SNC Books, Single National Curriculum, Taleem360">
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
<h1 style="margin: 20px auto;">All Boards Text Books PDF</h1>
<p>Download Text Books of all boards (i.e Punjab, Sindh, KPK, Federal, Balochistan) and all classes (From Nursery to Intermediate) in PDF format from taleem360. Punjab Curriculum &amp; Text Book Board (PCTB), Lahore - Sindh Text Book Board (STBB), Jamshoro - Khyber Pakhtunkhwa Text Book Board (KPTBB), Peshawar - Federal Text Book Board (FBISE) &amp; National Book Foundation (NBF), Islamabad. <br> Here is the categories list of your desired content, please choose from below:</p>
<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/text-books"><img src="https://www.taleem360.com/img/navcons/book-boards/pctb.jpg" alt="PCTB Text Books PDF" style="display: inline-block;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/text-books">Punjab Text Books</a><br></span></h2>
<p style="text-align: center;">Download all Textbooks in PDF by Punjab Curriculum and Text Book Board (PCTB), Lahore.</p>
<br><a href="https://www.taleem360.com/categories/kachi-class-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> Kachi Class</span></button></a> <a href="https://www.taleem360.com/categories/class-one-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> Class 1</span></button></a> <a href="https://www.taleem360.com/categories/two-class-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> Class 2</span></button></a> <a href="https://www.taleem360.com/categories/class-three-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> Class 3</span></button></a> <a href="https://www.taleem360.com/categories/4th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 4th Class</span></button></a> <a href="https://www.taleem360.com/categories/5th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 5th Class</span></button></a> <a href="https://www.taleem360.com/categories/6th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 6th Class</span></button></a> <a href="https://www.taleem360.com/categories/7th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 7th Class</span></button></a> <a href="https://www.taleem360.com/categories/8th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 8th Class</span></button></a> <a href="https://www.taleem360.com/categories/9th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 9th Class</span></button></a> <a href="https://www.taleem360.com/categories/10th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 10th Class</span></button></a> <a href="https://www.taleem360.com/categories/11th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 11th Class</span></button></a> <a href="https://www.taleem360.com/categories/12th-text-books"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 12th Class</span></button></a></div>
<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/text-books-sindh"><img src="https://www.taleem360.com/img/navcons/book-boards/stbb.jpg" alt="STBB Text Books PDF" style="display: inline-block;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/text-books-sindh">Sindh Text Books</a><br></span></h2>
<p style="text-align: center;">Download all Textbooks in PDF by Sindh Text Book Board (STBB), Jamshoro. <br><span style="color: #e03e2d; font-size: 10pt;">(More Coming Soon)</span></p>
<br><a href="https://www.taleem360.com/categories/class-1-textbooks-sindh"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> Class 1</span></button></a> <a href="https://www.taleem360.com/categories/class-2-textbooks-sindh"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> Class 2</span></button></a> <a href="https://www.taleem360.com/categories/class-3-textbooks-sindh"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> Class 3</span></button></a> <a href="https://www.taleem360.com/categories/class-4-textbooks-sindh"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 4th Class</span></button></a> <a href="https://www.taleem360.com/categories/class-5-textbooks-sindh"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 5th Class</span></button></a> <a href="https://www.taleem360.com/categories/6th-textbooks-sindh"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 6th Class</span></button></a> <a href="https://www.taleem360.com/categories/7th-text-books-sindh"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 7th Class</span></button></a> <a href="https://www.taleem360.com/categories/8th-text-books-sindh"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 8th Class</span></button></a> <a href="https://www.taleem360.com/categories/9th-text-books-sindh"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 9th Class</span></button></a> <a href="https://www.taleem360.com/categories/10th-text-books-sindh"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 10th Class</span></button></a> <a href="https://www.taleem360.com/categories/11th-textbooks-sindh"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 11th Class</span></button></a> <a href="https://www.taleem360.com/categories/12th-textbooks-sindh"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 12th Class</span></button></a> <a href="https://www.taleem360.com/categories/9th10th-combined-sindh"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 9th/10th (Combined)</span></button></a></div>
<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/text-books-federal"><img src="https://www.taleem360.com/img/navcons/book-boards/fbise.jpg" alt="NBF and FBISE Text Books PDF" style="display: inline-block;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/text-books-federal">Federal Text Books</a><br></span></h2>
<p style="text-align: center;">Download all Textbooks in PDF by Federal TextBook Board (FBISE), Islamabad. <br><span style="color: #e03e2d; font-size: 10pt;">(More Coming Soon)</span></p>
<br><a href="https://www.taleem360.com/categories/9th-text-books-federal"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 9th Class</span></button></a> <a href="https://www.taleem360.com/categories/10th-text-books-federal"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 10th Class</span></button></a> <a href="https://www.taleem360.com/categories/11th-text-books-federal"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 11th Class</span></button></a> <a href="https://www.taleem360.com/categories/12th-text-books-federal"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 12th Class</span></button></a></div>
<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/text-books-kpk"><img src="https://www.taleem360.com/img/navcons/book-boards/kptbb.jpg" alt="KPTBB Text Books PDF" style="display: inline-block;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/text-books-kpk">KPK Text Books</a><br></span></h2>
<p style="text-align: center;">Download all Textbooks in PDF by Khyber Pakhtunkhwa Textbook Board, Peshawar. <br><span style="color: #e03e2d; font-size: 10pt;">(More Coming Soon)</span></p>
<br><!--<a href="#"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> Class 1</span></button></a> <a href="#"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> Class 2</span></button></a> <a href="#"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> Class 3</span></button></a> <a href="#"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 4th Class</span></button></a> <a href="#"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 5th Class</span></button></a> <a href="#"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 6th Class</span></button></a> <a href="#"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 7th Class</span></button></a> <a href="#"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 8th Class</span></button></a>--> <a href="https://www.taleem360.com/categories/9th-text-books-kpk"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 9th Class</span></button></a> <a href="https://www.taleem360.com/categories/10th-text-books-kpk"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 10th Class</span></button></a> <a href="https://www.taleem360.com/categories/11th-text-books-kpk"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 11th Class</span></button></a> <a href="https://www.taleem360.com/categories/12th-text-books-kpk"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 12th Class</span></button></a></div>
<div class="team-boxs" style="text-align: center;"><a href="https://www.taleem360.com/categories/text-books-balochistan"><img src="https://www.taleem360.com/img/navcons/book-boards/btbb.jpg" alt="BTBB Text Books PDF" style="display: inline-block;" width="150px"></a>
<h2 style="text-align: center;"><span style="font-size: 14pt;"><a href="https://www.taleem360.com/categories/text-books-balochistan">Balochistan Text Books</a><br></span></h2>
<p style="text-align: center;">Download all Textbooks in PDF by Balochistan Textbook Board (BTB), Quetta. <br><span style="color: #e03e2d; font-size: 10pt;">(More Coming Soon)</span></p>
<br><a href="https://www.taleem360.com/categories/class-1-textbooks-btbb"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> Class 1</span></button></a> <a href="https://www.taleem360.com/categories/class-2-textbooks-btbb"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> Class 2</span></button></a> <a href="https://www.taleem360.com/categories/class-3-textbooks-btbb"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> Class 3</span></button></a> <a href="https://www.taleem360.com/categories/4th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 4th Class</span></button></a> <a href="https://www.taleem360.com/categories/5th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 5th Class</span></button></a> <a href="https://www.taleem360.com/categories/6th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 6th Class</span></button></a> <a href="https://www.taleem360.com/categories/7th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 7th Class</span></button></a> <a href="https://www.taleem360.com/categories/8th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 8th Class</span></button></a> <a href="https://www.taleem360.com/categories/9th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 9th Class</span></button></a> <a href="https://www.taleem360.com/categories/10th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 10th Class</span></button></a> <a href="https://www.taleem360.com/categories/11th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 11th Class</span></button></a> <a href="https://www.taleem360.com/categories/12th-books-balochistan"><button class="buttonhostel" style="vertical-align: middle; width: 200px;"><span> <i class="fa fa-graduation-cap" aria-hidden="true"></i> 12th Class</span></button></a></div>
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
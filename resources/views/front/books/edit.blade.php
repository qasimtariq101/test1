@extends('front.layouts.default')

@section('meta')
<meta name="description" content="{{config('settings.meta_description')}}">
<meta name="keywords" content="{{config('settings.meta_keywords')}}">
<meta name="author" content="{{config('settings.site_name')}}">
<meta property="og:title" content="@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}" />
<meta property="og:type" content="article" />
<meta property="og:url" content="{{Request::url()}}" />
<meta property="og:image" content="{{url(config('settings.site_image'))}}" />
<meta property="og:site_name" content="{{config('settings.site_name')}}" />
<link rel="canonical" href="{{Request::url()}}" />
@stop

@section('content')
<div id="main-content">
  <section class="kopa-area kopa-area-15" style="margin-bottom: 40px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12" style="margin-bottom: 10px;">
          <div class="breadcrumb-content"> 
              <span itemtype="https://schema.org/breadcrumb" itemscope=""> 
                <a itemprop="url" href="{{url('/')}}" class="active"> <span itemprop="title">{{ __('Home')}}</span> </a>
              </span> 
              <span>&nbsp;&nbsp; / &nbsp;&nbsp;</span>               
              <span itemtype="https://schema.org/breadcrumb" itemscope=""> 
                <a itemprop="url" href="{{route('my_books')}}" class="active"> <span itemprop="title">{{ __('My eBooks')}}</span> </a>
              </span> 
              <span>&nbsp;&nbsp; / &nbsp;&nbsp;</span> 
              <span itemtype="https://schema.org/breadcrumb" itemscope=""> 
                <a itemprop="url" class="current-page"> <span itemprop="title">{{$page_title}}</span> </a> 
              </span> 
          </div>
        </div>
      </div>      
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="widget">
            <header class="widget-header style-01">
              <h3 class="widget-title style-02"> {{ $page_title}} </h3>
            </header>
            <div class="widget-content">
              <div class="ct-form-box">
                <div id="respond" class="comment-respond">
                  <form class="eco_form" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-2"> <img src="{{$book->thumbnail_f}}"> </div>
                      <div class="col-md-8 col-sm-8 col-xs-8 col-md-push-1"> @include('front.includes.messages')
                        <p class="input-block">
                          <label>{{ __('Thumbnail')}} [{{ __('Optional')}}]</label>
                          <input type="file" name="thumbnail" class="valid">
                          <small>{{ __('Only jpg png files are allowed')}}. {{ __('Max')}} {{config('settings.max_thumbnail_upload_size')}}{{ __('MB')}}</small> </p>
                        <div class="row">
                          <div class="col-md-6">
                            <p class="input-block">
                              <label>{{ __('Title')}} [{{ __('Optional')}}]</label>
                              <input type="text" name="title" placeholder="{{ __('Title')}}" value="{{old('title',$book->title)}}" class="valid" tabindex="1" autofocus>
                            </p>
                          </div>
                          <div class="col-md-6">
                            <p class="input-block">
                              <label>{{ __('Category')}}</label>
                              <select name="category_id" class="valid" tabindex="2">
                                @php $selected = old('category_id',$book->category_id); @endphp
                              @foreach($categories as $category)
                                                                
                                <option value="{{$category->id}}" @if($selected == $category->id) selected @endif @if($category->sub_categories->count() > 0) style="font-weight:bold;" @endif>{{$category->name}}</option>

                                @if($category->sub_categories->count() > 0)
                                  @foreach($category->sub_categories as $sc)
                                  @php if($sc->active != 1) continue; @endphp
                                     <option value="{{$sc->id}}" @if($selected == $sc->id) selected @endif>&nbsp;&nbsp;  -  {{$sc->name}}</option>
                                  @endforeach
                                @endif
                                
                              @endforeach                             
                              </select>
                            </p>
                          </div>
                        </div>
                        <p class="input-block">
                          <label>{{ __('Author Name') }} [{{ __('Optional')}}]</label>
                          <input type="text" class="valid" name="author_name" value="{{ old('author_name',$book->author_name) }}" placeholder="{{ __('Author Name') }}" tabindex="3">
                        </p>                        
                        <p class="input-block">
                          <label>{{ __('Overview')}} [{{ __('Optional')}}]</label>
                          <textarea name="overview" placeholder="{{ __('Write something about your book')}}" tabindex="4">{{old('overview',$book->overview)}}</textarea>
                          <small>{{ __('Allowed Tags') }} : {{ config('settings.book_overview_allowed_tags') }}</small>
                        </p>
                        <div class="row">
                          <div class="col-md-6">
                            <p class="input-block">
                              <label>{{ __('Status')}}</label>
                              @php $selected = old('status',$book->status); @endphp
                              <select name="status" class="valid" tabindex="5">
                                <option value="1" @if($selected == 1) selected @endif>{{ __('Public')}}</option>
                                <option value="2" @if($selected == 2) selected @endif>{{ __('Unlisted')}}</option>
                                <option value="3" @if($selected == 3) selected @endif @if(!Auth::check()) disabled @endif>
                                
                                {{ __('Private')}}
                                
                                </option>
                              </select>
                            </p>
                          </div>
                          <div class="col-md-6">
                            <p class="input-block">
                              <label>{{ __('Password')}} [{{ __('Optional')}}]</label>
                              <input type="password" name="password" placeholder="{{ __('Password')}}" value="{{old('password')}}" class="valid" tabindex="6">
                            </p>
                          </div>
                        </div>
                        <p class="input-block">
                          <label>{{ __('Tags')}} [{{ __('Optional')}}]</label>
                          <textarea name="tags" placeholder="{{ __('tags separated by comma')}}" tabindex="7">{{old('tags',$book->tags)}}</textarea>
                        </p>


                      <div class="input-block progress-container hidden">
                        <div class="progress">
                          <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                        </div>                        
                      </div>

                      </div>
                      <!-- col-md-6 --> 
                      
                    </div>
                    <!-- row -->
                    
                    <p class="input-block btn-block clearfix text-center">
                      <input type="submit" value="{{ __('Update')}}" class="ct-submit-1" tabindex="8">
                    </p>
                  </form>
                </div>
              </div>
              <!-- form-box --> 
              
            </div>
          </div>
          <!-- widget --> 
          
        </div>
        <!-- col-md-12 --> 
        
      </div>
      <!-- row --> 
      
    </div>
    <!-- container --> 
    
  </section>
  <!-- kopa-area-17 --> 
  
</div>
@stop
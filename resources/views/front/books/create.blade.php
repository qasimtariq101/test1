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

@section('after_scripts')
<script>
$('select[name="storage"]').on('change',function(){
  set_type();
});

function set_type()
{
  $(".storage_type").addClass('hidden');
  if($('select[name="storage"]').val() == 'upload'){    
    $("#upload").removeClass('hidden');
  }
  else if($('select[name="storage"]').val() == 'google_drive_link'){
    $("#google_drive_link").removeClass('hidden');
  }
  else if ($('select[name="storage"]').val() == 'external_link') {
    $('#external_link').removeClass('hidden');
  }
  else{
    $('#embed_code').removeClass('hidden');
  }
}  
set_type()
</script>
@stop


@section('content')
<div id="main-content">
  <section class="kopa-area kopa-area-15" style="margin-bottom: 40px;">
    <div class="container">
      <div class="row">
        <div class="col-md-12" style="margin-bottom: 10px;">
          @include('front.includes.breadcrumb')
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
                      <div class="col-md-8 col-sm-8 col-xs-8 col-md-push-2"> @include('front.includes.messages')
                        <div class="row">
                          <div class="col-md-4 col-md-push-4">
                            <label>{{ __('Storage') }}</label>
                            <select name="storage" class="valid">
                              <option value="upload" {{ old('storage') == 'upload' ? 'selected' : '' }}>{{ __('Upload') }}</option>
                              <option value="google_drive_link" {{ old('storage') == 'google_drive_link' ? 'selected' : '' }}>{{ __('Google Drive Link') }}</option>  
                              @if(config('settings.external_link_embed'))                            
                              <option value="external_link" {{ old('storage') == 'external_link' ? 'selected' : '' }}>{{ __('External Link') }}</option>
                              <option value="embed_code" {{ old('storage') == 'embed_code' ? 'selected' : '' }}>{{ __('Embed Code') }}</option>
                              @endif
                            </select>
                          </div>
                        </div>
                        <div class="row">

                          <div class="col-md-6 storage_type hidden" id="google_drive_link">
                            <p class="input-block">
                              <label>{{ __('Google Drive Link')}}</label>
                              <input type="text" name="google_drive_link" class="valid" placeholder="https://drive.google.com/file/d/XXXXXXXXXXXXXXX/preview" value="{{ old('google_drive_link') }}">
                            <small>{{ __('Only Google drive embed links are allowed')}}. <br/> {{ __('For eg') }}, https://drive.google.com/file/d/XXXXXXXXXXXXXXX/preview</small> </p>
                          </div>

                          <div class="col-md-6 storage_type" id="upload">
                            <p class="input-block">
                              <label>{{ __('eBook')}}</label>
                              <input type="file" name="ebook" class="valid">
                              <small>{{ __('Only')}} {{str_replace(',', ', ', config('settings.allowed_book_mimes'))}} {{ __('files are allowed')}}. {{ __('Max')}} {{config('settings.max_book_upload_size')}}{{ __('MB')}}</small> 
                            </p>
                          </div>

                          @if(config('settings.external_link_embed')) 
                          <div class="col-md-6 storage_type hidden" id="external_link">
                            <p class="input-block">
                              <label>{{ __('External Link')}}</label>
                              <input type="text" name="external_link" class="valid" placeholder="https://example.com/amazing_novel.pdf" value="{{ old('external_link') }}">
                              <small>{{ __('Only')}} {{str_replace(',', ', ', config('settings.allowed_book_mimes'))}} {{ __('links are allowed')}}. </small>
                             </p>
                          </div>

                          <div class="col-md-6 storage_type hidden" id="embed_code">
                            <p class="input-block">
                              <label>{{ __('Embed Code')}}</label>
                              <textarea name="embed_code" rows="2" class="valid" placeholder="<iframe ...></iframe>">{{ old('embed_code') }}</textarea>
                             </p>
                          </div>
                          @endif

                          <div class="col-md-6">
                            <p class="input-block">
                              <label>{{ __('Thumbnail')}} [{{ __('Optional')}}]</label>
                              <input type="file" name="thumbnail" class="valid">
                              <small>{{ __('Only jpg png files are allowed')}}. {{ __('Max')}} {{config('settings.max_thumbnail_upload_size')}}{{ __('MB')}}</small> </p>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <p class="input-block">
                              <label>{{ __('Title')}} [{{ __('Optional')}}]</label>
                              <input type="text" name="title" placeholder="{{ __('Title')}}" value="{{old('title')}}" class="valid" tabindex="1" autofocus>
                            </p>
                          </div>
                          <div class="col-md-6">
                            <p class="input-block">
                              <label>{{ __('Category')}}</label>
                              <select name="category_id" class="valid" tabindex="2">
                                    @php $selected = old('category_id'); @endphp
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
                          <input type="text" class="valid" name="author_name" value="{{ old('author_name') }}" placeholder="{{ __('Author Name') }}" tabindex="3">
                        </p>
                        <p class="input-block">
                          <label>{{ __('Overview')}} [{{ __('Optional')}}]</label>
                          <textarea name="overview" placeholder="{{ __('Write something about your book')}}" tabindex="4">{{old('overview')}}</textarea>
                          <small>{{ __('Allowed Tags') }} : {{ config('settings.book_overview_allowed_tags') }}</small>
                        </p>
                        <div class="row">
                          <div class="col-md-12">
                            <p class="input-block">
                              <label>{{ __('Status')}}</label>
                              @php $selected = old('status'); @endphp
                              <select name="status" class="valid" tabindex="5">
                                <option value="1" @if($selected == 1) selected @endif>{{ __('Public')}}</option>
                                <option value="2" @if($selected == 2) selected @endif>{{ __('Unlisted')}}</option>
                                <option value="3" @if($selected == 3) selected @endif @if(!Auth::check()) disabled @endif>{{ __('Private')}}</option>
                              </select>
                            </p>
                          </div>
                                                   
                        </div>
                        <p class="input-block">
                            <label>{{ __('Tags')}} [{{ __('Optional')}}]</label>
                            <textarea name="tags" placeholder="{{ __('tags separated by comma')}}" tabindex="7">{{old('tags')}}</textarea>
                        </p> 

                    @if(config('settings.captcha') == 1)
                      @if(config('settings.captcha_type') == 1) @captcha
                      @else
                      <div class="input-group mt-5">
                      <span class="input-group-addon p-0" style="width: 120px;text-align: left;"><img src="{{captcha_src(config('settings.custom_captcha_style'))}}" id="captchaCode" alt="" class="captcha"></span>  
                      <input style="height: 5rem;" type="text" name="g-recaptcha-response" class="form-control" placeholder="{{ __('Security Check')}}" autocomplete="off" tabindex="8" required>
                      <span class="input-group-addon"><a rel="nofollow" href="javascript:" onclick="document.getElementById('captchaCode').src='{{ url("captcha") }}/{{config('settings.custom_captcha_style')}}?'+Math.random()" class="refresh">
                                                    <i class="fa fa-refresh"></i>
                      </a></span>
                      </div>
                      @endif
                    @endif                             
                        
                        @if(!Auth::check())
                        <p class="input-block">
                        <div class="alert ct-alert-1 style-05">
                          <div class="alert-content"> <i class="fa fa-info-circle"></i> {{ __('You are currently not logged in')}}, {{ __('this means you can not edit or delete anything you upload')}}. <a href="{{route('register')}}">{{ __('Sign Up')}}</a> {{ __('or')}} <a href="{{route('login')}}">{{ __('Login')}}</a> </div>
                        </div>
                        </p>
                        @endif 


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
                      <input type="submit" value="{{ __('Upload')}}" class="ct-submit-1" tabindex="9">
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
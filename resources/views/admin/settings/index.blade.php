@extends('admin.layouts.default')


@section('after_scripts')
  @if(session('type'))
    <script>
            $('#{{session('type')}}').addClass('active show');
            $('#{{session('type')}}-tab').addClass('active');
    </script>
  @else
    <script>
            $('#general').addClass('active show');
            $('#general-tab').addClass('active');
    </script>
  @endif
@stop

@section('content')
  <!--Main layout-->
  <main class="pt-5 mx-lg-5">
    <div class="container mt-5">
      <!-- Heading -->
      <div class="card mb-4">
        <!--Card content-->
        <div class="card-body d-sm-flex justify-content-between">
          <h4 class="mb-2 mb-sm-0 pt-1"><a href="{{url('admin/dashboard')}}">Admin </a> <span>/ </span>
            <span>{{$page_title}} </span></h4>
          <div>
            <a href="{{url('admin/clear-cache')}}" class="btn btn-sm btn-danger">
              <i class="fa fa-trash"> </i> Clear Cache </a>
            <a href="https://qasimtariq.com/contact" target="_blank" class="btn btn-sm btn-primary">
              <i class="fa fa-envelope"> </i> Contact Owner </a>            
          </div>
        </div>
      </div>
      <!-- Heading -->
      <!--Grid row-->
      <div class="row">
        <div class="col-md-12">@include('admin.includes.messages') </div>
        <div class="col-md-12">
          <div class="card mb-4">
            <div class="card-header p-0">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link" id="general-tab" data-toggle="tab" href="#general" role="tab"><i class="fa fa-cog"></i> General
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="book-tab" data-toggle="tab" href="#book" role="tab"><i class="fa fa-book"></i> eBook
                  </a>
                </li>                
                <li class="nav-item">
                  <a class="nav-link" id="storage-tab" data-toggle="tab" href="#storage" role="tab"><i class="fa fa-save"></i> Storage
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="advertisement-tab" data-toggle="tab" href="#advertisement" role="tab"><i class="fa fa-audio-description"></i> Advertisement
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab"><i class="fa fa-anchor"></i> SEO
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="comments-tab" data-toggle="tab" href="#comments" role="tab"><i class="fa fa-comments"></i> Comments
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="captcha-tab" data-toggle="tab" href="#captcha" role="tab"><i class="fa fa-dot-circle-o"></i> Captcha
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="social_auth-tab" data-toggle="tab" href="#social_auth" role="tab"><i class="fa fa-vcard-o"></i> Social Auth
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="mail-tab" data-toggle="tab" href="#mail" role="tab"><i class="fa fa-envelope"></i> Mail
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="social_links-tab" data-toggle="tab" href="#social_links" role="tab"><i class="fa fa-globe"></i> Social Links
                  </a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab">
                  <form class="eco_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="general">
                    <div class="row">
                      <div class="col-md-6">


              <div class="form-group">
                <label>{{ __('Site Name')}}*</label>
                <input type="text" class="form-control" name="site_name" placeholder="PasteShr" value="{{old('site_name',$settings['site_name'])}}" >
              </div>
              <div class="form-group">
                <label>{{ __('Site Email')}}*</label>
                <input type="email" class="form-control" name="site_email" placeholder="{{ __('Email')}}" value="{{old('site_email',$settings['site_email'])}}" >
              </div>
              <div class="form-group">
                <label>{{ __('Default Site Locale')}}</label>
                @php $selected = old('default_locale',$settings['default_locale']); @endphp
                <select class="form-control" name="default_locale">
                  <option value="en">{{ __('Select')}}</option>
                  
                  
                @foreach($locales as $lang)
                
                  
                  <option value="{{$lang->code}}" @if($selected == $lang->code) selected @endif>{{$lang->name}}</option>
                  
                  
                @endforeach
            
                
                </select>
              </div>
              <div class="form-group">
                <label>{{ __('Default Timezone')}}</label>
                <input type="text" class="form-control" name="default_timezone" placeholder="Asia/Kolkata" value="{{old('default_timezone',$settings['default_timezone'])}}">
                <small>{{ __('To find your timezone')}} <a href="http://php.net/manual/en/timezones.php" target="_blank">{{ __('click here')}}</a>.</small> </div>
              <div class="form-group">
                <label>{{ __('Site Logo')}}</label>
                <br/>
                @if(!empty($settings['site_logo']))<img src="{{$settings['site_logo']}}" height="32">@endif
                <br/>
                <div class="input-group">
                  <div class="input-group-prepend"> <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Change Site Logo')}}</span> </div>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="site_logo" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file')}}</label>
                  </div>
                </div>
                <small>{{ __('Only png files are allowed')}}, {{ __('Max File Size')}}: 200kb, {{ __('Recommended')}} 200x48</small> </div>
              <div class="form-group">
                <label>{{ __('Footer Logo')}}</label>
                <br/>
                @if(!empty($settings['footer_logo']))<img src="{{$settings['footer_logo']}}" class="bg-dark" height="32">@endif
                <br/>
                <div class="input-group">
                  <div class="input-group-prepend"> <span class="input-group-text" id="footer_logo1">{{ __('Change Footer Logo')}}</span> </div>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="footer_logo" id="inputGroupFile01" aria-describedby="footer_logo1">
                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file')}}</label>
                  </div>
                </div>
                <small>{{ __('Only png files are allowed')}}, {{ __('Max File Size')}}: 200kb, {{ __('Recommended')}} 200x48</small> </div>
              <div class="form-group">
                <label>{{ __('Site Favicon')}}</label>
                <br/>
                @if(!empty($settings['site_favicon']))<img src="{{$settings['site_favicon']}}" class="bg-dark" height="32">@endif
                <br/>
                <div class="input-group">
                  <div class="input-group-prepend"> <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Change Favicon')}}</span> </div>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="site_favicon" id="inputGroupFile02" aria-describedby="inputGroupFileAddon02">
                    <label class="custom-file-label" for="inputGroupFile02">{{ __('Choose file')}}</label>
                  </div>
                </div>
                <small>{{ __('Only png or ico files are allowed')}}, {{ __('Max File Size')}}: 100kb, {{ __('Recommended')}} 32x32</small> </div>
            

                      </div>
        <div class="col-md-6">


              <div class="form-group">
                <label>{{ __('Footer Text')}}</label>
                <textarea class="form-control" name="footer_text" rows="2">{{old('footer_text',$settings['footer_text'])}}</textarea>
              </div>
              <div class="form-group">
                <label>{{ __('Header Style')}}</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="header_style1" name="header_style" value="1" @if($settings['header_style'] == 1) checked @endif>
                  <label class="custom-control-label" for="header_style1">{{ __('Style 1')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="header_style2" name="header_style" value="2" @if($settings['header_style'] == 2) checked @endif>
                  <label class="custom-control-label" for="header_style2">{{ __('Style 2')}}</label>
                </div>
              </div>                
              <div class="form-group">
                <label>{{ __('Registration Open')}}</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="registration_open1" name="registration_open" value="1" @if($settings['registration_open'] == 1) checked @endif>
                  <label class="custom-control-label" for="registration_open1">{{ __('Yes')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="registration_open0" name="registration_open" value="0" @if($settings['registration_open'] == 0) checked @endif>
                  <label class="custom-control-label" for="registration_open0">{{ __('No')}}</label>
                </div>
              </div> 
              <div class="form-group">
                <label>{{ __('Cookie Consent Bar')}}</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="cookie_consent_bar1" name="cookie_consent_bar" value="1" @if($settings['cookie_consent_bar'] == 1) checked @endif>
                  <label class="custom-control-label" for="cookie_consent_bar1">{{ __('On')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="cookie_consent_bar0" name="cookie_consent_bar" value="0" @if($settings['cookie_consent_bar'] == 0) checked @endif>
                  <label class="custom-control-label" for="cookie_consent_bar0">{{ __('Off')}}</label>
                </div>
              </div> 

              <div class="form-group">
                <label>{{ __('Auto Approve User')}}</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="auto_approve_user1" name="auto_approve_user" value="1" @if($settings['auto_approve_user'] == 1) checked @endif>
                  <label class="custom-control-label" for="auto_approve_user1">{{ __('Yes')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="auto_approve_user0" name="auto_approve_user" value="0" @if($settings['auto_approve_user'] == 0) checked @endif>
                  <label class="custom-control-label" for="auto_approve_user0">{{ __('No')}}</label>
                </div>
              </div>


                        <div class="form-group">
                          <label>{{ __('Maintenance Mode') }} </label> <br />
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="maintenance_mode1" name="maintenance_mode" value="1" @if($settings['maintenance_mode'] == 1) checked @endif>
                            <label class="custom-control-label" for="maintenance_mode1">{{ __('On') }} </label>
                          </div>
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="maintenance_mode0" name="maintenance_mode" value="0" @if($settings['maintenance_mode'] == 0) checked @endif>
                            <label class="custom-control-label" for="maintenance_mode0">{{ __('Off') }} </label>
                          </div>
                        </div>
                        <div class="form-group">
                          <label>{{ __('Maintenance Text') }} </label>
                          <textarea class="form-control" name="maintenance_text" rows="2">{{old('maintenance_text',$settings['maintenance_text'])}}</textarea>
                        </div>

                        <div class="form-group">
                          <label>{{ __('String Validation') }} </label> <br />
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="string_validation1" name="string_validation" value="1" @if($settings['string_validation'] == 1) checked @endif>
                            <label class="custom-control-label" for="string_validation1">{{ __('Strict') }} </label>
                          </div>
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="string_validation0" name="string_validation" value="2" @if($settings['string_validation'] == 2) checked @endif>
                            <label class="custom-control-label" for="string_validation0">{{ __('Moderate') }} </label>
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Purchase Code </label>
                          <input type="text" class="form-control" value="{{config('settings.pc')}}" disabled>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="book" role="tabpanel" aria-labelledby="book-tab">
                  <form class="eco_form" method="post">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <input type="hidden" name="type" value="book">

              <div class="form-group">
                <label>{{ __('eBook Storage')}}</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="ebook_storage1" name="ebook_storage" value="uploads" @if($settings['ebook_storage'] == 'uploads') checked @endif>
                  <label class="custom-control-label" for="ebook_storage1">{{ __('Local')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="ebook_storage2" name="ebook_storage" value="ftp" @if($settings['ebook_storage'] == 'ftp') checked @endif>
                  <label class="custom-control-label" for="ebook_storage2">{{ __('FTP')}}</label>
                </div>                
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="ebook_storage3" name="ebook_storage" value="s3" @if($settings['ebook_storage'] == 's3') checked @endif>
                  <label class="custom-control-label" for="ebook_storage3">{{ __('AWS S3')}}</label>
                </div>
                <small class="text-muted">{{ __('make sure to configure ftp or aws a3 from storage tab before using them')}}</small> 
              </div>

              <div class="form-group">
                <label>{{ __('eBook Page Layout')}}</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="book_page_layout1" name="book_page_layout" value="1" @if($settings['book_page_layout'] == 1) checked @endif>
                  <label class="custom-control-label" for="book_page_layout1">{{ __('Default')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="book_page_layout2" name="book_page_layout" value="2" @if($settings['book_page_layout'] == 2) checked @endif>
                  <label class="custom-control-label" for="book_page_layout2">{{ __('Full width')}}</label>
                </div>
              </div>              

              <div class="form-group">
                <label>{{ __('Default eBooks Page View')}}</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="default_books_page_view1" name="default_books_page_view" value="grid" @if($settings['default_books_page_view'] == 'grid') checked @endif>
                  <label class="custom-control-label" for="default_books_page_view1">{{ __('Grid')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="default_books_page_view2" name="default_books_page_view" value="list" @if($settings['default_books_page_view'] == 'list') checked @endif>
                  <label class="custom-control-label" for="default_books_page_view2">{{ __('List')}}</label>
                </div>
              </div>
              <div class="form-group">
                <label>{{ __('Public Upload')}}</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="public_upload1" name="public_upload" value="1" @if($settings['public_upload'] == 1) checked @endif>
                  <label class="custom-control-label" for="public_upload1">{{ __('Yes')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="public_upload0" name="public_upload" value="0" @if($settings['public_upload'] == 0) checked @endif>
                  <label class="custom-control-label" for="public_upload0">{{ __('No')}}</label>
                </div>
                <br/>
                <small class="text-muted">{{ __('anyone can upload ebook without registration or verifying email address')}}</small> 
              </div>              
              <div class="form-group">
                <label>{{ __('Admin Only Upload')}}</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="admin_only_upload1" name="admin_only_upload" value="1" @if($settings['admin_only_upload'] == 1) checked @endif>
                  <label class="custom-control-label" for="admin_only_upload1">{{ __('Yes')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="admin_only_upload0" name="admin_only_upload" value="0" @if($settings['admin_only_upload'] == 0) checked @endif>
                  <label class="custom-control-label" for="admin_only_upload0">{{ __('No')}}</label>
                </div>
                <br/>
                <small class="text-muted">{{ __('only admin can upload ebook')}}</small> 
              </div>              
              <div class="form-group">
                <label>{{ __('External Link Embed')}}</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="external_link_embed1" name="external_link_embed" value="1" @if($settings['external_link_embed'] == 1) checked @endif>
                  <label class="custom-control-label" for="external_link_embed1">{{ __('Yes')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="external_link_embed2" name="external_link_embed" value="0" @if($settings['external_link_embed'] == 0) checked @endif>
                  <label class="custom-control-label" for="external_link_embed2">{{ __('No')}}</label>
                </div>
                <br/>
                <small class="text-muted">{{ __('allow ebook submission with external link or embed code')}}</small> 
              </div>

              <div class="form-group">
                <label>{{ __('Auto Approve Books')}}</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="book_auto_approve1" name="book_auto_approve" value="1" @if($settings['book_auto_approve'] == 1) checked @endif>
                  <label class="custom-control-label" for="book_auto_approve1">{{ __('Yes')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="book_auto_approve0" name="book_auto_approve" value="0" @if($settings['book_auto_approve'] == 0) checked @endif>
                  <label class="custom-control-label" for="book_auto_approve0">{{ __('No')}}</label>
                </div>
                <br/>
                <small class="text-muted">Auto approve books submitted/uploaded by users</small> 
              </div>  

              <div class="form-group">
                <label>{{ __('Public Download')}}</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="public_download1" name="public_download" value="1" @if($settings['public_download'] == 1) checked @endif>
                  <label class="custom-control-label" for="public_download1">{{ __('Yes')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="public_download0" name="public_download" value="0" @if($settings['public_download'] == 0) checked @endif>
                  <label class="custom-control-label" for="public_download0">{{ __('No')}}</label>
                </div>
                <br/>
                <small class="text-muted">{{ __('Note')}} - {{ __('anyone will be still able to download it with direct file link')}}</small> 
              </div>  


              <div class="form-group">
                <label>{{ __('Allow Ratings')}}</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="allow_ratings1" name="allow_ratings" value="1" @if($settings['allow_ratings'] == 1) checked @endif>
                  <label class="custom-control-label" for="allow_ratings1">{{ __('Yes')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="allow_ratings0" name="allow_ratings" value="0" @if($settings['allow_ratings'] == 0) checked @endif>
                  <label class="custom-control-label" for="allow_ratings0">{{ __('No')}}</label>
                </div>
    
              </div> 





                        <div class="form-group mt-4 mb-0">
                          <label>{{ __('Pages') }} </label>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="custom-control custom-checkbox mb-2">
                              <input type="checkbox" class="custom-control-input" id="search_page" name="search_page" @if($settings['search_page'] == 1) checked @endif>
                              <label class="custom-control-label" for="search_page">{{ __('Search') }} </label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="custom-control custom-checkbox mb-2">
                              <input type="checkbox" class="custom-control-input" id="publishers_page" name="publishers_page" @if($settings['publishers_page'] == 1) checked @endif>
                              <label class="custom-control-label" for="publishers_page">{{ __('Publishers') }} </label>
                            </div>
                          </div>
                        </div>

              <div class="form-group mt-2">
                <label>{{ __('Features Toggle')}}</label>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" id="feature_share" name="feature_share" @if($settings['feature_share'] == 1) checked @endif>
                    <label class="custom-control-label" for="feature_share">{{ __('Share')}}</label>
                  </div>
                  <div class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" id="qr_code_share" name="qr_code_share" @if($settings['qr_code_share'] == 1) checked @endif>
                    <label class="custom-control-label" for="qr_code_share">{{ __('QR Code Share')}}</label>
                  </div>
                  <div class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" id="feature_copy" name="feature_copy" @if($settings['feature_copy'] == 1) checked @endif>
                    <label class="custom-control-label" for="feature_copy">{{ __('Copy Link')}}</label>
                  </div>
                  <div class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" id="feature_embed" name="feature_embed" @if($settings['feature_embed'] == 1) checked @endif>
                    <label class="custom-control-label" for="feature_embed">{{ __('Embed')}}</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" id="feature_download" name="feature_download" @if($settings['feature_download'] == 1) checked @endif>
                    <label class="custom-control-label" for="feature_download">{{ __('Download')}}</label>
                  </div>
                  <div class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" id="feature_report" name="feature_report" @if($settings['feature_report'] == 1) checked @endif>
                    <label class="custom-control-label" for="feature_report">{{ __('Report')}}</label>
                  </div>
                  <div class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" id="feature_print" name="feature_print" @if($settings['feature_print'] == 1) checked @endif>
                    <label class="custom-control-label" for="feature_print">{{ __('Print')}}</label>
                  </div>                  
                  <div class="custom-control custom-checkbox mb-2">
                    <input type="checkbox" class="custom-control-input" id="feature_full_screen" name="feature_full_screen" @if($settings['feature_full_screen'] == 1) checked @endif>
                    <label class="custom-control-label" for="feature_full_screen">{{ __('Full Screen')}}</label>
                  </div>
                </div>
              </div>




                      </div>
                      <div class="col-md-6">

 <div class="form-group">
                <label>{{ __('Max Book Upload Size in MB')}}*</label>
                <input type="number" class="form-control" name="max_book_upload_size" placeholder="2" value="{{old('max_book_upload_size',$settings['max_book_upload_size'])}}" >
              </div>
              <div class="form-group">
                <label>{{ __('New Books limit')}}*</label>
                <input type="number" class="form-control" name="new_books_limit" placeholder="10" value="{{old('new_books_limit',$settings['new_books_limit'])}}" >
                <small>Homepage list</small>
              </div>
              <div class="form-group">
                <label>{{ __('Featured Books limit')}}*</label>
                <input type="number" class="form-control" name="featured_books_limit" placeholder="10" value="{{old('featured_books_limit',$settings['featured_books_limit'])}}" >
                <small>Homepage list</small>
              </div>
                                          
              <div class="form-group">
                <label>{{ __('Books per page')}}*</label>
                <input type="number" class="form-control" name="books_per_page" placeholder="10" value="{{old('books_per_page',$settings['books_per_page'])}}" >
              </div>
              <div class="form-group">
                <label>{{ __('Daily Upload Limit for Unauthorized user')}}*</label>
                <input type="number" class="form-control" name="daily_upload_limit_unauth" placeholder="5" value="{{old('daily_upload_limit_unauth',$settings['daily_upload_limit_unauth'])}}" >
              </div>
              <div class="form-group">
                <label>{{ __('Daily Upload Limit for Authorized user')}}*</label>
                <input type="number" class="form-control" name="daily_upload_limit_auth" placeholder="5" value="{{old('daily_upload_limit_auth',$settings['daily_upload_limit_auth'])}}" >
              </div>
              <div class="form-group">
                <label>{{ __('Book Upload Time Restriction for Authorized user')}}*</label>
                <input type="number" class="form-control" name="upload_time_restrict_auth" placeholder="60" value="{{old('upload_time_restrict_auth',$settings['upload_time_restrict_auth'])}}" >
                <small>{{ __('in seconds')}}</small> </div>
              <div class="form-group">
                <label>{{ __('Book Upload Time Restriction for Unauthorized user')}}*</label>
                <input type="number" class="form-control" name="upload_time_restrict_unauth" placeholder="600" value="{{old('upload_time_restrict_unauth',$settings['upload_time_restrict_unauth'])}}" >
                <small>{{ __('in seconds')}}</small> 
              </div>
             
             <div class="form-group">
              <label>{{ __('Book Overview Allowed Tags') }}</label>
              <input type="text" class="form-control" name="book_overview_allowed_tags" value="{{ old('book_overview_allowed_tags',$settings['book_overview_allowed_tags']) }}">
              <small>html tag names separated by comma</small>
            </div>


                      </div>
                    </div>
                    <div class="form-group mb-4">
                      <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                    </div>
                  </form>
                </div>



              <div class="tab-pane fade" id="storage" role="tabpanel" aria-labelledby="storage-tab">
                  <form class="eco_form" method="post">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <input type="hidden" name="type" value="storage">

                        <div class="text-center"><b>FTP</b></div>
                        <div class="form-group">
                          <label>{{ __('Host')}}</label>
                          <input type="text" class="form-control" name="ftp_host" placeholder="ftp.example.com" value="{{old('ftp_host',$settings['ftp_host'])}}" >
                        </div>                        

                        <div class="form-group">
                          <label>{{ __('Username')}}</label>
                          <input type="text" class="form-control" name="ftp_username" placeholder="username" value="{{old('ftp_username',$settings['ftp_username'])}}" >
                        </div>                        

                        <div class="form-group">
                          <label>{{ __('Password')}}</label>
                          <input type="password" class="form-control" name="ftp_password" placeholder="password" value="{{old('ftp_password',$settings['ftp_password'])}}" >
                        </div>                        

                        <div class="form-group">
                          <label>{{ __('Port')}}</label>
                          <input type="number" class="form-control" name="ftp_port" placeholder="21" value="{{old('ftp_port',$settings['ftp_port'])}}" >
                        </div>                        

                        <div class="form-group">
                          <label>{{ __('URL')}}</label>
                          <input type="text" class="form-control" name="ftp_url" placeholder="http://example.com" value="{{old('ftp_url',$settings['ftp_url'])}}" >
                        </div>

                      </div>
                      <div class="col-md-6">
                        
                      <div class="text-center"><b>AWS S3</b></div>
                        <div class="form-group">
                          <label>{{ __('Key')}}</label>
                          <input type="text" class="form-control" name="aws_s3_key" placeholder="XXXXXXXXXXXXXXX" value="{{old('aws_s3_key',$settings['aws_s3_key'])}}" >
                        </div>                        

                        <div class="form-group">
                          <label>{{ __('Secret')}}</label>
                          <input type="text" class="form-control" name="aws_s3_secret" placeholder="XXXXXXXXXXXXXX" value="{{old('aws_s3_secret',$settings['aws_s3_secret'])}}" >
                        </div>                        

                        <div class="form-group">
                          <label>{{ __('Region')}}</label>
                          <input type="text" class="form-control" name="aws_s3_region" value="{{old('aws_s3_region',$settings['aws_s3_region'])}}" >
                        </div>                        

                        <div class="form-group">
                          <label>{{ __('Bucket')}}</label>
                          <input type="text" class="form-control" name="aws_s3_bucket" value="{{old('aws_s3_bucket',$settings['aws_s3_bucket'])}}" >
                        </div>                        

                        <div class="form-group">
                          <label>{{ __('URL')}}</label>
                          <input type="text" class="form-control" name="aws_s3_url" placeholder="http://example.com" value="{{old('aws_s3_url',$settings['aws_s3_url'])}}" >
                        </div>

                      </div>
                    </div>
                    <div class="form-group mb-4">
                      <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                    </div>                    
                  </form>
                </div>

                <div class="tab-pane fade" id="advertisement" role="tabpanel" aria-labelledby="advertisement-tab">
                  <form class="eco_form" method="post">
                    <input type="hidden" name="type" value="advertisement">
                    @csrf

              <div class="form-group">
                <label>{{ __('AdBlock Detection')}}</label>
                <br/>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="ad_block_detection1" name="ad_block_detection" value="1" @if($settings['ad_block_detection'] == 1) checked @endif>
                  <label class="custom-control-label" for="ad_block_detection1">{{ __('On')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="ad_block_detection0" name="ad_block_detection" value="0" @if($settings['ad_block_detection'] == 0) checked @endif>
                  <label class="custom-control-label" for="ad_block_detection0">{{ __('Off')}}</label>
                </div>
                <br/><small>Blocks access to content if adblocker detected</small>
              </div> 

                    <div class="form-group">
                      <label>Ad Blocks (on/off) </label> <br />
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="ad1" name="ad" value="1" @if($settings['ad'] == 1) checked @endif>
                        <label class="custom-control-label" for="ad1">On </label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="ad0" name="ad" value="0" @if($settings['ad'] == 0) checked @endif>
                        <label class="custom-control-label" for="ad0">Off </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Ad Block 1 </label>
                      <textarea class="form-control" name="ad1" rows="4">{{old('ad1',html_entity_decode($settings['ad1']))}}</textarea>
                    </div>
                    <div class="form-group">
                      <label>Ad Block 2 </label>
                      <textarea class="form-control" name="ad2" rows="4">{{old('ad2',html_entity_decode($settings['ad2']))}}</textarea>
                    </div>
                    <div class="form-group">
                      <label>Ad Block 3 </label>
                      <textarea class="form-control" name="ad3" rows="4">{{old('ad3',html_entity_decode($settings['ad3']))}}</textarea>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                  <form class="eco_form" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="seo">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Meta Description </label>
                          <textarea class="form-control" name="meta_description">{{old('meta_description',$settings['meta_description'])}}</textarea>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Meta Keywords </label>
                          <textarea class="form-control" name="meta_keywords">{{old('meta_keywords',$settings['meta_keywords'])}}</textarea>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Analytics Code </label>
                      <textarea class="form-control" name="analytics_code" placeholder="<script>..</script>">{{old('analytics_code',html_entity_decode($settings['analytics_code']))}}</textarea>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Header Code </label>
                          <textarea class="form-control" name="header_code" placeholder="<script>..</script>">{{old('header_code',html_entity_decode($settings['header_code']))}}</textarea>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Footer Code </label>
                          <textarea class="form-control" name="footer_code" placeholder="<script>..</script>">{{old('footer_code',html_entity_decode($settings['footer_code']))}}</textarea>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Site Image </label> <br />
                      @if(!empty($settings['site_image']))
                        <img src="{{url($settings['site_image'])}}" class="bg-dark" height="32">@endif
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroupFileAddon03">Change Image </span>
                        </div>
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="site_image" id="inputGroupFile03" aria-describedby="inputGroupFileAddon03">
                          <label class="custom-file-label" for="inputGroupFile03">Choose file </label>
                        </div>
                      </div>
                      <small class="text-muted">Only png, jpg files are allowed, Max File Size: 200kb </small>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                  <form class="eco_form" method="post">
                    @csrf
                    <input type="hidden" name="type" value="comments">
                    <div class="form-group">
                      <label>Custom Comments(on/off) </label> <br />
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="custom_comments1" name="custom_comments" value="1" @if($settings['custom_comments'] == 1) checked @endif>
                        <label class="custom-control-label" for="custom_comments1">On </label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="custom_comments0" name="custom_comments" value="0" @if($settings['custom_comments'] == 0) checked @endif>
                        <label class="custom-control-label" for="custom_comments0">Off </label>
                      </div>
                    </div>                    
                    <div class="form-group">
                      <label>Facebook Comments(on/off) </label> <br />
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="facebook_comments1" name="facebook_comments" value="1" @if($settings['facebook_comments'] == 1) checked @endif>
                        <label class="custom-control-label" for="facebook_comments1">On </label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="facebook_comments2" name="facebook_comments" value="0" @if($settings['facebook_comments'] == 0) checked @endif>
                        <label class="custom-control-label" for="facebook_comments2">Off </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Disqus Comments(on/off) </label> <br />
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="disqus1" name="disqus" value="1" @if($settings['disqus'] == 1) checked @endif>
                        <label class="custom-control-label" for="disqus1">On </label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="disqus0" name="disqus" value="0" @if($settings['disqus'] == 0) checked @endif>
                        <label class="custom-control-label" for="disqus0">Off </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Disqus Code </label>
                      <textarea class="form-control" name="disqus_code" rows="4">{!!old('disqus_code',html_entity_decode($settings['disqus_code']))!!}
                      </textarea> <small class="text-muted">Get disqus code from
                        <a href="https://disqus.com" target="_blank">here </a>. </small></div>
                    <div class="form-group mb-4">
                      <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="captcha" role="tabpanel" aria-labelledby="captcha-tab">
                  <form class="eco_form" method="post">
                    <input type="hidden" name="type" value="captcha">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Captcha Type </label> <br />
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="captcha_type1" name="captcha_type" value="1" @if($settings['captcha_type'] == 1) checked @endif>
                            <label class="custom-control-label" for="captcha_type1">Invisible Recaptcha </label>
                          </div>
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="captcha_type0" name="captcha_type" value="2" @if($settings['captcha_type'] == 2) checked @endif>
                            <label class="custom-control-label" for="captcha_type0">Custom Captcha </label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Invisible Recaptcha(on/off) </label> <br />
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="captcha1" name="captcha" value="1" @if($settings['captcha'] == 1) checked @endif>
                            <label class="custom-control-label" for="captcha1">On </label>
                          </div>
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="captcha0" name="captcha" value="0" @if($settings['captcha'] == 0) checked @endif>
                            <label class="custom-control-label" for="captcha0">Off </label>
                          </div>
                          <p>
                            <small class="text-muted">How to get Invisible Recaptcha SiteKey & SecretKey?
                              <a class="blue-text" data-toggle="modal" data-target="#sideModal" data-backdrop="false">click here </a>
                            </small></p>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Custom Captcha Style </label>
                          @php $selected = old('custom_captcha_style',$settings['custom_captcha_style']); @endphp
                          <select class="form-control" name="custom_captcha_style">
                            <option value="default" @if($selected == 'default') selected @endif>Default</option>
                            <option value="math" @if($selected == 'math') selected @endif>Math</option>
                            <option value="flat" @if($selected == 'flat') selected @endif>Flat</option>
                            <option value="mini" @if($selected == 'mini') selected @endif>Mini</option>
                            <option value="inverse" @if($selected == 'inverse') selected @endif>Inverse</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Captcha For Verified Users </label> <br />
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="captcha_for_verified_users1" name="captcha_for_verified_users" value="1" @if($settings['captcha_for_verified_users'] == 1) checked @endif>
                            <label class="custom-control-label" for="captcha_for_verified_users1">Yes </label>
                          </div>
                          <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="captcha_for_verified_users0" name="captcha_for_verified_users" value="0" @if($settings['captcha_for_verified_users'] == 0) checked @endif>
                            <label class="custom-control-label" for="captcha_for_verified_users0">No </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Invisible Recaptcha SiteKey </label>
                          <input type="text" class="form-control" name="captcha_site_key" placeholder="XXXXXXXXXXXXXXXXXXXXXXXXX" value="{{old('captcha_site_key',$settings['captcha_site_key'])}}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Invisible Recaptcha SecretKey </label>
                          <input type="text" class="form-control" name="captcha_secret_key" placeholder="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX" value="{{old('captcha_secret_key',$settings['captcha_secret_key'])}}">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="social_auth" role="tabpanel" aria-labelledby="social_auth-tab">
                  <form class="eco_form" method="post">
                    @csrf
                    <input type="hidden" name="type" value="social_auth">
                    <div class="form-group">
                      <label>Facebook App ID</label>
                      <input type="text" name="facebook_app_id" class="form-control" placeholder="XXXXXXXXXXXXXXXXXX" value="{{old('facebook_app_id',$settings['facebook_app_id'])}}">
                    </div>
                    <div class="form-group">
                      <label>Login With Facebook </label> <br />
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="social_login_facebook1" name="social_login_facebook" value="1" @if($settings['social_login_facebook'] == 1) checked @endif>
                        <label class="custom-control-label" for="social_login_facebook1">On </label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="social_login_facebook2" name="social_login_facebook" value="0" @if($settings['social_login_facebook'] == 0) checked @endif>
                        <label class="custom-control-label" for="social_login_facebook2">Off </label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>FACEBOOK CLIENT ID </label>
                          <input type="text" class="form-control" name="FACEBOOK_CLIENT_ID" placeholder="XXXXXXXXXXXXXXXXXX" value="{{old('FACEBOOK_CLIENT_ID',$settings['FACEBOOK_CLIENT_ID'])}}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>FACEBOOK CLIENT SECRET </label>
                          <input type="text" class="form-control" name="FACEBOOK_CLIENT_SECRET" placeholder="XXXXXXXXXXXXXXXXXX" value="{{old('FACEBOOK_CLIENT_SECRET',$settings['FACEBOOK_CLIENT_SECRET'])}}">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Login With Twiiter </label> <br />
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="social_login_twitter1" name="social_login_twitter" value="1" @if($settings['social_login_twitter'] == 1) checked @endif>
                        <label class="custom-control-label" for="social_login_twitter1">On </label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="social_login_twitter2" name="social_login_twitter" value="0" @if($settings['social_login_twitter'] == 0) checked @endif>
                        <label class="custom-control-label" for="social_login_twitter2">Off </label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>TWITTER CLIENT ID </label>
                          <input type="text" class="form-control" name="TWITTER_CLIENT_ID" placeholder="XXXXXXXXXXXXXXXXXX" value="{{old('TWITTER_CLIENT_ID',$settings['TWITTER_CLIENT_ID'])}}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>TWITTER CLIENT SECRET </label>
                          <input type="text" class="form-control" name="TWITTER_CLIENT_SECRET" placeholder="XXXXXXXXXXXXXXXXXX" value="{{old('TWITTER_CLIENT_SECRET',$settings['TWITTER_CLIENT_SECRET'])}}">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Login With Google </label> <br />
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="social_login_google1" name="social_login_google" value="1" @if($settings['social_login_google'] == 1) checked @endif>
                        <label class="custom-control-label" for="social_login_google1">On </label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="social_login_google2" name="social_login_google" value="0" @if($settings['social_login_google'] == 0) checked @endif>
                        <label class="custom-control-label" for="social_login_google2">Off </label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>GOOGLE CLIENT ID </label>
                          <input type="text" class="form-control" name="GOOGLE_CLIENT_ID" placeholder="XXXXXXXXXXXXXXXXXX" value="{{old('GOOGLE_CLIENT_ID',$settings['GOOGLE_CLIENT_ID'])}}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>GOOGLE CLIENT SECRET </label>
                          <input type="text" class="form-control" name="GOOGLE_CLIENT_SECRET" placeholder="XXXXXXXXXXXXXXXXXX" value="{{old('GOOGLE_CLIENT_SECRET',$settings['GOOGLE_CLIENT_SECRET'])}}">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="mail" role="tabpanel" aria-labelledby="mail-tab">
                  <form class="eco_form" method="post">
                    <input type="hidden" name="type" value="mail">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Mail Driver* </label>
                          @php $selected = old('mail_driver',$settings['mail_driver']); @endphp
                          <select class="form-control" name="mail_driver">
                            <option value="mail" @if($selected == 'mail') selected @endif>mail</option>
                            <option value="smtp" @if($selected == 'smtp') selected @endif>smtp</option>
                            <option value="sendmail" @if($selected == 'sendmail') selected @endif>sendmail</option>
                            <option value="mailgun" @if($selected == 'mailgun') selected @endif>mailgun</option>
                            <option value="mandrill" @if($selected == 'mandrill') selected @endif>mandrill</option>
                            <option value="ses" @if($selected == 'ses') selected @endif>ses</option>
                            <option value="sparkpost" @if($selected == 'sparkpost') selected @endif>sparkpost</option>
                            <option value="log" @if($selected == 'log') selected @endif>log</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Mail Encryption </label>
                          <input type="text" class="form-control" name="mail_encryption" placeholder="ssl/tls" value="{{old('mail_encryption',$settings['mail_encryption'])}}">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Mail Host </label>
                          <input type="text" class="form-control" name="mail_host" placeholder="smtp.mail.io" value="{{old('mail_host',$settings['mail_host'])}}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Mail Port </label>
                          <input type="text" class="form-control" name="mail_port" placeholder="587" value="{{old('mail_port',$settings['mail_port'])}}">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Mail Username </label>
                          <input type="text" class="form-control" name="mail_username" value="{{old('mail_username',$settings['mail_username'])}}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Mail Password </label>
                          <input type="password" class="form-control" name="mail_password" value="{{old('mail_password',$settings['mail_password'])}}">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Mail From Address </label>
                          <input type="text" class="form-control" name="mail_from_address" placeholder="noreply@example.com" value="{{old('mail_from_address',$settings['mail_from_address'])}}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Mail From Name </label>
                          <input type="text" class="form-control" name="mail_from_name" placeholder="PasteShr" value="{{old('mail_from_name',$settings['mail_from_name'])}}">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                    </div>
                  </form>
                </div>
                <div class="tab-pane fade" id="social_links" role="tabpanel" aria-labelledby="social_links-tab">
                  <form class="eco_form" method="post">
                    <input type="hidden" name="type" value="social_links">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Facebook </label>
                          <input type="text" class="form-control" name="social_fb" placeholder="http://facebook.com/username" value="{{old('social_fb',$settings['social_fb'])}}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Twitter </label>
                          <input type="text" class="form-control" name="social_tw" placeholder="http://twitter.com/@username" value="{{old('social_tw',$settings['social_tw'])}}">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Youtube </label>
                          <input type="text" class="form-control" name="social_yt" placeholder="https://www.youtube.com/channel/XXXXXXXXXXXXXXXXXXXXXXXX" value="{{old('social_yt',$settings['social_yt'])}}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Whatsapp </label>
                          <input type="text" class="form-control" name="social_wapp" placeholder="https://wa.me/+923XXXXXXXXX" value="{{old('social_wapp',$settings['social_wapp'])}}">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Pinterest* </label>
                          <input type="text" class="form-control" name="social_pin" placeholder="http://pinterest.com/username" value="{{old('social_pin',$settings['social_pin'])}}">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Instagram* </label>
                          <input type="text" class="form-control" name="social_insta" placeholder="http://instagram.com/username" value="{{old('social_insta',$settings['social_insta'])}}">
                        </div>
                      </div>
                    </div>
					<div class="row">
					<div class="col-md-6">
                        <div class="form-group">
                          <label>LinkedIn </label>
                          <input type="text" class="form-control" name="social_lin" placeholder="https://linkedin.com/in/username/" value="{{old('social_lin',$settings['social_lin'])}}">
                        </div>
                      </div>
					  </div>
                    <div class="form-group">
                      <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Grid row-->
    </div>
  </main>
  <!--Main layout-->
  <!-- Side Modal Top Right-->
  <div class="modal fade right" id="sideModal" tabindex="-1" role="dialog"
      aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-side modal-top-right modal-notify modal-info" role="document">
      <!--Content-->
      <div class="modal-content">
        <!--Header-->
        <div class="modal-header">
          <p class="heading lead">Invisible Recaptcha </p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="white-text">&times; </span></button>
        </div>
        <!--Body-->
        <div class="modal-body">
          <div class="text-center">
            <p>1. Click on 'Get it now' button. </p>
            <p>2. Singup/Login & Click on My reCAPTCHA button. </p>
            <p>3. Enter Label Name, Select Invisible Recaptcha option & add your domain in domain list. </p>
            <img src="{{url('img/help1.jpg')}}" class="img-fluid">
            <p>4. Copy SiteKey & SecretKey. </p>
          </div>
        </div>
        <!--Footer-->
        <div class="modal-footer justify-content-center">
          <a role="button" class="btn btn-info" href="https://www.google.com/recaptcha" target="_blank">Get it now
            <i class="fa fa-diamond ml-1"> </i> </a>
          <a role="button" class="btn btn-outline-info waves-effect" data-dismiss="modal">No, thanks </a>
        </div>
      </div>
      <!--/.Content-->
    </div>
  </div>
  <!-- Side Modal Top Right Success-->
@stop

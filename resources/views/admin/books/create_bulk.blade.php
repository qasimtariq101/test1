@extends('admin.layouts.default')

@section('content') 
<!--Main layout-->
<main class="pt-5 mx-lg-5">
  <div class="container mt-5"> 
    
    <!-- Heading -->
    <div class="card mb-4 "> 
      
      <!--Card content-->
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1"> <a href="{{url('admin/dashboard')}}">{{ __('Admin')}}</a> <span>/</span> <a href="{{url('admin/books')}}">{{$page_title}}</a> <span>/</span> <span>{{ __('Bulk Create')}}</span> </h4>
      </div>
    </div>
    <!-- Heading --> 
    
    <!--Grid row-->
    <div class="row "> 
      
      <!--Grid column-->
      <div class="col-md-12 mb-4"> @include('admin.includes.messages') 
        <!--Card-->
        <div class="card mb-4"> 
          
          <!-- Card header -->
          <div class="card-header"> {{$page_title}} {{ __('Bulk Create')}} </div>
          
          <!--Card content-->
          <div class="card-body">
            <form class="eco_form" method="post" action="{{ route('books.create_bulk') }}" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ __('eBooks')}}</label>
                    <div class="input-group">
                      <div class="input-group-prepend"> <span class="input-group-text" id="inputGroupFileAddon01">{{ __('eBooks')}}</span> </div>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="ebooks[]" multiple id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose multiple files')}}</label>
                      </div>
                    </div>
                    <small>{{ __('Only')}} {{str_replace(',', ', ', config('settings.allowed_book_mimes'))}} {{ __('files are allowed')}}. {{ __('Max')}} {{config('settings.max_book_upload_size')}}{{ __('MB')}}</small> </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ __('Thumbnail')}}</label>
                    <div class="input-group">
                      <div class="input-group-prepend"> <span class="input-group-text" id="inputGroupFileAddon02">{{ __('Thumbnail')}}</span> </div>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="thumbnail" id="inputGroupFile02" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file')}}</label>
                      </div>
                    </div>
                    <small>{{ __('Only jpg png files are allowed')}}. {{ __('Max')}} {{config('settings.max_thumbnail_upload_size')}}{{ __('MB')}}</small> </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ __('Title')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    <input type="text" name="title" class="form-control" placeholder="{{ __('Title')}}" value="{{old('title')}}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ __('Category')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    @php $selected = old('category_id'); @endphp
                    <select class="form-control" name="category_id">
                      
                              @foreach($categories as $category)
                                                                
                                <option value="{{$category->id}}" @if($selected == $category->id) selected @endif @if($category->sub_categories->count() > 0) style="font-weight:bold;" @endif>{{$category->name}}</option>

                                @if($category->sub_categories->count() > 0)
                                  @foreach($category->sub_categories as $sc)
                                  @php if($sc->active != 1) continue; @endphp
                                     <option value="{{$sc->id}}" @if($selected == $sc->id) selected @endif>&nbsp;&nbsp;  -  {{$sc->name}}</option>
                                  @endforeach
                                @endif
                                
                              @endforeach
                      
                      </option>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>{{ __('Author Name') }} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    <input type="text" name="author_name" class="form-control" placeholder="{{ __('Author Name') }}" value="{{ old('author_name') }}">
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>{{ __('Overview')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    <textarea name="overview" class="form-control" placeholder="{{ __('Write something about your book')}}">{{old('overview')}}</textarea>
                    <small>{{ __('Allowed Tags') }} : {{ config('settings.book_overview_allowed_tags') }}</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ __('Status')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    @php $selected = old('status'); @endphp
                    <select class="form-control" name="status">
                      <option value="1" @if($selected == 1) selected @endif>{{ __('Public')}}</option>
                      <option value="2" @if($selected == 2) selected @endif>{{ __('Unlisted')}}</option>
                      <option value="3" @if(!Auth::check()) disabled @else  @if($selected == 3) selected @endif @endif>
                      
                      {{ __('Private')}} ({{ __('members only')}})
                      
                      </option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ __('Password')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    <input type="text" name="password" class="form-control" placeholder="{{ __('Password')}}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ __('Featured')}}</label>
                    @php $selected = old('featured'); @endphp
                    <select name="featured" class="form-control">
                      <option value="0" @if($selected == 0) selected @endif>{{ __('No')}}</option>
                      <option value="1" @if($selected == 1) selected @endif>{{ __('Yes')}}</option>
                    </select>
                  </div>
                </div>                
                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ __('Active')}}</label>
                    @php $selected = old('active',1); @endphp
                    <select name="active" class="form-control">
                      <option value="0" @if($selected == 0) selected @endif>{{ __('No')}}</option>
                      <option value="1" @if($selected == 1) selected @endif>{{ __('Yes')}}</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>{{ __('Tags')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
                    <textarea name="tags" class="form-control" placeholder="{{ __('tags separated by comma')}}">{{old('tags')}}</textarea>
                  </div>
                </div> 

                <div class="col-md-12 mb-2 progress-container d-none">
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                  </div>  
                </div>
                               
                <div class="col-md-12">
                  <div class="form-group">
                    <button type="submit" class="btn btn-success">{{ __('Save')}}</button>
                    <a href="{{url('admin/books')}}" class="btn btn-default">{{ __('Cancel')}}</a> </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!--/.Card--> 
        
      </div>
      <!--Grid column--> 
      
    </div>
    <!--Grid row--> 
    
  </div>
</main>
<!--Main layout--> 
@stop
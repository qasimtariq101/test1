@extends('admin.layouts.default')

@section('content') 
<!--Main layout-->
<main class="pt-5 mx-lg-5">
  <div class="container mt-5"> 
    
    <!-- Heading -->
    <div class="card mb-4 "> 
      
      <!--Card content-->
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1"> 
          <a href="{{url('admin/dashboard')}}">{{ __('Admin')}}</a> <span>/</span> 
          <a href="{{url('admin/categories')}}">{{$page_title}}</a> <span>/</span> 
          <a href="{{$category->url}}" target="_blank">{{$category->name}}</a> <span>/</span> 
          <span>{{ __('Edit')}}</span> 
        </h4>
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
          <div class="card-header"> {{$page_title}} {{ __('Edit')}} </div>
          
          <!--Card content-->
          <div class="card-body">
            <form class="eco_form" method="post">
              @csrf
              <div class="form-group col-md-6">
                <label>{{ __('Parent')}}</label>
                @php
                $selected = old('parent_id',$category->parent_id);
                @endphp
                <select class="form-control" name="parent">
                  <option value="">{{ __('Select')}}</option>
                  @foreach($categories as $c)
                  <option value="{{$c->id}}" @if($selected == $c->id) selected @endif>{{$c->name}}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group col-md-6">
                <label>{{ __('Name')}}</label>
                <input type="text" class="form-control" name="name" placeholder="{{ __('Category Name')}}" value="{{old('name',$category->name)}}">
              </div>
			  
			  <div class="form-group col-md-6">
                <label>{{ __('Category Description')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
				<textarea name="catgdesc" class="form-control" placeholder="{{ __('Write seo meta desciption of the category here')}}">{{old('catgdesc',$category->catgdesc)}}</textarea>
                <small>{{ __('Maximum 155 to 160 Characters should be used.') }}</small>
              </div>
			  
			  <div class="form-group col-md-6">
                <label>{{ __('Category Tags')}} : <small class="text-muted">[{{ __('Optional')}}]</small></label>
				<textarea name="catgtags" class="form-control" placeholder="{{ __('tags separated by comma')}}">{{old('catgtags',$category->catgtags)}}</textarea>
              </div>

              <div class="form-group col-md-6">
                <label>{{ __('Active')}}</label>
                @php
                $selected = old('active',$category->active);
                @endphp
                <select class="form-control" name="active">
                  <option value="1" @if($selected == 1) selected @endif>{{ __('Yes')}}</option>
                  <option value="0" @if($selected == 0) selected @endif>{{ __('No')}}</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <button class="btn btn-success" type="submit">{{ __('Save')}}</button>
                <a href="{{url('admin/categories')}}" class="btn btn-default">{{ __('Cancel')}}</a> </div>
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
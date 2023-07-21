@extends('admin.layouts.default')

@section('after_styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
.note-group-select-from-files {
  display: none;
}  
</style>
@stop

@section('after_scripts') 
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>
<script>
$(document).ready(function() {
  $('#editor').summernote({
    placeholder: $('#editor').attr('placeholder'),
    height: 300,   
  });
});
</script> 
@stop

@section('content') 
<!--Main layout-->
<main class="pt-5 mx-lg-5">
  <div class="container mt-5"> 
    
    <!-- Heading -->
    <div class="card mb-4"> 
      
      <!--Card content-->
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1"> <a href="{{url('admin/dashboard')}}">{{ __('Admin')}}</a> <span>/</span> <a href="{{url('admin/pages')}}">{{$page_title}}</a> <span>/</span> <span>{{ __('Create')}}</span> </h4>
      </div>
    </div>
    <!-- Heading --> 
    
    <!--Grid row-->
    <div class="row"> 
      
      <!--Grid column-->
      <div class="col-md-12 mb-4"> @include('admin.includes.messages') 
        <!--Card-->
        <div class="card mb-4"> 
          
          <!-- Card header -->
          <div class="card-header"> {{$page_title}} {{ __('Create')}} </div>
          
          <!--Card content-->
          <div class="card-body">
            <form class="eco_form" method="post">
              @csrf
              <div class="form-group">
                <label>{{ __('Title')}}</label>
                <input type="text" class="form-control" name="title" placeholder="{{ __('Page Title')}}" value="{{old('title')}}">
              </div>
              <div class="form-group">
                <label>{{ __('Content')}}</label>
                <textarea class="textarea form-control" id="editor" name="content" placeholder="{{ __('Page content')}}" rows="20">{{old('content')}}</textarea>
              </div>
              <div class="form-group">
                <label>{{ __('Active')}}</label>
                @php
                $selected = old('active');
                @endphp
                <select class="form-control" name="active">
                  <option value="1" @if($selected == 1) selected @endif>{{ __('Yes')}}</option>
                  <option value="0" @if($selected == 0) selected @endif>{{ __('No')}}</option>
                </select>
              </div>
              <div class="form-group">
                <button class="btn btn-success" type="submit">{{ __('Save')}}</button>
                <a href="{{url('admin/pages')}}" class="btn btn-default">{{ __('Cancel')}}</a> </div>
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
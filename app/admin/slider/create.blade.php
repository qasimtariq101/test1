@extends('admin.layouts.default')

@section('content') 
<!--Main layout-->
<main class="pt-5 mx-lg-5">
  <div class="container mt-5"> 
    
    <!-- Heading -->
    <div class="card mb-4"> 
      
      <!--Card content-->
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1"> <a href="{{url('admin/dashboard')}}">{{ __('Admin')}}</a> <span>/</span> <a href="{{url('admin/slider')}}">{{$page_title}}</a> <span>/</span> <span>{{ __('Create')}}</span> </h4>
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
            <form class="eco_form" method="post" enctype="multipart/form-data">
              @csrf

              <div class="form-group col-md-6">
                <label>{{ __('Name')}}</label>
                <input type="text" class="form-control" name="name" placeholder="{{ __('Name')}}" value="{{old('name')}}">
              </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>{{ __('Image')}}</label>
                    <div class="input-group">
                      <div class="input-group-prepend"> <span class="input-group-text" id="inputGroupFileAddon02">{{ __('Image')}}</span> </div>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image" id="inputGroupFile02" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file')}}</label>
                      </div>
                    </div>
                    <small>{{ __('Only jpg files are allowed')}}. 1170x500 {{ __('Recommended') }}</small> </div>
                </div>


              <div class="form-group col-md-6">
                <label>{{ __('Active')}}</label>
                @php
                $selected = old('active');
                @endphp
                <select class="form-control" name="active">
                  <option value="1" @if($selected == 1) selected @endif>{{ __('Yes')}}</option>
                  <option value="0" @if($selected == 0) selected @endif>{{ __('No')}}</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <button class="btn btn-success" type="submit">{{ __('Save')}}</button>
                <a href="{{url('admin/slider')}}" class="btn btn-default">{{ __('Cancel')}}</a> </div>
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
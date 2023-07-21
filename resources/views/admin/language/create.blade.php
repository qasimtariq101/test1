@extends('admin.layouts.default')

@section('content') 
<!--Main layout-->
<main class="pt-5 mx-lg-5">
  <div class="container mt-5"> 
    
    <!-- Heading -->
    <div class="card mb-4"> 
      
      <!--Card content-->
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1"> <a href="{{url('admin/dashboard')}}">{{ __('Admin')}}</a> <span>/</span> <a href="{{url('admin/site-languages')}}">{{$page_title}}</a> <span>/</span> <span>{{ __('Create')}}</span> </h4>
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
                <label>{{ __('Name')}}</label>
                <input type="text" class="form-control" name="name" placeholder="{{ __('Language Name')}}" value="{{old('name')}}">
              </div>
                          
              <div class="form-group">
                <label>{{ __('Language Code')}}</label>
                <input type="text" class="form-control" name="code" placeholder="en" value="{{old('code')}}">
              </div>

              <div class="form-group">
                <label>{{ __('Site Layout') }} </label> <br />
                @php $selected = old('site_layout') @endphp
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="site_layout1" name="site_layout" value="ltr" @if($selected == 'ltr') checked @endif>
                  <label class="custom-control-label" for="site_layout1">LTR (Left-to-Right) </label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" class="custom-control-input" id="site_layout2" name="site_layout" value="rtl" @if($selected == 'rtl') checked @endif>
                  <label class="custom-control-label" for="site_layout2">RTL (Right-to-Left) </label>
                </div>
              </div>
            
              <div class="form-group">
                <button class="btn btn-success" type="submit">{{ __('Save')}}</button>
                <a href="{{url('admin/site-languages')}}" class="btn btn-default">{{ __('Cancel')}}</a> </div>
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
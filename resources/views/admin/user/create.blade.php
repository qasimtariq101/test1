@extends('admin.layouts.default')

@section('after_scripts') 
<script type="text/javascript">
function loadFile(event, id){
    // alert(event.files[0]);
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById(id);
      output.src = reader.result;
       //$("#imagePreview").css("background-image", "url("+this.result+")");
    };
    reader.readAsDataURL(event.files[0]);
} 

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
        <h4 class="mb-2 mb-sm-0 pt-1"> <a href="{{url('admin/dashboard')}}">{{ __('Admin')}}</a> <span>/</span> <a href="{{url('admin/users')}}">{{$page_title}}</a> <span>/</span> <span>{{ __('Create')}}</span> </h4>
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
              <div class="row">
                 <div class="form-group col-md-6">
                <label>{{ __('Username')}}*</label>
                <input type="text" class="form-control" name="username" placeholder="{{ __('Userame')}}" value="{{old('username')}}" >
              </div>
              <div class="form-group col-md-6">
                <label>{{ __('Email')}}*</label>
                <input type="email" class="form-control" name="email" placeholder="{{ __('Email')}}" value="{{old('email')}}" >
              </div> 

              </div>

              <div class="row">
                           <div class="form-group col-md-6">
                <label>{{ __('Role')}}*</label>
                @php $selected = old('role'); @endphp
                <select class="form-control" name="role">
                  <option value="2" @if($selected == '2') selected @endif>{{ __('Registered User')}}</option>
                  <option value="1" @if($selected == '1') selected @endif>{{ __('Administrator')}}</option>
                </select>
              </div>   
                              <div class="form-group col-md-6">
                <label>{{ __('Status')}}*</label>
                @php $selected = old('status'); @endphp
                <select class="form-control" name="status">
                  <option value="1" @if($selected == '1') selected @endif>{{ __('Active')}}</option>
                  <option value="0" @if($selected == '0') selected @endif>{{ __('Inactive')}}</option>
                  <option value="2" @if($selected == '2') selected @endif>{{ __('Banned')}}</option>
                </select>
              </div>

              </div>


              <div class="row">
                          <div class="form-group col-md-6">
                <label>{{ __('Avatar')}}</label>
                <br/>
                <img src="{{url('img/default-avatar.png')}}" id="avatar" class="rounded-circle z-depth-1-half avatar-pic mb-3" height="80" width="80">
                <div class="input-group mb-4">
                  <div class="input-group-prepend"> <span class="input-group-text" id="inputGroupFileAddon01">{{ __('Upload')}}</span> </div>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="avatar" id="inputGroupFile01" onchange="loadFile(this,'avatar')" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file')}} ({{ __('jpg-png')}}), {{ __('Max')}} 1MB</label>
                  </div>
                </div>
              </div>
    
              <div class="form-group col-md-6">
                <label>{{ __('About Me')}}*</label>
                <textarea class="form-control" name="about" rows="5">{{old('about')}}</textarea>
              </div> 

              </div>

              <div class="row">
                <div class="form-group col-md-4">
                <label>{{ __('Facebook Link')}}*</label>
                <input type="text" class="form-control" name="fb" placeholder="#" value="{{old('fb')}}" >
              </div>
              <div class="form-group col-md-4">
                <label>{{ __('Twitter Link')}}*</label>
                <input type="text" class="form-control" name="tw" placeholder="#" value="{{old('tw')}}" >
              </div>
              <div class="form-group col-md-4">
                <label>{{ __('Google Plus Link')}}*</label>
                <input type="text" class="form-control" name="gp" placeholder="#" value="{{old('gp')}}" >
              </div>              

              </div>

 
              <div class="row">
                   <div class="form-group col-md-6">
                <label>{{ __('Password')}}</label>
                <input type="password" class="form-control" name="password" placeholder="Password">
              </div>
              <div class="form-group col-md-6">
                <label>{{ __('Confirm Password')}}</label>
                <input type="password" class="form-control" name="password_confirmation" placeholder="Password confirmation">
              </div>           

              </div>
  


              <div class="form-group">
                <button class="btn btn-success" type="submit">{{ __('Save')}}</button>
                <a href="{{url('admin/users')}}" class="btn btn-default">{{ __('Cancel')}}</a> 

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
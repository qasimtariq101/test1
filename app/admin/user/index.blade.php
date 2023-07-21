@extends('admin.layouts.default')

@section('after_styles')
<link rel="stylesheet" type="text/css" href="{{url('mdb/css/addons/datatables.min.css')}}">
<link rel="stylesheet" href="{{url('mdb/css/addons/responsive.dataTables.min.css')}}">
@stop

@section('after_scripts') 
<script type="text/javascript" src="{{url('mdb/js/addons/datatables.min.js')}}"></script> 
<script src="{{url('mdb/js/addons/dataTables.responsive.min.js')}}"></script> 
<script>
$(function () {

    table =  $('#example1').DataTable({
      /*  order: [[ 0, 'desc' ]],*/
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[ 0, 'desc' ]],            
        ajax: '{{route("users.get")}}',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'role', name: 'role',orderable:false},
            {data: 'status', name: 'status',orderable:false},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable:false, searchable:false}
        ]
    });

});
</script> 
@stop


@section('content') 
<!--Main layout-->
<main class="pt-5 mx-lg-5">
  <div class="container mt-5"> 
    
    <!-- Heading -->
    <div class="card mb-4 "> 
      
      <!--Card content-->
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1"> <a href="{{url('admin/dashboard')}}">{{ __('Admin')}}</a> <span>/</span> <span>{{$page_title}}</span> </h4>
        <a href="{{url('admin/users/create')}}" class="btn btn-sm btn-primary">{{ __('Create')}}</a> </div>
    </div>
    <!-- Heading --> 
    
    <!--Grid row-->
    <div class="row "> 
      
      <!--Grid column-->
      <div class="col-md-12 mb-4"> @include('admin.includes.messages') 
        <!--Card-->
        <div class="card mb-4"> 
          
          <!-- Card header -->
          <div class="card-header"> {{$page_title}} </div>
          
          <!--Card content-->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>{{ __('ID')}}</th>
                  <th>{{ __('Username')}}</th>
                  <th>{{ __('Email')}}</th>
                  <th>{{ __('Role')}}</th>
                  <th>{{ __('Status')}}</th>
                  <th>{{ __('Created at')}}</th>
                  <th>{{ __('Action')}}</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <tr>
                  <th>{{ __('ID')}}</th>
                  <th>{{ __('Username')}}</th>
                  <th>{{ __('Email')}}</th>
                  <th>{{ __('Role')}}</th>
                  <th>{{ __('Status')}}</th>
                  <th>{{ __('Created at')}}</th>
                  <th>{{ __('Action')}}</th>
                </tr>
              </tfoot>
            </table>
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
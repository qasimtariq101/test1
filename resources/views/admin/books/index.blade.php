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
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[ 1, 'desc' ]],
        ajax: '{{route("books.get")}}',
        columns: [
            {data: 'check', name: 'id', orderable:false, searchable:false},
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'category', name: 'category_id'},
            {data: 'user', name: 'user_id',orderable:false, searchable:false},
            {data: 'status', name: 'status'},
            {data: 'password_protected', name: 'password'},
            {data: 'average_rating', name: 'average_rating'},
            {data: 'views', name: 'views'},
            {data: 'downloads', name: 'downloads'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable:false, searchable:false}
        ],       
    });


$("#check_all").on('click',function(){
    if($('#check_all').is(':checked')){
      $('.check').prop('checked',true);
    }
    else{
      $('.check').prop('checked',false);
    }
});


$('.del_selected').on('click',function(){
  var url = "{{route('books.delete_selected')}}";
  var data = { 'ids[]' : []};
  $(".check:checked").each(function() {
      data['ids[]'].push($(this).val());
    });
  $.ajax({
    url: url,
    type: 'POST',
    data : data,
  })
  .done(function(data) {
    if(data == 'success'){
      $("#response").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>{{ __("Items successfully deleted")}}.</div>');
      table.ajax.reload();
      $('#check_all').prop('checked',false);
    }
    else{
      $("#response").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>{{ __("No items selected")}}.</div>');
    }
  });
});





});
</script> 
@stop


@section('content') 
<!--Main layout-->
<main class="pt-5 mx-lg-5">
  <div class="container-fluid mt-5"> 
    
    <!-- Heading -->
    <div class="card mb-4 "> 
      
      <!--Card content-->
      <div class="card-body d-sm-flex justify-content-between">
        <h4 class="mb-2 mb-sm-0 pt-1"> <a href="{{url('admin/dashboard')}}">{{ __('Admin')}}</a> <span>/</span> <span>{{$page_title}}</span> </h4>
        <div>
          <a href="{{url('admin/books/bulk-create')}}" class="btn btn-sm btn-warning">{{ __('Bulk Create')}}</a> 
          <a href="{{url('admin/books/create')}}" class="btn btn-sm btn-primary">{{ __('Create')}}</a> 
        </div>
      </div>
    </div>
    <!-- Heading --> 
    
    <!--Grid row-->
    <div class="row "> 
      
      <!--Grid column-->
      <div class="col-md-12 mb-4"> @include('admin.includes.messages')
        <div id="response"></div>
        <!--Card-->
        <div class="card mb-4"> 
          
          <!-- Card header -->
          <div class="card-header">
            <h4 class="float-left"> {{$page_title}}</h4>
            
            <!-- Basic dropdown -->
            <button class="btn btn-primary btn-sm dropdown-toggle mr-4 float-right" type="button" data-toggle="dropdown" aria-haspopup="true"
    aria-expanded="false">{{ __('Action')}}</button>
            <div class="dropdown-menu"> <a class="dropdown-item del_selected"><i class="fa fa-trash"></i> {{ __('Delete Selected')}}</a> </div>
            <!-- Basic dropdown --> 
            
          </div>
          
          <!--Card content-->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th><input type="checkbox" id="check_all" class="check_all"></th>
                  <th>{{ __('ID')}}</th>
                  <th>{{ __('Title')}}</th>
                  <th>{{ __('Category')}}</th>
                  <th>{{ __('User')}}</th>
                  <th>{{ __('Status')}}</th>
                  <th>{{ __('Password Protected')}}</th>
                  <th>{{ __('Average Rating')}}</th>
                  <th>{{ __('Views')}}</th>
                  <th>{{ __('Downloads')}}</th>
                  <th>{{ __('Created at')}}</th>
                  <th>{{ __('Action')}}</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>{{ __('ID')}}</th>
                  <th>{{ __('Title')}}</th>
                  <th>{{ __('Category')}}</th>
                  <th>{{ __('User')}}</th>
                  <th>{{ __('Status')}}</th>
                  <th>{{ __('Password Protected')}}</th>
                  <th>{{ __('Average Rating')}}</th>
                  <th>{{ __('Views')}}</th>
                  <th>{{ __('Downloads')}}</th>
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
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
    table = $('#menu-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, 'desc']],
        ajax: '{{ route("menus.get") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'is_default', name: 'is_default' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@stop

@section('content')
<!-- Main layout -->
<main class="pt-5 mx-lg-5">
    <div class="container mt-5">

        <!-- Heading -->
        <div class="card mb-4">
            <!-- Card content -->
            <div class="card-body d-sm-flex justify-content-between">
                <h4 class="mb-2 mb-sm-0 pt-1">
                    <a href="{{ url('admin/dashboard') }}">{{ __('Admin') }}</a> <span>/</span> <span>{{ __('Menus') }}</span>
                </h4>
                <a href="{{ route('menus.create') }}" class="btn btn-sm btn-primary">{{ __('Create Menu') }}</a>
            </div>
        </div>
        <!-- Heading -->

        <!-- Grid row -->
        <div class="row">
            <!-- Grid column -->
            <div class="col-md-12 mb-4">
                @include('admin.includes.messages')

                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card content -->
                    <div class="card-body">
                        <table id="menu-table" class="table table-bordered table-striped responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Default') }}</th>
                                    <th>{{ __('Created at') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Default') }}</th>
                                    <th>{{ __('Created at') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- Card -->
            </div>
            <!-- Grid column -->
        </div>
        <!-- Grid row -->
    </div>
</main>
<!-- Main layout -->
@endsection

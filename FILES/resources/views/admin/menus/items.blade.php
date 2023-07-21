@extends('admin.layouts.default')

@section('after_styles')
<link rel="stylesheet" type="text/css" href="{{ url('mdb/css/addons/datatables.min.css') }}">
<link rel="stylesheet" href="{{ url('mdb/css/addons/responsive.dataTables.min.css') }}">
@stop

@section('after_scripts')
<script type="text/javascript" src="{{ url('mdb/js/addons/datatables.min.js') }}"></script>
<script src="{{ url('mdb/js/addons/dataTables.responsive.min.js') }}"></script>
<script>
$(function () {
    table = $('#menu-items-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, 'desc']],
        ajax: '{{ route("menus.items.get", $menu->id) }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'item_name', name: 'item_name' },
            { data: 'item_link', name: 'item_link' },
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
                    <a href="{{ url('admin/dashboard') }}">{{ __('Admin') }}</a> <span>/</span> <a href="{{ route('menus.index') }}">{{ __('Menus') }}</a> <span>/</span> <a href="{{ route('menus.show', $menu->id) }}">{{ __('Menu Details') }}</a> <span>/</span> <span>{{ __('Menu Items') }}</span>
                </h4>
                <a href="{{ route('menus.create-item', $menu->id) }}" class="btn btn-sm btn-primary">{{ __('Create Menu Item') }}</a>
            </div>
        </div>
        <!-- Heading -->

        <!-- Grid row -->
        <div class="row">
            <!-- Grid column -->
            <div class="col-md-12 mb-4">

                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card content -->
                    <div class="card-body">
                        <table id="menu-items-table" class="table table-bordered table-striped responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Item Name') }}</th>
                                    <th>{{ __('Item Link') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Item Name') }}</th>
                                    <th>{{ __('Item Link') }}</th>
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

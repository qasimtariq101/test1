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
        table = $('#example1').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [[0, 'desc']],
            ajax: '{{ route("menus.get") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
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
        <div class="card mb-4">
            <!--Card content-->
            <div class="card-body d-sm-flex justify-content-between">
                <h4 class="mb-2 mb-sm-0 pt-1">
                    <a href="{{ url('admin/dashboard') }}">{{ __('Admin') }}</a>
                    <span>/</span>
                    <a href="{{ route('menus.index') }}">{{ __('Menus') }}</a>
                    <span>/</span>
                    <span>{{ __('Menu Items for') }} {{ $menu->name }}</span>
                </h4>
                <a href="{{ route('menus.create-item', $menu->id) }}"
                    class="btn btn-sm btn-primary">{{ __('Add New Item') }}</a>
            </div>
        </div>
        <!-- Heading -->

        <!--Grid row-->
        <div class="row">
            <!--Grid column-->
            <div class="col-md-12 mb-4">
                @include('admin.includes.messages')

                <!--Card-->
                <div class="card mb-4">
                    <!-- Card header -->
                    <div class="card-header">{{ __('Menu Items for') }} {{ $menu->name }}</div>

                    <!--Card content-->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped responsive nowrap" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('URL') }}</th>
                                    <th>{{ __('Parent') }}</th>
                                    <th>{{ __('Order') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menu->menuItems as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->url }}</td>
                                        <td>{{ $item->parent ? $item->parent->title : '-' }}</td>
                                        <td>{{ $item->order }}</td>
                                        <td>
                                            <a href="{{ route('menus.edit-item', [$menu->id, $item->id]) }}"
                                                class="btn btn-sm btn-success">{{ __('Edit') }}</a>
                                            <a href="{{ route('menus.destroy-item', [$menu->id, $item->id]) }}"
                                                class="btn btn-sm btn-danger"
                                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id }}').submit();">{{ __('Delete') }}</a>
                                            <form id="delete-form-{{ $item->id }}"
                                                action="{{ route('menus.destroy-item', [$menu->id, $item->id]) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
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
@endsection

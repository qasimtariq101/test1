@extends('admin.layouts.default')

@section('content')
<!-- Main layout -->
<main class="pt-5 mx-lg-5">
    <div class="container mt-5">

        <!-- Heading -->
        <div class="card mb-4">
            <!-- Card content -->
            <div class="card-body d-sm-flex justify-content-between">
                <h4 class="mb-2 mb-sm-0 pt-1">
                    <a href="{{ url('admin/dashboard') }}">{{ __('Admin') }}</a> <span>/</span> <span>{{ __('Menu Details') }}</span>
                </h4>
                <div class="d-flex">
                    <a href="{{ route('menus.index') }}" class="btn btn-sm btn-primary mr-3">{{ __('Back to Menu List') }}</a>
                    <form action="{{ route('menus.destroy', $menu->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('Are you sure you want to delete this menu?') }}')">{{ __('Delete Menu') }}</button>
                    </form>
                    <a href="{{ route('menus.items', $menu->id) }}" class="btn btn-sm btn-primary ml-3">{{ __('Add/Update Items') }}</a>
                </div>
            </div>
        </div>
        <!-- Heading -->

        <!-- Grid row -->
        <div class="row">
            <!-- Grid column -->
            <div class="col-md-12 mb-4">

                <!-- Card -->
                <div class="card mb-4">
                    <!-- Card header -->
                    <div class="card-header">{{ __('Menu Details') }}</div>

                    <!-- Card content -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 font-weight-bold">{{ __('Menu Name') }}:</div>
                            <div class="col-md-8">{{ $menu->name }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Default Menu') }}:</div>
                            <div class="col-md-8">{{ $menu->is_default ? __('Yes') : __('No') }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4 font-weight-bold">{{ __('Created at') }}:</div>
                            <div class="col-md-8">{{ $menu->created_at }}</div>
                        </div>

                        <!-- Add/Update Items Button -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{ route('menus.items', $menu->id) }}" class="btn btn-primary">{{ __('Add/Update Items') }}</a>
                            </div>
                        </div>
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
@stop

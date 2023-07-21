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
                    <a href="{{ url('admin/dashboard') }}">{{ __('Admin') }}</a> <span>/</span> <span>{{ __('Create Menu') }}</span>
                </h4>
                <a href="{{ url('admin/menus') }}" class="btn btn-sm btn-primary">{{ __('Back to Menu List') }}</a>
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

                    <!-- Card header -->
                    <div class="card-header">{{ __('Create Menu') }}</div>

                    <!-- Card content -->
                    <div class="card-body">
                        <form action="{{ route('menus.store') }}" method="post">
                            @csrf

                            <!-- Name input -->
                            <div class="md-form md-outline">
                                <input type="text" id="name" name="name" class="form-control" required>
                                <label for="name">{{ __('Menu Name') }}</label>
                            </div>

                            <!-- Default checkbox -->
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_default" name="is_default" value="1">
                                <label class="form-check-label" for="is_default">{{ __('Default Menu') }}</label>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary">{{ __('Create Menu') }}</button>
                        </form>
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

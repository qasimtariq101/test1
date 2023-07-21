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
                    <a href="{{ url('admin/dashboard') }}">{{ __('Admin') }}</a> <span>/</span> <a href="{{ route('menus.index') }}">{{ __('Menus') }}</a> <span>/</span> <a href="{{ route('menus.show', $menu->id) }}">{{ __('Menu Details') }}</a> <span>/</span> <span>{{ __('Edit Menu Item') }}</span>
                </h4>
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
                        <form action="{{ route('menus.items.update', [$menu->id, $item->id]) }}" method="post">
                            @csrf
                            @method('PUT')

                            <!-- Item Name input -->
                            <div class="md-form md-outline">
                                <input type="text" id="item_name" name="item_name" class="form-control" value="{{ $item->item_name }}" required>
                                <label for="item_name">{{ __('Item Name') }}</label>
                            </div>

                            <!-- Item Link input -->
                            <div class="md-form md-outline">
                                <input type="text" id="item_link" name="item_link" class="form-control" value="{{ $item->item_link }}" required>
                                <label for="item_link">{{ __('Item Link') }}</label>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary">{{ __('Update Menu Item') }}</button>
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
@endsection

@extends('admin.layouts.default')

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
                    <a href="{{ route('menus.show', $menu->id) }}">{{ __('Menu Items for') }} {{ $menu->name }}</a>
                    <span>/</span>
                    <span>{{ __('Add New Item') }}</span>
                </h4>
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
                    <div class="card-header">{{ __('Add New Menu Item') }}</div>

                    <!--Card content-->
                    <div class="card-body">
                        <form action="{{ route('menus.store-item', $menu->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">{{ __('Title') }}</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="url">{{ __('URL') }}</label>
                                <input type="text" name="url" id="url" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="parent">{{ __('Parent') }}</label>
                                <select name="parent" id="parent" class="form-control">
                                    <option value="0">{{ __('No Parent') }}</option>
                                    @foreach ($menu->menuItems as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="order">{{ __('Order') }}</label>
                                <input type="number" name="order" id="order" class="form-control" value="1" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ __('Add Item') }}</button>
                                <a href="{{ route('menus.show', $menu->id) }}"
                                    class="btn btn-default">{{ __('Cancel') }}</a>
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
@endsection

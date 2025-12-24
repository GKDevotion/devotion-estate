@extends('backend.layouts.master')

@section('title')
    Properties Image Page
@endsection

@section('styles')

@endsection


@section('admin-content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-sm-7">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left d-none">Properties </h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><span>All Properties </span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 text-end">
                @if (Auth::guard('admin')->user()->can('properties.create'))
                    <a class="btn btn-add text-white" href="{{ route('admin.properties.create') }}">
                        <i class="fa fa-plus"></i> Properties
                    </a>
                @endif

                <a href="{{ route('admin.properties.index') }}" class="btn btn-danger">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="col-md-2 clearfix">
                @include('backend.layouts.partials.logout')
            </div>
        </div>
    </div>
    <!-- page title area end -->

    <div class="main-content-inner">
        <div class="row">
            <!-- data table start -->
            <div class="col-12">
                <div class="card p-4">
                    <h3 class="pb-3">Properties Image History</h3>
                    <form action="{{ route('admin.properties.imageOrder.update', $id) }}" method="POST">
                        @csrf
                        <div class="row">
                            @foreach($imageArr as $image)
                                <div class="col-3 mb-3">
                                    <div class="row">
                                        <div class="col-12 p-3">
                                            <img src="{{ asset('storage/app/propertyImage/' . $image->filename) }}" style="width: 250px; height: 150px">
                                            <input type="hidden" name="image_id[]" value="{{ $image->id }}">
                                        </div>
                                        <div class="col-12 p-3">
                                            <input type="number"
                                                name="sort_order[]"
                                                value="{{ $image->sort_order }}"
                                                class="form-control"
                                                min="1">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success pr-4 pl-4" id="submitForm">
                                    <i class="fa fa-save"></i> Update
                                </button>
                                <a href="{{ route('admin.properties.index') }}" class="btn btn-danger pr-4 pl-4">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>
@endsection

@section('scripts')

@endsection

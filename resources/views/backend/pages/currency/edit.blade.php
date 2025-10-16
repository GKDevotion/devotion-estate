@extends('backend.layouts.master')

@section('title')
    Currency Edit - Admin Panel
@endsection

@section('styles')
    <style>
        .form-check-label {
            text-transform: capitalize;
        }
    </style>
@endsection


@section('admin-content')
    <!-- page title area start -->
    <div class="page-title-area">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left d-none">Currency Edit - {{ $data->name }}</h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.currency.index') }}">All Currency</a></li>
                        <li><span>Edit Currency</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <p class="float-end">
                    @if (Auth::guard('admin')->user()->can('currency.edit'))
                        <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                            <i class="fa fa-save"></i> Update
                        </button>
                    @endif
                    <a href="{{ route('admin.currency.index') }}" class="btn btn-danger">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </p>
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
            <div class="col-12 mt-3">
                <h3 class="pb-3">Update Currency</h3>
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.currency.update', $data->id) }}"
                            onsubmit="return onSubmitValidateForm();" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-10 offset-1">
                                    <div class="row">



                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label class="mb-0" for="name">Name<span
                                                            class="text-error">*</span></label>
                                                    <input type="text" data-required="yes" class="form-control"
                                                        id="name" name="name" placeholder="Name"
                                                        value="{{ $data->name }}">
                                                </div>
                                                @error('name')
                                                    <div class="error text-error">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label class="mb-0" for="latitude">Currency Code</label>
                                                    <input type="text" class="form-control" id="currency_code"
                                                        name="currency_code" placeholder="currency_code"
                                                        value="{{ $data->currency_code }}">
                                                </div>
                                                @error('currency_code')
                                                    <div class="error text-error">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label class="mb-0" for="currency_value">Currency Value 1
                                                        (AED)</label>
                                                    <input type="text" class="form-control" id="longitude"
                                                        name="currency_value" placeholder="currency_value"
                                                        value="{{ $data->currency_value }}">
                                                </div>
                                                @error('currency_value')
                                                    <div class="error text-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label class="mb-0" for="status">Status</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>
                                                            Active</option>
                                                        <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>
                                                            De Active</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success pr-4 pl-4" id="submitForm">
                                            <i class="fa fa-save"></i> Update
                                        </button>
                                        <a href="{{ route('admin.currency.index') }}" class="btn btn-danger pr-4 pl-4">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </a>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script>
        $(window).ready(function() {
            $('#continent_id').on("change", function() {
                $(".continent-id").addClass('d-none')
                $(".continent_id_" + $(this).val()).removeClass('d-none')
            });

            $('#country_id').on("change", function() {
                $(".country-id").addClass('d-none')
                $(".country_id_" + $(this).val()).removeClass('d-none')
            });
        })
    </script> --}}
@endsection

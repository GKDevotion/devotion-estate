@extends('backend.layouts.master')

@section('title')
    Brochure Create - Admin Panel
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
                    <h4 class="page-title pull-left d-none">Brochure Create</h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.brochures.index') }}">All Brochure</a></li>
                        <li><span>Create Currency</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <p class="float-end">
                    @if (Auth::guard('admin')->user()->can('brochures.create'))
                        <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                            <i class="fa fa-save"></i> Save
                        </button>
                    @endif
                    <a href="{{ route('admin.brochures.index') }}" class="btn btn-danger">
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
                <h3 class="pb-3">Create Brochure</h3>
                <div class="card">
                    <div class="card-body">
                        {{-- @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif  --}}
                        <form action="{{ route('admin.brochures.store') }}" onsubmit="return onSubmitValidateForm();"
                            method="POST" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-md-10 offset-1">
                                    <div class="row">

                                        <div class="row">

                                            <div class="col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label class="mb-0" for="location">Location<span
                                                            class="text-error">*</span></label>
                                                    <input type="text" class="form-control" data-required="yes"
                                                        id="location" name="location" placeholder="location">
                                                </div>
                                                @error('location')
                                                    <div class="error text-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label class="mb-0" for="file">File</label>
                                                    <input type="file" class="form-control" id="file"
                                                        name="file">
                                                </div>
                                                @error('file')
                                                    <div class="error text-error">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label class="mb-0" for="agent">Agent</label>
                                                    <input type="text" class="form-control" id="agent" name="agent"
                                                        placeholder="Agent Name">
                                                </div>
                                                @error('agent')
                                                    <div class="error text-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <div class="form-group">
                                                    <label class="mb-0" for="status">Status</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="1">Active</option>
                                                        <option value="0">De Active</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success pr-4 pl-4" id="submitForm">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                        <a href="{{ route('admin.brochures.index') }}" class="btn btn-danger pr-4 pl-4">
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

{{-- @section('scripts')
<script>
    $(window).ready(function() {
        $('#continent_id').on("change", function(){
            $(".continent-id").addClass('d-none')
            $(".continent_id_"+$(this).val()).removeClass('d-none')
        });

        $('#country_id').on("change", function(){
            $(".country-id").addClass('d-none')
            $(".country_id_"+$(this).val()).removeClass('d-none')
        });
    })
</script>
@endsection --}}

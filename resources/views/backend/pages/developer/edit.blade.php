@extends('backend.layouts.master')

@section('title')
    Developer Edit - Admin Panel
@endsection

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
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
                    <h4 class="page-title pull-left d-none">Developer Edit - {{ $data->name }}</h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.developer.index') }}">All Developer</a></li>
                        <li><span>Edit Brochure</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <p class="float-end">
                    @if (Auth::guard('admin')->user()->can('developer.edit'))
                        <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                            <i class="fa fa-save"></i> Update
                        </button>
                    @endif
                    <a href="{{ route('admin.developer.index') }}" class="btn btn-danger">
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
                <h3 class="pb-3">Update Developer</h3>
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.developer.update', $data->id) }}" enctype="multipart/form-data"
                            onsubmit="return onSubmitValidateForm();" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-10 offset-1">
                                    <div class="row">
                                        <div class="row">

                                            <div class="col-4">
                                                <div class="col-12 mb-2">
                                                    <div class="form-group">
                                                        <label class="mb-0" for="image">Upload New Image</label>
                                                        <input type="file" name="image" class="dropify"
                                                            data-default-file="{{ asset('storage/app/developer/' . $data->image) }}">
                                                        @error('image')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-8 mb-2">
                                                <div class="form-group">
                                                    <label class="mb-0" for="name">Name</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                        placeholder="name" value="{{ $data->name }}">
                                                </div>
                                                @error('name')
                                                    <div class="error text-error">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12 col-sm-12 mb-2">
                                                <label class="mb-0" for="description">About Developer <span
                                                        class="text-error">*</span></label>
                                                <textarea class="ckeditor form-control" id="description" name="description" rows="16"
                                                    placeholder="Enter description here...">{{ old('description', $data->description ?? '') }}</textarea>

                                                @error('description')
                                                    <div class="error text-error">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="col-md-6 mb-2">
                                                <div class="form-group">
                                                    <label class="mb-0" for="sort_order">Sort Order</label>
                                                    <input type="text" class="form-control" id="sort_order"
                                                        name="sort_order" placeholder="Sort Order"
                                                        value="{{ $data->sort_order }}">
                                                </div>
                                                @error('sort_order')
                                                    <div class="error text-error">{{ $message }}</div>
                                                @enderror
                                            </div>


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
                                        <a href="{{ route('admin.developer.index') }}" class="btn btn-danger pr-4 pl-4">
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
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .then(editor => {
                editorDescriptionInstance = editor;
            })
            .catch(error => {
                console.error(error);
            });

        $('.dropify').dropify({});
    </script>
@endsection

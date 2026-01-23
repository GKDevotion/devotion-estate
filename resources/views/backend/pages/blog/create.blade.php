@extends('backend.layouts.master')

@section('title')
    Blog Create - Admin Panel
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/dropify/css/dropify.min.css') }}">
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
                    <h4 class="page-title pull-left d-none">Blog Create</h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('admin.blog.index') }}">All Blogs</a></li>
                        <li><span>Create Blog</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <p class="float-end">
                    @if (Auth::guard('admin')->user()->can('blogs.create'))
                        <button type="button" class="btn btn-success pr-4 pl-4" onclick="$('#submitForm').click();">
                            <i class="fa fa-save"></i> Save
                        </button>
                    @endif
                    <a href="{{ route('admin.blog.index') }}" class="btn btn-danger">
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
                <h3 class="pb-3">Create Blog</h3>
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.blog.store') }}" onsubmit="return onSubmitValidateForm();"
                            method="POST" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 offset-3">
                                    <div class="row">

                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="image">
                                                    Image <span class="text-error">*</span>
                                                </label>

                                                <input type="file" class="form-control dropify" id="image"
                                                    name="image" data-allowed-file-extensions="jpg jpeg png webp"
                                                    data-max-file-size="2M" data-height="150" data-required="yes">
                                            </div>

                                            @error('image')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="title">Name<span
                                                        class="text-error">*</span></label>
                                                <input type="text" data-required="yes" class="form-control"
                                                    id="title" name="title" placeholder="Blog Name" autofocus>
                                            </div>
                                            @error('title')
                                                <div class="error text-error">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="category_id">Category</label>
                                                <select class="form-control category_id" id="category_id"
                                                    name="category_id">
                                                    <option value="0">Select Category</option>
                                                    @foreach ($categories as $prc)
                                                        @if ($prc->childrenRecursive->isNotEmpty())
                                                            @foreach ($prc->childrenRecursive as $ar)
                                                                <option value="{{ $ar->id }}">
                                                                    {{ $ar->title }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('category_id'))
                                                    <div class="error">{{ $errors->first('category_id') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <div class="form-group">
                                                <label for="sub_category_id">Sub Category</label>
                                                <select class="form-control sub_category_id" id="sub_category_id"
                                                    name="sub_category_id">
                                                    <option value="0">Select Sub Category</option>
                                                    @foreach ($categories as $prc)
                                                        @if ($prc->childrenRecursive->isNotEmpty())
                                                            @foreach ($prc->childrenRecursive as $child)
                                                                @foreach ($child->childrenRecursive as $ar)
                                                                    <option value="{{ $ar->id }}"
                                                                        class="d-none sub-category parent-category-{{ $ar->parent_id }}">
                                                                        {{ $ar->title }}</option>
                                                                @endforeach
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('sub_category_id'))
                                                    <div class="error">{{ $errors->first('sub_category_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <label class="mb-0" for="tags">Tags<span
                                                    class="text-error">*</span></label>
                                                <select name="tags[]" class="form-control" multiple>
                                                    @foreach ($tags as $tag)
                                                        <option value="{{ $tag->id }}">
                                                            {{ $tag->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <div class="form-group">
                                            <label class="mb-0" for="short_description">Short Description<span
                                                    class="text-error">*</span></label>
                                            <input type="text" data-required="yes" class="form-control"
                                                id="short_description" name="short_description"
                                                placeholder="Short Description">
                                        </div>
                                        @error('short_description')
                                            <div class="error text-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 col-sm-12 mb-2">
                                        <label class="mb-0" for="description">Description <span
                                                class="text-error">*</span></label>
                                        <textarea type="text" class="ckeditor form-control" id="description" name="description"
                                            placeholder="Description" rows="16"></textarea>
                                        <div class="error text-error"></div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 mb-2">
                                        <label class="mb-0" for="keyword">Keyword <span
                                                class="text-error">*</span></label>
                                        <textarea type="text" class="ckeditor form-control" id="keyword" name="keyword" placeholder="Keyword"
                                            rows="16"></textarea>
                                        <div class="error text-error"></div>
                                    </div>

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
                            <a href="{{ route('admin.blog.index') }}" class="btn btn-danger pr-4 pl-4">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->

        <!-- extra hidden values -->
        <span class="get-continent-list-url d-none">{{ url('api/get-continent-list') }}</span>
        <span class="get-country-list-url d-none">{{ url('api/get-country-list') }}</span>
        <span class="get-state-list-url d-none">{{ url('api/get-state-list') }}</span>
        <span class="get-city-list-url d-none">{{ url('api/get-city-list') }}</span>
    </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('.dropify').dropify({
            messages: {
                default: 'Drag and drop file here or click',
                replace: 'Drag and drop or click to replace',
                remove: 'Remove',
                error: 'Oops, something went wrong.'
            }
        });

        var drEvent = $('#image').dropify();

        ClassicEditor
            .create(document.querySelector('#description'))
            .then(editor => {
                editorDescriptionInstance = editor;
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#keyword'))
            .then(editor => {
                editorDescriptionInstance = editor;
            })
            .catch(error => {
                console.error(error);
            });

        $("#category_id").on("change", function() {
            var category_id = $(this).val();
            $("#sub_category_id").find('.sub-category').addClass("d-none");
            $("#sub_category_id").find(".parent-category-" + category_id).removeClass("d-none");
        });
    </script>
@endsection

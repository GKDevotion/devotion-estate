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
                    <form action="{{ route('admin.properties.imageOrder.update', $id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="property_id" value="{{ $id }}">

                        <div class="row">
                            @foreach ($imageArr as $image)
                                <div class="col-3 mb-4 border rounded p-2 text-center">
                                    <img src="{{ asset('storage/app/propertyImage/' . $image->filename) }}"
                                        class="img-fluid mb-2" style="height:150px; width:100%; object-fit:cover;">

                                    <input type="hidden" name="image_id[]" value="{{ $image->id }}">

                                    <label>Sort Order</label>
                                    <input type="number" name="sort_order[]" value="{{ $image->sort_order }}"
                                        class="form-control mb-2" min="1">

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="delete_images[]"
                                            value="{{ $image->id }}" id="deleteImage{{ $image->id }}">
                                        <label class="form-check-label text-danger" for="deleteImage{{ $image->id }}">
                                            Delete Image
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <hr>

                        {{-- Upload New Images --}}
                        <div class="mb-3">
                            <label class="fw-bold mb-1">
                                Upload New Images
                                <small class="text-muted">(You can select up to 5)</small>
                            </label>

                            <input type="file" name="propertyImage[]" class="form-control dropify" multiple
                                accept="image/png,image/jpeg,image/jpg,image/webp,image/gif" id="propertyImage">

                            @error('propertyImage.*')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
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
  <script>
    // Initialize Dropify
    var drEvent = $('.dropify').dropify();

    document.addEventListener('DOMContentLoaded', function () {
        var existingImages = {{ $imageArr->count() }}; // current images count
        var maxImages = 5;
        var remaining = maxImages - existingImages; // how many can still be uploaded

        var input = document.getElementById('propertyImage');

        input.addEventListener('change', function () {
            if (this.files.length > remaining) {
                Swal.fire({
                    icon: 'warning',
                    title: `You can upload only ${remaining} more image(s).`,
                    text: 'Only the allowed number of images will be accepted.',
                    confirmButtonColor: '#ab8134'
                }).then(() => {
                    // Clear selected files
                    this.value = "";

                    // Reset Dropify preview
                    var dropifyInstance = drEvent.data('dropify');
                    dropifyInstance.clearElement();
                });
            }
        });
    });
</script>

@endsection

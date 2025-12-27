@extends('backend.layouts.master')

@section('title')
    Properties Page
@endsection

@section('styles')
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/classic/ckeditor.js"></script>
    <!-- Start datatable css -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .child {
            text-align: left;
        }
    </style>
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
                <h3 class="pb-3">Properties History</h3>
                <div class="card">
                    <div class="card-body">

                        <div class="data-tables">
                            @include('backend.layouts.partials.messages')
                            <table id="properties_index" class="table table-bordered table-striped display responsive nowrap">
                                <thead id="properties" class="bg-light text-capitalize">
                                    <tr>
                                        <th>Sr</th>
                                        <th>Image</th>
                                        <th>Unique ID</th>
                                        <th>Name</th>
                                        <th>Purpose</th>
                                        <th>Type</th>
                                        <th>Area</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Address</th>
                                        <th>View</th>
                                        <th>Publish</th>
                                        <th>New Property</th>
                                        <th>Feature Property</th>
                                        <th>Hot Property</th>
                                        <th>Luxury</th>
                                        <th>Update At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->

        </div>
    </div>

    <div class="modal fade" id="descriptionModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Update Property Description</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="property_id">

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control ckeditor" name="description" id="property_description" rows="6"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveDescription">Save</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="informationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Update Property Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="info_property_id">

                    <div class="col-md-12 col-sm-12 mb-2">
                        <label class="form-label">Property Name</label>
                        <input type="text" id="info_name" class="form-control">
                    </div>

                    <div class="col-md-12 col-sm-12 mb-2">
                        <label class="mb-0" for="building_name">Building Name<span
                                class="text-error">*</span></label>
                        <input type="text" id="info_building" class="form-control">
                    </div>

                    <div class="col-md-12 col-sm-12 mb-2">
                        <label class="form-check-label mb-2">Property Features</label>

                        <textarea class="form-control ckeditor" id="info_features" name="additional_features"
                            placeholder="Add additional property Features"></textarea>

                        <div class="error text-error"></div>
                    </div>


                    <div class="row">

                        <div class="col-md-4 col-sm-12 mb-2">
                            <label class="mb-0" for="agent_id">Agent <span
                                    class="text-error">*</span></label>
                            <select name="agent_id" id="info_agent" class="form-control"
                                data-required="yes">
                                <option value="">Select Agent</option>
                                @foreach ($agentObj as $ar)
                                    <option value="{{ $ar->id }}"
                                        {{ old('agent_id', $data->agent_id ?? '') == $ar->id ? 'selected' : '' }}>
                                        {{ $ar->first_name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('agent_id')
                                <div class="error text-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 col-sm-12 mb-2">
                            <label class="mb-0" for="developer_id">Develop By <span
                                    class="text-error">*</span></label>
                            <select name="developer_id" id="info_developer"
                                class="form-control select2" data-required="yes">
                                <option value="">Select Location</option>
                                @foreach ($developerObj as $ar)
                                    <option value="{{ $ar->id }}"
                                        {{ old('developer_id', $data->developer_id ?? '') == $ar->id ? 'selected' : '' }}>
                                        {{ $ar->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="error text-error"></div>
                        </div>

                        <div class="col-md-4 col-sm-12 mb-2">
                            <label class="mb-0" for="price">Price <span
                                    class="text-error">*</span></label>
                            <input type="number" id="info_price" class="form-control">
                        </div>


                    </div>

                    <div class="col-md-4 col-sm-12 mb-2">
                        <label class="mb-0" for="location_id">Location <span
                                class="text-error">*</span></label>
                        <select name="location_id" id="info_location" class="form-control select2"
                            data-required="yes">
                            <option value="">Select Location</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location->id }}"
                                    {{ old('location_id', $location->location_id ?? '') == $location->id ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                            <option value="other">Other</option>
                        </select>

                        @error('location_id')
                            <div class="error text-error">{{ $message }}</div>
                        @enderror
                    </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveInformation">Save</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('backend.layouts.partials.data-table')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#properties_index').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                dom: '<"row"<"col-md-4"B><"col-md-4 text-left"l><"col-md-4 text-right"f>>' +
                    'rt' +
                    '<"row"<"col-md-6"i><"col-md-6"p>>', // Custom structure with multiple parameters
                buttons: ['excel', 'pdf'],
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                pageLength: 10,
                // ajax: "{{ route('properties.ajaxIndex') }}",
                ajax: {
                    url: "{{ route('properties.ajaxIndex') }}",
                    type: 'GET',
                    data: function(d) {
                        d.field = "{{ $param['field'] }}"; // Pass company parameter
                        d.value = "{{ $param['value'] }}"; // Pass industry parameter
                    }
                },
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Auto-increment based on row index
                        }
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'unique_id',
                        name: 'unique_id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'purpose',
                        name: 'purpose'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'area',
                        name: 'area'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'location_id',
                        name: 'location_id'
                    },
                    {
                        data: 'count',
                        name: 'count'
                    },
                    {
                        data: 'publish',
                        name: 'publish'
                    },
                    {
                        data: 'is_new_property',
                        name: 'is_new_property'
                    },
                    {
                        data: 'is_featured_property',
                        name: 'is_featured_property'
                    },
                    {
                        data: 'is_hot_offer',
                        name: 'is_hot_offer'
                    },
                    {
                        data: 'is_hot_offer',
                        name: 'is_hot_offer'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                columnDefs: [{
                        responsivePriority: 1,
                        targets: 0
                    },
                    {
                        responsivePriority: 2,
                        targets: 1
                    },
                    {
                        responsivePriority: 3,
                        targets: 2
                    },
                    {
                        responsivePriority: 4,
                        targets: 3
                    },
                    {
                        responsivePriority: 5,
                        targets: 4
                    },
                    {
                        responsivePriority: 6,
                        targets: 5
                    },
                    {
                        responsivePriority: 10001,
                        targets: [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('id', 'row_' + data.id); // Assign a custom ID to the row
                    $(row).attr('class', 'properties_row'); // Assign a custom Class to the row
                }
            });

            // Adjust the table width after the data is loaded
            table.on('xhr', function() {
                var data = table.ajax.json().data;

                if (data.length === 0) {
                    $('#properties_index').css('width', '100%');
                } else {
                    $('#properties_index').css('width', 'auto');
                }
            });
        });
    </script>

    {{-- description model --}}
    <script>
        let editorDescriptionInstance; // make sure this is global

        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#property_description'))
            .then(editor => {
                editorDescriptionInstance = editor;
            })
            .catch(error => {
                console.error(error);
            });

        $(document).on('click', '.btn-description', function() {

            let id = $(this).data('id');

            let url = "{{ route('admin.properties.getDescription', ':id') }}";
            url = url.replace(':id', id);

            $('#property_id').val(id);

            if (editorDescriptionInstance) {
                editorDescriptionInstance.setData('Loading...'); // show loading in CKEditor
            }

            $.ajax({
                url: url,
                type: "GET",
                success: function(description) {

                    if (!description) {
                        if (editorDescriptionInstance) editorDescriptionInstance.setData('');
                    } else {
                        // Keep HTML formatting for CKEditor
                        if (editorDescriptionInstance) editorDescriptionInstance.setData(description);
                    }

                    // Show Bootstrap modal
                    const modal = new bootstrap.Modal(document.getElementById('descriptionModal'));
                    modal.show();
                },
                error: function() {
                    toastr.error('Failed to load description');
                }
            });
        });

        // Handle saving the description
        $(document).on('click', '#saveDescription', function() {
            $.ajax({
                url: "{{ route('admin.properties.updateDescription') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: $('#property_id').val(),
                    description: editorDescriptionInstance.getData()
                },
                success: function() {
                    // Hide modal
                    bootstrap.Modal.getInstance(document.getElementById('descriptionModal')).hide();

                    toastr.success('Description updated successfully');
                    $('#properties_index').DataTable().ajax.reload(null, false);
                },
                error: function() {
                    toastr.error('Something went wrong');
                }
            });
        });
    </script>
    {{-- information model --}}
    <script>
        $(document).on('click', '.btn-information', function() {

            let id = $(this).data('id');

            let url = "{{ route('admin.properties.getInformation', ':id') }}";
            url = url.replace(':id', id);

            $('#info_property_id').val(id);
            $('#info_name').val('Loading...');
            $('#info_price').val('');
            $('#info_location').val('');
            $('#info_agent').val('');
            $('#info_developer').val('');
            $('#info_features').val('');
            $('#info_building').val('');


            $.ajax({
                url: url,
                type: "GET",
                success: function(res) {

                    $('#info_name').val(res.name ?? '');
                    $('#info_price').val(res.price ?? '');
                    $('#info_location').val(res.location_id ?? '');
                    $('#info_agent').val(res.agent_id ?? '');
                    $('#info_developer').val(res.developer_id ?? '');
                    $('#info_features').val(res.additional_features ?? '');
                    $('#info_building').val(res.building_name ?? '');


                    // Show modal AFTER data loads
                    const modal = new bootstrap.Modal(
                        document.getElementById('informationModal')
                    );
                    modal.show();
                },
                error: function() {
                    toastr.error('Failed to load property information');
                }
            });
        });

        $(document).on('click', '#saveInformation', function() {

            let id = $('#info_property_id').val();
            let name = $('#info_name').val();
            let price = $('#info_price').val();
            let location = $('#info_location').val();
            let agent = $('#info_agent').val();
            let developer = $('#info_developer').val();
            let features = $('#info_features').val();
            let building = $('#info_building').val();

            if (!id) {
                toastr.error('Property ID missing');
                return;
            }

            $.ajax({
                url: "{{ route('admin.properties.updateInformation') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    name: name,
                    price: price,
                    location_id: location,
                    agent_id: agent,
                    developer_id: developer,
                    additional_features: features,
                    building_name: building
                },
                beforeSend: function() {
                    $('#saveInformation').prop('disabled', true).text('Saving...');
                },
                success: function(res) {
                    // Hide modal
                    const modalEl = document.getElementById('informationModal');
                    bootstrap.Modal.getInstance(modalEl)?.hide();

                    toastr.success('Property information updated successfully');

                    // Reload DataTable if exists
                    if ($.fn.DataTable.isDataTable('#properties_index')) {
                        $('#properties_index').DataTable().ajax.reload(null, false);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    toastr.error('Something went wrong');
                },
                complete: function() {
                    $('#saveInformation').prop('disabled', false).text('Save');
                }
            });
        });
    </script>

    <script>
        $('#informationModal').on('shown.bs.modal', function() {
            $('#info_location').select2({
                placeholder: "Search Location",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#informationModal') // Important: ensures dropdown shows inside modal
            });
        });
    </script>
@endsection


@extends('backend.layouts.master')

@section('title')
State Page - Admin Panel
@endsection

@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
    <style>
        .child{
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
                <h4 class="page-title pull-left d-none">State</h4>
                <ul class="breadcrumbs pull-left m-2">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>All State</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3 text-end">
            @if (Auth::guard('admin')->user()->can('state.edit'))
                <a class="btn btn-add text-white" href="{{ route('admin.state.create') }}">
                    <i class="fa fa-plus"></i> State
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
            <h3 class="pb-3">State History</h3>
            <div class="card">
                <div class="card-body">
                   <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="state_index" class="">
                            <thead id="state" class="bg-light text-capitalize">
                                <tr>
                                    <th width="2%">Sr</th>
                                    <th width="20%">Name</th>
                                    <th width="5%">Continent</th>
                                    <th width="5%">Country</th>
                                    <th width="5%">Location</th>
                                    <th width="2%">Status</th>
                                    <th width="5%">Update At</th>
                                    <th width="4%">Action</th>
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
@endsection


@section('scripts')

    @include('backend.layouts.partials.data-table')

     <script>

        $(document).ready(function() {
            var table = $('#state_index').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                dom: '<"row"<"col-md-4"B><"col-md-4 text-left"l><"col-md-4 text-right"f>>' +
                    'rt' +
                    '<"row"<"col-md-6"i><"col-md-6"p>>', // Custom structure with multiple parameters
                buttons: ['excel', 'pdf'],
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                pageLength: 10,
                ajax: "{{ route('state.ajaxIndex') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    {
                        data: 'name',
                        render: function (data, type, row) {
                            // Customize the HTML content
                            return `${row.name} ( ${row.iso2} )`;
                        },
                        orderable: true, // Prevent sorting on this column
                        searchable: true // Prevent searching on this column
                    },
                    // { data: 'name', name: 'name' },
                    { data: 'continent_name', name: 'continent_name' },
                    { data: 'country_name', name: 'country_name' },
                    // { data: 'iso2', name: 'iso2' },
                    {
                        data: 'latitude',
                        render: function (data, type, row) {
                            // Customize the HTML content
                            return `
                                Lat: ${row.latitude}<br>
                                Long: ${row.longitude}
                            `;
                        },
                        searchable: false // Prevent searching on this column
                    },
                    // { data: 'latitude', name: 'latitude' },
                    // { data: 'longitude', name: 'longitude' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('id', 'row_' + data.id);// Assign a custom ID to the row
                    $(row).attr('class', 'state_row');// Assign a custom Class to the row
                },
                language: {
                    emptyTable: "No data available in table"  // Custom message for empty table
                },
            });

            // Adjust the table width after the data is loaded
            table.on('xhr', function() {
                var data = table.ajax.json().data;

                if (data.length === 0) {
                    $('#state_index').css('width', '100%');
                } else {
                    $('#state_index').css('width', 'auto');
                }
            });
        });

     </script>
@endsection

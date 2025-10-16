@extends('backend.layouts.master')

@section('title')
    Company Review Page - Admin Panel
@endsection

@section('styles')
    <!-- Start datatable css -->
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
            <div class="col-md-8">
                <div class="breadcrumbs-area clearfix">
                    <h4 class="page-title pull-left d-none">Corporate Email</h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><span>All Reviews</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2 text-end">
                @if (Auth::guard('admin')->user()->can('reviews.create'))
                    <a class="btn btn-add text-white" href="{{ route('admin.reviews.create') }}">
                        <i class="fa fa-plus"></i> Review
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
                <h3 class="pb-3">Review Hisotry</h3>
                <div class="card">
                    <div class="card-body">

                        <div class="data-tables">

                            @include('backend.layouts.partials.messages')

                            <table id="reviews_index" class="">
                                <thead id="reviews" class="bg-light text-capitalize">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email Address</th>
                                        <th>Contact No.</th>
                                        <th>Review</th>
                                        <th>Rating</th>
                                        <th>Property Id</th>
                                        <th>Status</th>
                                        <th>Updated At</th>
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
@endsection


@section('scripts')
    @include('backend.layouts.partials.data-table')

    <script>
        $(document).ready(function() {
            var table = $('#reviews_index').DataTable({
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
                ajax: {
                    url: "{{ route('reviews.ajaxIndex') }}",
                    type: 'GET',
                    data: function(d) {
                        // d.cid = ""; // Pass company parameter
                        // d.iid = ""; // Pass industry parameter
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'contact_no',
                        name: 'contact_no'
                    },
                    {
                        data: 'review',
                        name: 'review'
                    },
                    {
                        data: 'rating',
                        name: 'rating'
                    },
                    {
                        data: 'property_id',
                        name: 'property_id'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('id', 'row_' + data.id); // Assign a custom ID to the row
                    $(row).attr('class', 'reviews_row'); // Assign a custom Class to the row
                },
                language: {
                    emptyTable: "No data available in table" // Custom message for empty table
                },
            });

            // Adjust the table width after the data is loaded
            table.on('xhr', function() {
                var data = table.ajax.json().data;

                $('#reviews_index').css('width', '100%');
            });
        });
    </script>
@endsection

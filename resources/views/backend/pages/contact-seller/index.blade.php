@extends('backend.layouts.master')

@section('title')
    Contact SellerPage - Admin Panel
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
                    <h4 class="page-title pull-left d-none">Contact Seller</h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><span>All Contact Seller</span></li>
                    </ul>
                </div>
            </div>
            {{-- <div class="col-md-2 text-end">
                @if (Auth::guard('admin')->user()->can('property-contact.create'))
                    <a class="btn btn-add text-white" href="{{ route('admin.property-contact.create') }}">
                        <i class="fa fa-plus"></i> Property Contact
                    </a>
                @endif
            </div> --}}
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
                <h3 class="pb-3">Contact Seller Enquiry History</h3>
                <div class="card">
                    <div class="card-body">

                        <div class="row gap-3">

                            <div class="card col-md-4 mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0 text-white">Contact Seller – Date Wise Graph</h5>
                                </div>

                                <div class="card-body">
                                    <canvas id="contactChart" style="min-height:100px;"></canvas>
                                </div>
                            </div>

                            <div class="card col-md-4 mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0 text-white">Contact Seller – Country Wise</h5>
                                </div>

                                <div class="card-body">
                                    <canvas id="countryPieChart" style="min-height:100px;"></canvas>
                                </div>
                            </div> 

                        </div>


                        <div class="data-tables">

                            @include('backend.layouts.partials.messages')

                            <table id="contact-seller_index"
                                class="table table-bordered table-striped display responsive nowrap">
                                <thead id="contact-seller" class="bg-light text-capitalize">
                                    <tr>
                                        <th>#</th>
                                        <th>Property Name</th>
                                        <th>Name</th>
                                        <th>Email Address</th>
                                        <th>Contact No.</th>
                                        <th>Message</th>
                                        <th>City</th>
                                        <th>Country</th>
                                        <th>IP Address</th>
                                        <th>Region</th>
                                        <th>Read</th>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const labels = {!! json_encode($chartData->pluck('date')) !!};
            const values = {!! json_encode($chartData->pluck('total')) !!};

            if (!labels.length) {
                console.warn('No chart data available');
                return;
            }

            const ctx = document.getElementById('contactChart').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Contacts',
                        data: values,
                        backgroundColor: '#aa8038',
                        borderRadius: 6,
                        barThickness: 30
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // 🔑 important for card layout
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const countryLabels = {!! json_encode($countryChartData->pluck('countryName')) !!};
            const countryValues = {!! json_encode($countryChartData->pluck('total')) !!};

            if (!countryLabels.length) {
                console.warn('No country chart data available');
                return;
            }

            const ctx = document.getElementById('countryPieChart').getContext('2d');

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: countryLabels,
                    datasets: [{
                        data: countryValues,
                        backgroundColor: [
                            'Red',
                            'Orange',
                            'Yellow',
                            'Green',
                            'Blue',
                            '#858796',
                            '#fd7e14'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.raw;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script> 

    <script>
        $(document).ready(function() {
            var table = $('#contact-seller_index').DataTable({
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
                    url: "{{ route('contact-seller.ajaxIndex') }}",
                    type: 'GET',
                    data: function(d) {
                        // d.cid = ""; // Pass company parameter
                        // d.iid = ""; // Pass industry parameter
                    }
                },
                columns: [
                    {   data: 'id',   name: 'id' },
                    {   data: 'property_name',   name: 'property_name' },
                    {   data: 'name', name: 'name' },
                    {   data: 'email', name: 'email' },
                    {   data: 'mobile_number', name: 'mobile_number' },
                    {   data: 'message', name: 'message' },
                    {   data: 'cityName', name: 'cityName' },
                    {   data: 'countryName', name: 'countryName' },
                    {   data: 'ip',   name: 'ip' },
                    {   data: 'regionName',   name: 'regionName' },
                    {   data: 'is_read', name: 'is_read' },
                    {   data: 'updated_at', name: 'updated_at' },
                    {   data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                columnDefs: [
                    { responsivePriority: 1,  targets: 0 },
                    { responsivePriority: 2,  targets: 1 },
                    { responsivePriority: 3,  targets: 2 },
                    { responsivePriority: 4,  targets: 3 },
                    { responsivePriority: 5,  targets: 4 },
                    { responsivePriority: 6,  targets: 5 },
                    { responsivePriority: 10001,  targets: [6, 7, 8] }
                ],
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('id', 'row_' + data.id); // Assign a custom ID to the row
                    $(row).attr('class', 'contact-seller_row'); // Assign a custom Class to the row
                },
                language: {
                    emptyTable: "No data available in table" // Custom message for empty table
                },
            });

            // Adjust the table width after the data is loaded
            table.on('xhr', function() {
                var data = table.ajax.json().data;

                $('#contact-seller_index').css('width', '100%');
            });
        });
    </script>
@endsection

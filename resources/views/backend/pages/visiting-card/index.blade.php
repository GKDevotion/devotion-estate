
@extends('backend.layouts.master')

@section('title')
Visiting Card Page - Admin Panel
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
                <h4 class="page-title pull-left d-none">Visiting Card</h4>
                <ul class="breadcrumbs pull-left m-2">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>All Visiting Card</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3 text-end">
            @if ( true || Auth::guard('admin')->user()->can('visiting-card.create'))
                <a class="btn btn-add text-white" href="{{ route('admin.visiting-card.create') }}">
                    <i class="fa fa-plus"></i> Visiting Card
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
            <h3 class="pb-3">Visiting Card History</h3>
            <div class="card">
                <div class="card-body">

                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="visiting_card_index" class="text-center">
                            <thead id="portfolio" class="bg-light text-capitalize">
                                <tr>
                                    <th>Sr</th>
                                    <th>QR</th>
                                    <th>Avtar</th>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>Email</th>
                                    <th>View</th>
                                    <th>Status</th>
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
@endsection



@section('scripts')

    @include('backend.layouts.partials.data-table')

     <script>
        $(document).ready(function() {
            var table = $('#visiting_card_index').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                dom: '<"row"<"col-md-4"B><"col-md-4 text-left"l><"col-md-4 text-right"f>>' +
                    'rt' +
                    '<"row"<"col-md-6"i><"col-md-6"p>>', // Custom structure with multiple parameters
                buttons: ['excel', 'pdf'],
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                pageLength: 10,
                ajax: "{{ route('visiting-card.ajaxIndex') }}",
                columns: [
                    {
                        data: 'id',
                        render: function (data, type, row, meta) {
                            return meta.row + 1; // Auto-increment based on row index
                        }
                    }, // Auto index { data: 'id', name: 'id' },
                    {
                        data: 'qr_code',
                        render: function (data, type, row, meta) {
                            return '<img src="'+row.qr_code+'" title="'+row.name+'" width="150px;">'; // Auto-increment based on row index
                        }
                    },
                    {
                        data: 'avtar',
                        render: function (data, type, row, meta) {
                            return '<img src="'+row.avtar+'" title="'+row.name+'" width="150px;">'; // Auto-increment based on row index
                        }
                    },
                    { data: 'name', name: 'name' },
                    { data: 'company', name: 'company' },
                    { data: 'email', name: 'email' },
                    { data: 'view', name: 'view' },
                    { data: 'status', name: 'status' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            // Adjust the table width after the data is loaded
            table.on('xhr', function() {
                var data = table.ajax.json().data;

                if (data.length === 0) {
                    $('#visiting_card_index').css('width', '100%');
                } else {
                    $('#visiting_card_index').css('width', 'auto');
                }
            });
        });
     </script>
@endsection

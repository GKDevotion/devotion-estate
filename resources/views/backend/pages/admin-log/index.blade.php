
@extends('backend.layouts.master')

@section('title')
Admin Log Page - Admin Panel
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
        <div class="col-sm-8">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left d-none">Admin Log</h4>
                <ul class="breadcrumbs pull-left m-2">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>All Admin Log</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-2 text-end">
            @if (Auth::guard('admin')->user()->can('admin-log.edit'))
                <a class="btn btn-add text-white" href="{{ route('admin.admin-log.create') }}">
                    <i class="fa fa-plus"></i> Admin Log
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
        <h3>Admin Log</h3>
        <!-- data table start -->
        <div class="col-12 mt-3">
            <h3 class="pb-3">Admin Log History</h3>
            <div class="card">
                <div class="card-body">
                   <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="admin_log_index" class="text-center">
                            <thead id="admin_log" class="bg-light text-capitalize">
                                <tr>
                                    <th>Sr</th>
                                    <th>Name</th>
                                    <th>Table</th>
                                    <th>Field</th>
                                    <th>Action</th>
                                    <th>IP Address</th>
                                    <th>Primary ID</th>
                                    <th>Child ID</th>
                                    <th>Description</th>
                                    <th>Created At</th>
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
     <!-- Start datatable js -->
     <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

     <script>
         /*================================
        datatable active
        ==================================*/
        // if ($('#dataTable').length) {
        //     $('#dataTable').DataTable({
        //         responsive: true
        //     });
        // }
        $(document).ready(function() {
            var table = $('#admin_log_index').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin-log.ajaxIndex') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'table', name: 'table' },
                    { data: 'field', name: 'field' },
                    { data: 'action', name: 'action' },
                    { data: 'pk_table_id', name: 'pk_table_id' },
                    { data: 'child_table_id', name: 'child_table_id' },
                    { data: 'ip_address', name: 'ip_address' },
                    { data: 'description', name: 'description' },
                    { data: 'created_at', name: 'created_at' },
                ]
            });

            // Adjust the table width after the data is loaded
            table.on('xhr', function() {
                var data = table.ajax.json().data;

                if (data.length === 0) {
                    $('#admin_log_index').css('width', '100%');
                } else {
                    $('#admin_log_index').css('width', 'auto');
                }
            });
        });

     </script>
@endsection

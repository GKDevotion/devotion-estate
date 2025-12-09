
@extends('backend.layouts.master')

@section('title')
Developer Page - Admin Panel
@endsection

@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">

@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-7">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left d-none">Developer</h4>
                <ul class="breadcrumbs pull-left m-2">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>All Developer</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-3 text-end">
            @if (Auth::guard('admin')->user()->can('developer.create'))
                <a class="btn btn-add text-white" href="{{ route('admin.developer.create') }}">
                    <i class="fa fa-plus"></i> Developer
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
            <h3 class="pb-3">Developer History</h3>
            <div class="card">
                <div class="card-body">

                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="developer_index" class="text-left">
                            <thead id="developer" class="bg-light text-capitalize">
                                <tr>
                                    <th width="1%">Sr</th>
                                    <th width="5%">Name</th>
                                    <th width="2%">Status</th>
                                    <th width="3%">Update At</th>
                                    <th width="3%">Action</th>
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
            $('#developer_index').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                dom: '<"row"<"col-md-4"B><"col-md-4 text-left"l><"col-md-4 text-right"f>>' +
                    'rt' +
                    '<"row"<"col-md-6"i><"col-md-6"p>>', // Custom structure with multiple parameters
                buttons: ['excel', 'pdf'],
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                pageLength: 10,
                ajax: "{{ route('developer.ajaxIndex') }}",
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Auto-increment based on row index
                        }
                    }, // Auto index { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).attr('id', 'row_' + data.id);// Assign a custom ID to the row
                    $(row).attr('class', 'developer_row');// Assign a custom Class to the row
                }
            });
        });
     </script>
@endsection

@extends('backend.layouts.master')

@section('title')
    Category - Admin Panel
@endsection

@section('styles')
    <!-- Start datatable css -->
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css"> --}}
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
                    <h4 class="page-title pull-left d-none">Category</h4>
                    <ul class="breadcrumbs pull-left m-2">
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><span>All Category</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2 text-end">
                @if (Auth::guard('admin')->user()->can('category.create'))
                    <a class="btn btn-add text-white" href="{{ route('admin.category.create') }}">
                        <i class="fa fa-plus"></i> Blog
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
            <div class="col-12 mt-3">
                <h3 class="pb-3">Category History</h3>
                <div class="card">
                    
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="data-tables">
                            @include('backend.layouts.partials.messages')
                            <table id="categories_index"
                                class="table table-bordered table-striped display responsive nowrap">
                                <thead id="category" class="bg-light text-capitalize">
                                    <tr>
                                        <th>Sr</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Parent Name</th>
                                        <th>slug</th>
                                        <th>status</th>
                                        <th>Update At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </div>
@endsection


@section('scripts')
    @include('backend.layouts.partials.data-table')

    <script>
        $(document).ready(function() {
            $('#categories_index').DataTable({
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
                ajax: "{{ route('category.ajaxIndex') }}",
                columns: [
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Auto-increment based on row index
                        }
                    }, // Auto index { data: 'id', name: 'id' },
                    { data: 'image',   name: 'image' },
                    { data: 'title',  name: 'title' },
                    { data: 'parent_id',  name: 'parent_id' },
                    { data: 'slug', name: 'slug' },
                    { data: 'status',  name: 'status', orderable: false, searchable: false },
                    { data: 'updated_at',  name: 'updated_at' },
                    { data: 'action',  name: 'action', orderable: false, searchable: false },
                ],

                columnDefs: [
                    { responsivePriority: 1, targets: 0 }, 
                    { responsivePriority: 2,  targets: 1 },  
                    { responsivePriority: 3, targets: 2 },  
                    { responsivePriority: 4,  targets: 3 },  
                    { responsivePriority: 5,  targets: 4 },  
                    { responsivePriority: 6,  targets: 5 },  
                    { responsivePriority: 10001,  targets: [6 , 7] }  
                ],
                createdRow: function(row, data, dataIndex) {
                    $(row).attr('id', 'row_' + data.id); // Assign a custom ID to the row
                    $(row).attr('class', 'categories_row'); // Assign a custom Class to the row
                }
            });

              // Adjust the table width after the data is loaded
            table.on('xhr', function() {
                var data = table.ajax.json().data;

                $('#categories_index').css('width', '100%');
            });
        });
    </script>
@endsection

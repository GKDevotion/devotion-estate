
@extends('backend.layouts.master')

@section('title')
City Page - Admin Panel
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
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">City</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>All City</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">City List</h4>
                    <p class="float-end mb-2 text-end">
                        @if (Auth::guard('admin')->user()->can('city.create'))
                            <a class="btn btn-add text-white" href="{{ route('admin.city.create') }}">
                                <i class="fa fa-plus"></i>
                            </a>
                        @endif
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="1%">Sr</th>
                                    <th width="20%">Name</th>
                                    <th width="5%">State</th>
                                    <th width="2%">Country</th>
                                    <th width="2%">Continent</th>
                                    <th width="5%">Latitude</th>
                                    <th width="5%">Longitude</th>
                                    <th width="2%">Status</th>
                                    <th width="3%">Created At</th>
                                    <th width="3%">Update At</th>
                                    <th width="3%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($dataArr as $data)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td class="text-left">{{$data->name}}</td>
                                    <td class="text-left">{{$data->state->name}}</td>
                                    <td class="">{{$data->country->name}}</td>
                                    <td class="">{{$data->continent->name}}</td>
                                    <td class="text-left">{{round( $data->latitude, 2 )}}</td>
                                    <td class="text-left">{{round( $data->longitude, 2 )}}</td>
                                    <td>
                                        <select class="form-control update-status badge-{{ ( $data->status == 0 ) ? 'warning' : 'success' }}" name="status" data-id="{{$data->id}}" data-table="cities">
                                            <option value="1" {{($data->status == 1) ? 'selected' : ''}}>Active</option>
                                            <option value="0" {{($data->status == 0) ? 'selected' : ''}}>De-Active</option>
                                        </select>
                                    </td>
                                    <td class="text-left">{{$data->created_at}}</td>
                                    <td class="text-left">{{$data->updated_at}}</td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('city.edit'))
                                            <a class="btn btn-edit text-white" href="{{ route('admin.city.edit', $data->id) }}">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                        @endif

                                        @if (Auth::guard('admin')->user()->can('city.delete'))
                                            <a class="btn btn-danger text-white" href="{{ route('admin.city.destroy', $data->id) }}"
                                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $data->id }}').submit();">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>

                                            <form id="delete-form-{{ $data->id }}" action="{{ route('admin.city.destroy', $data->id) }}" method="POST" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
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
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true
            });
        }

     </script>
@endsection

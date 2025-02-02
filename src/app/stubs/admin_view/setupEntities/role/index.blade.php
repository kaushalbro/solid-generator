@extends('backend.master')
@section('title')
    Role | index
@stop
@section('breadcum')
    @include('backend.admin.includes.breadcum',['heading'=>"Role","sub_heading"=>'index'])
@stop
@section('content')
    @include("backend.admin.includes.errors")
    <div class="row ">
            <div class="col-12 text-right mb-2">
                <a href="{{ route('roles.create') }}" class="btn btn-primary" > Add Role</a>
            </div>
        <div class="col-12">
            <table class="table table-bordered datatable">
                <thead>
                <tr>
                    <th width="10px">S.N</th>
                    <th width="">Name</th>
                    <th width="15%">Total Permissions</th>
                    <th width="10px">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@stop
@push('scripts')
<script type="text/javascript">
    $(function () {
        $('.datatable').DataTable({
         serverSide: true,
         processing: true,
         order: [[0, 'desc']],
         ajax:{
            method: 'GET',
            url: "{{ route('roles.list') }}",
            data: function(d) {
               d.startDate = '';
               d.endDate = '';
                },
                dataType: "JSON",
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'permissions', name: 'permissions'},
                {data: 'action', name: 'action'},
            ]
        });
    });
        $(document).ready(function() {
            $("[name='DataTables_Table_0_length']").css("margin-right", "10px");
        });
</script>
@include("backend.admin.role.script")
@endpush

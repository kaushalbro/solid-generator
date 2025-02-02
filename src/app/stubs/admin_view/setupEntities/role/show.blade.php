@extends('backend.master')
@section('title')
    Role | show
@stop
@section('breadcum')
    @include('backend.admin.includes.breadcum',['heading'=>"Role","sub_heading"=>'show'])
@stop
@section('content')
    @include("backend.admin.includes.errors")
    <div class="row ">
        <div class="col-8">
            <table class="table">
                <thead>
                </thead>
                <tbody>
                <tr class="d-flex justify-content-between">
                    <td class=""><span class="text-bold">Name:</span> {{$role->name}}</td>
                </tr>
                <tr class="d-flex justify-content-between">
                    <td class=""> <span class="text-bold">Guard Name:</span> {{$role->guard_name}} </td>
                </tr>
                <tr class="d-flex justify-content-between">
                    <td class=""><span class="text-bold">Assigned To:</span><br>
                        @foreach($role->users as $user)
                            {{$user->name .','}}
                        @endforeach
                    </td>
                </tr>
                <tr class="d-flex justify-content-between">
                    <td class=""><span class="text-bold">Permissions:</span><br>
                        @foreach($role->permissions as $permission)
                            <span class="label label-primary">{{"|".$permission->name .' '}}</span>
                        @endforeach
                    </td>
                </tr>
                <tr class="d-flex justify-content-between">
                    <td class=""><span class="text-bold">Created At:</span> {{$role->created_at}}</td>
                </tr>
                <tr class="d-flex justify-content-between">
                    <td class=""><span class="text-bold">Updated At:</span>  {{$role->updated_at}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@stop
@push('scripts')
<script type="text/javascript">

</script>
@include("backend.admin.role.script")
@endpush


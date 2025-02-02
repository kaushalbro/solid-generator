@extends('backend.master')
@section('title')
    Role | edit
@stop
@section('breadcum')
    @include('backend.admin.includes.breadcum',['heading'=>"Role","sub_heading"=>'edit'])
@stop
@section('content')
    @include("backend.admin.includes.errors")
        <form class="input_form" action="{{ route('roles.update',['id' => $role->id])}}" method="POST" enctype="multipart/form-data">
    @csrf
            @method('PUT')
         <div class="card-body">
            @include("backend.admin.role.partial.form",['type'=>'edit'])
          </div>
    </form>
@stop
@push('scripts')
   @include("backend.admin.role.script")
@endpush

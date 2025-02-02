@extends('backend.master')
@section('title')
    Role | create
@stop
@section('breadcum')
    @include('backend.admin.includes.breadcum',['heading'=>"Role","sub_heading"=>'create'])
@stop
@section('content')
    @include("backend.admin.includes.errors")
    <form class="" action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
         <div class="card-body">
            @include("backend.admin.role.partial.form",['type'=>'create'])
          </div>
    </form>
@stop
@push('scripts')
   @include("backend.admin.role.script")
@endpush

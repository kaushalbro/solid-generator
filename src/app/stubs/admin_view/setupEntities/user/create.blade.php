@extends('backend.master')
@section('title')
    User | create
@stop
@section('breadcum')
    @include('backend.admin.includes.breadcum',['heading'=>"User","sub_heading"=>'create'])
@stop
@section('content')
    @include("backend.admin.includes.errors")
    <form class="" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
         <div class="card-body">
            @include("backend.admin.user.partial.form",['type'=>'create'])
          </div>
    </form>
@stop
@push('scripts')
   @include("backend.admin.user.script")
@endpush

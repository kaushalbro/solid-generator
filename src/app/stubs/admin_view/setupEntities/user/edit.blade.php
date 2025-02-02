@extends('backend.master')
@section('title')
    User | edit
@stop
@section('breadcum')
    @include('backend.admin.includes.breadcum',['heading'=>"User","sub_heading"=>'edit'])
@stop
@section('content')
    @include("backend.admin.includes.errors")
        <form class="input_form" action="{{ route('users.update',['id' => $user->id])}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
         <div class="card-body">
            @include("backend.admin.user.partial.form",['type'=>'edit'])
          </div>
    </form>
@stop
@push('scripts')
   @include("backend.admin.user.script")
@endpush

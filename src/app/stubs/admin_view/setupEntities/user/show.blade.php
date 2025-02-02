@extends('backend.master')
@section('title')
    User | show
@stop
@section('breadcum')
    @include('backend.admin.includes.breadcum',['heading'=>"User","sub_heading"=>'show'])
@stop
@section('content')
    @include("backend.admin.includes.errors")
    <div class="row ">
        <div class="col-12">

        </div>
    </div>
@stop
@push('scripts')
<script type="text/javascript">

</script>
@include("backend.admin.user.script")
@endpush


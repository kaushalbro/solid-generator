@php($side_bar=array_merge(config('sidebar'),
['User' =>['title' => 'User','permission' => [true],],
'Role' =>['title' => 'Role','permission' => [true]]]
))
@php($is_edit=$type=='edit'?:false)
<div class="row">
    <div class="col-md-6 d-flex mb-3">
        <label for="name" class="col-2 text-left col-form-label">Role Name:</label>
        <input type="text" value="{{old('name') ??($is_edit?$role->name:'')}}" name="name" class="form-control  col-3  name " id="name" placeholder="Name">
    </div>
    <div class="col-12">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="" style="width: 20%">Role</th>
                <th class="text-center" style="width: 16%">Full Access</th>
                <th class="text-center" style="width: 16%">View</th>
                <th class="text-center" style="width: 16%">Create</th>
                <th class="text-center" style="width: 16%">Edit</th>
                <th class="text-center" style="width: 16%">Delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach($side_bar as $key => $model)
                @if(isset($model['permission']) && isset($model['permission'][0]) && $model['permission'][0])
                    @php($title=$model['title'])
                    @php($permission_name=\Illuminate\Support\Str::lower($title))
                    <tr>
                        <td class="text-bold">{{$title}}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <input class="full_access align_check_box" type="checkbox" name="permissions[{{$permission_name.'-full-access'}}]" id="{{$permission_name.'-full-access'}} full_access"
                                    {{($is_edit && $role->permissions->where('name',$permission_name.'-full-access')->count()>0)?'checked':''}}
                                >
                            </div>
                        </td>
                        <td >
                            <div class="d-flex justify-content-center">
                                <input class="align_check_box" type="checkbox" name="permissions[{{$permission_name.'-view'}}]" id="{{$permission_name.'-view'}}"
                                {{($is_edit && $role->permissions->where('name',$permission_name.'-view')->count()>0)?'checked':''}}
                                >
                            </div>
                        </td>
                        <td >
                            <div class="d-flex justify-content-center">
                                <input class="align_check_box" type="checkbox" name="permissions[{{$permission_name.'-create'}}]" id="{{$permission_name.'-create'}}"
                                    {{($is_edit && $role->permissions->where('name',$permission_name.'-create')->count()>0)?'checked':''}}
                                >
                            </div>
                        </td>
                        <td >
                            <div class="d-flex justify-content-center">
                                <input class="align_check_box" type="checkbox" name="permissions[{{$permission_name.'-edit'}}]" id="{{$permission_name.'-edit'}}"
                                    {{($is_edit && $role->permissions->where('name',$permission_name.'-edit')->count()>0)?'checked':''}}
                                >
                            </div>
                        </td>
                        <td >
                            <div class="d-flex justify-content-center">
                                <input class="align_check_box" type="checkbox" name="permissions[{{$permission_name.'-delete'}}]" id="{{$permission_name.'-delete'}}"
                                    {{($is_edit && $role->permissions->where('name',$permission_name.'-delete')->count()>0)?'checked':''}}
                                >
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.align_check_box').css({
                'height': '25px',
                'width': '25px',
                'padding': '10px'
            });
        });
    </script>
@endpush
@include("backend.admin.includes.form_footer")

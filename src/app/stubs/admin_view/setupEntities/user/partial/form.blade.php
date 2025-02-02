@php($is_edit=$type=='edit'?:false)
<div class="row">
    <div class="col-md-6 d-flex mb-3">
        <label for="name" class="col-2 text-left col-form-label">Name:</label>
        <input type="text" value="{{old("name")??($is_edit?$user->name:'')}}" name="name" class="form-control  col-10  name {{$errors->has("name")?"is-invalid":""}}" id="name" placeholder="Name">
    </div>
    <div class="col-md-6 d-flex mb-3">
        <label for="email" class="col-2 text-left col-form-label">Email:</label>
        <input type="email" name="email" class="form-control  {{$errors->has("email")?"is-invalid":""}}"  id="email" placeholder="Email" value="{{old("email")??($is_edit?$user->email:'')}}">
    </div>
    <div class="col-md-6 d-flex mb-3">
        <label for="role" class="col-2 text-left col-form-label">Role:</label>
        <select name="role" id="role"  class="form-control {{$errors->has("role")?"is-invalid":""}}">
            <option value="" selected>Select Role</option>
            @foreach($roles as $role)
                <option value="{{$role->id}}" {{(old('role')?? (isset($user->roles[0])?$user->roles[0]->id:null) ==$role->id)?'selected':''}} >{{$role->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 d-flex mb-3">
        <label for="image" class="col-2 text-left col-form-label">Image:</label>
        <input  type="file" value="{{old('image')}}" name="image" id="image formFileMultiple"   {{$errors->has("image")?"is-invalid":""}}" multiple>
    </div>
    <div class="col-md-6 d-flex mb-3">
        <label for="password" class="col-2 text-left col-form-label">Password:</label>
        <input autocomplete="new-password" type="password" name="password" class="form-control {{$errors->has("password")?"is-invalid":""}}" id="password" placeholder="Password" value="{{old("password")}}" >
    </div>
    <div class="col-md-6 d-flex mb-3">
        <label for="confirm-password" class="col-2 text-left col-form-label">Confirm Password:</label>
        <input autocomplete="new-password-confirm" type="password" name="confirm-password" class="form-control {{$errors->has("confirm-password")?"is-invalid":""}}" id="confirm-password" placeholder="Confirm Password" value="{{old("confirm-password")}}">
    </div>
    <div class="col-md-6 d-flex mb-3">
        <label for="status" class="col-2 text-left col-form-label">Status:</label>
        <input type="checkbox" name="status" class="form-control status " id="status"
               data-toggle="toggle"
               data-on="active" data-off="inactive" {{ old("status")?"checked":"" }} data-onstyle="primary" data-offstyle="danger">
    </div>
</div>

@include("backend.admin.includes.form_footer",['type'=>'create'])

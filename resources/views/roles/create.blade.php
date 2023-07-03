@extends('layouts.app')

@section('title')
    Add User
@endsection

@section('content')
<div class="container border border-2" style="width: 50%">
    <p class="text-center fs-2">Create Roles</p>
    <form action="{{route('roles.store')}}" class="form" method="post">
        @csrf
        <div class="form-group container">     
            <label for="" class="form-label mt-2 mb-2 fs-6">Role Name</label> 
            <input placeholder="" class="form-control mb-2" name="name" type="text" value="">
        </div>
        <div class="permission-container" style="">
            <p class="fs-4 text-center">Permissions</p>
            @foreach($permissions as $permission)
            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="m-2" />{{ $permission->name }}_user <br>
            @endforeach
        </div>
        <div class="btn-container d-flex justify-content-center " style="min-width: 100%;">
        <button type="submit" class="btn btn-success mt-5">
            Submit
        </button>
        </div>
    </form>
</div>
@endsection

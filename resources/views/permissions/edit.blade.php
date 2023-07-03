@extends('layouts.app')

@section('title')
    Update Permission
@endsection

@section('content')
<div class="container border border-2 " style="width: 50%">
    <p class='text-center fs-3 m-4'>Edit Permission</p>
    <form action="{{route('permissions.update',['id'=>$permission->id])}}" class="form" method="post">
        @csrf
        <div class="form-group container">
            <label for="" class="form-label mt-2 mb-2 fs-6">Permission Name</label>
            <input placeholder="permission name" class="form-control mb-2" name="name" type="text" value="{{$permission->name}}">
            <button type="submit" class="btn btn-success mt-2">
                Submit
            </button>
        </div>
    </form>
</div>
@endsection

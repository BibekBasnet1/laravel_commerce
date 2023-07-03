{{-- this is for the layout of the laravel --}}
@extends('layouts.app')

{{-- to give title for the page --}}
@section('title')
    Roles Edit
@endsection

{{-- to give the content for the page --}}
@section('content')
<div class="container border border-2" style="width: 50%">
    <p class="text-center fs-3">Roles </p>
    <form action="{{route('roles.update',['id' => $roles->id])}}" method="post">
        {{-- we need to pass the csrf token for each user as we need it very much --}}
        @csrf
        <div class="form-group">
            {{-- to take the form input for the name --}}
            <label for="" class="form-label mt-2 mb-2">Name</label>
            <input placeholder="Name" class="form-control" name="name" type="text" value="{{$roles->name}}">
            {{-- <input placeholder="Email" class="form-control" name="price" type="number" value="{{$roles->}}"> --}}           
        </div>
    <table>

        <p class="fs-5 mt-3 text-center">Associated Authority </p>
        {{-- @foreach ($permissions as $key => $permission_value)
                {{$permission_value->name}}
        @endforeach --}}
        {{-- check for the permission that has been granted for the current user --}}
        @foreach ($permissions as $permission)
        <div>
            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="m-2" @if ($roles->permissions->contains('id', $permission->id)) checked @endif>
            {{ $permission->name }}
        </div>
        @endforeach

    </table>
    <div class="btn-container d-flex justify-content-center " style="min-width: 100%;">
    <button type="submit" class="btn btn-primary mt-4 ">
        Submit
    </button>
    </div>
</form>
</div>

@endsection


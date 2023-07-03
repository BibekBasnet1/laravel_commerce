@extends('layouts.app')

@section('title')
    Users Create
@endsection

@section('content')
<div class="container border border-2" style="width: 50%">

    <p class="text-center fs-3">Create User</p>
 
    {{-- this is used to show if any errors has actually occurred and inform the user --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{route('users.createUser')}}" method="post">
        {{-- we need to pass the csrf token for each user as we need it very much --}}
        @csrf
        <div class="form-group">

            <label for="" class="form-label mt-2 mb-2 fs-6">Name</label>
            <input placeholder="" class="form-control" name="name" type="text" value="">
            <label for="" class="form-label mt-2 mb-2 fs-6">Email</label>
            <input placeholder="" class="form-control" name="email" type="email" value="">
            <label for="" class="form-label mt-2 mb-2 fs-6">Password</label>
            <input placeholder="" class="form-control" name="password" type="password" value="">
            <label for="" class="form-label mt-2 mb-2 fs-6" name="nickname">NickName</label>
            <input type="text" class="form-control" name="nickname" placeholder="">
            <label for="" class="form-label mt-2 mb-2 fs-6">User Role</label>
                  
            {{-- this is for the user role column  --}}
            <input type="hidden" name="user" value="{{ $userId }}">
            <label for="" class="form-label mt-2 mb-2 fs-6">User Role</label>
            <select name="role" class="form-control">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary mt-4">
                Submit
            </button>
            
        </div>
    </form>
</div>
@endsection


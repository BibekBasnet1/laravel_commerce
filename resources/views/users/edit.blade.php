@extends('layouts.app')

@section('title')
    Users Edit
@endsection

@section('content')
<div class="container border border-2" style="width: 50%">
    <p class="text-center fs-3">User Edit</p>
    <form action="{{route('users.update',['id' => $user->id])}}" method="post">
        {{-- we need to pass the csrf token for each user as we need it very much --}}
        @csrf
        <div class="form-group">
            <label for="" class="form-label mt-2 mb-2 fs-6">User Name</label>
            <input placeholder="Name" class="form-control" name="name" type="text" value="{{$user->name}}">
            <label for="" class="form-label mt-2 mb-2 fs-6">User email</label>
            <input placeholder="Email" class="form-control" name="email" type="email" value="{{$user->email}}">
            <button type="submit" class="btn btn-primary mt-3">
                Submit
            </button>
        </div>
    </form>
</div>
@endsection


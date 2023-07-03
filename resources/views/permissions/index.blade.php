@extends('layouts.app')

@section('title')
    Permission Details
@endsection

@section('content')
<div class="container">

    {{-- for creating a new Product --}}
    <h2>Create A new Authority</h2>
    <a href="{{route('permissions.create')}}" class="btn btn-primary mb-5">
        Add Authority
    </a><br>
<table class="table">
    <thead>
        <th>Id</th>
        <th>Name</th>
        <th>Action</th>
    </thead>
    <tbody>
        {{-- Looping through Users --}}
        @php
            $count = 0;
        @endphp
        {{-- for displaying the data that comes as the associative array --}}
        @foreach($permissions as $key => $permission)
        <tr>
            @php
                ++$count;
            @endphp
            <td>{{$count}}</td>
            <td>{{$permission->name}}</td>
            <td class="d-flex">
                {{-- for deleteting the product based on the id of the product--}}
                <a href="{{route('permissions.edit',['id'=>$permission->id])}}" class="btn btn-success ">Edit</a>

                {{-- to delete the product based on the id provided --}}
                <form action="{{route('permissions.destroy',['id'=>$permission->id])}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection
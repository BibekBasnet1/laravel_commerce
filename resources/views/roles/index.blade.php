@extends('layouts.app')

@section('title')
    User Details
@endsection

@section('content')
<div class="container">

    <table class="table">
        <thead>
            <th>Id</th>
            <th>Name</th>
            <th>Action</th>
        </thead>
        {{-- it is used to add  a new role --}}
        <p class="fs-3">Add Roles</p>
        <a href="{{route('roles.create')}}" class="btn btn-success">Add</a>
        <tbody>
            @php
                $count = 0;
            @endphp
            @foreach ($userRoles as $key => $roll)
                <tr class="">
                    <td>{{ ++$count }}</td>
                    <td>{{ $roll->name }}</td>
                    <td>
                        {{-- when being clicked id is passed on which student we are giving authorization to   --}}
                        <td class="d-flex">
                            <a href="{{route('roles.edit',['id'=>$roll->id])}}" class="btn btn-info">Update</a>
                            {{-- <a href="" class="btn btn-primary">Edit</a> --}}
                             {{-- to delete the product based on the id provided --}}
                            <form action="{{route('roles.destroy',['id'=>$roll->id])}}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form> 
                        </td>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('script')

@endsection

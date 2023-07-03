@extends('layouts.app')

@section('title')
    Categories
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
        <p class="fs-3">Add Category</p>
        {{-- this will redirect to the categories section  --}}
        <a href="{{route('categories.create')}}" class="btn btn-success">Add</a>
        <tbody>
            @php
                $count = 0;
            @endphp
            @foreach ($categories as $key => $category)
                <tr class="">
                    <td>{{ ++$count }}</td>
                    <td>{{$category->name}}</td>
                        {{-- when being clicked id is passed on which student we are giving authorization to   --}}
                        <td class="d-flex">
                            <a href="{{route('categories.edit',['id'=>$category->id])}}" class="btn btn-info ">Edit</a>
                            {{-- <a href="" class="btn btn-primary">Edit</a> --}}
                             {{-- to delete the product based on the id provided --}}
                            <form action="{{route('categories.destroy',['id'=>$category->id])}}" method="post">
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

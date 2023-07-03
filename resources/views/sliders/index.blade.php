@extends('layouts.app')

@section('title')
    Slider 
@endsection

@section('content')
<div class="container">

    <table class="table">
        <thead>
            <th>Id</th>
            <th>Name</th>
            <th>Caption</th>
            <th>Image</th>
            <th>Action</th>
            <th></th>
        </thead>
        {{-- it is used to add  a new role --}}
        <p class="fs-3">Add Slider</p>
        <a href="{{route('sliders.create')}}" class="btn btn-success">Add</a>
        <tbody>
            @php
                $count = 0;
            @endphp
            @foreach ($sliders as $key => $slider)
                <tr class="">
                    <td>{{ ++$count }}</td>
                    <td>{{ $slider->name }}</td>
                    <td>{{$slider->caption}}</td>
                    <td>{{$slider->image}}</td>
                        {{-- when being clicked id is passed on which student we are giving authorization to   --}}
                        <td class="d-flex">
                            <a href="{{route('sliders.edit',['id'=>$slider->id])}}" class="btn btn-info">Edit</a>
                            {{-- <a href="" class="btn btn-primary">Edit</a> --}}
                             {{-- to delete the product based on the id provided --}}
                            <form action="{{route('sliders.destroy',['id'=>$slider->id])}}" method="post">
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

@section('script')

@endsection

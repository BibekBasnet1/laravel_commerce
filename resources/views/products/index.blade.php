@extends('layouts.app')
@section('title')
    User Details
@endsection

@section('content')
<div class="container">

    {{-- for creating a new Product --}}
    <h2>Create A New Product</h2>
    <a href="{{route('products.create')}}" class="btn btn-primary mb-5">
        New Product
    </a><br>
    <h2>Deleted Items</h2>
    <a href="{{route('products.deletedData')}}" class="btn btn-primary">DeleteItems</a>

<table class="table">
    <thead>
        <th>Product Id</th>
        <th>Name</th>
        <th>Price</th>
        <th>Category</th>
        <th>Created By</th>
        <th>Image</th>
        <th>Action</th>
    </thead>
    <tbody>
        {{-- Looping through Users --}}
        @php
            $count = 0;
        @endphp
        {{-- for displaying the data that comes as the associative array --}}
        @foreach($products as $key => $product)
        @php
            ++$count;
        @endphp

        <tr>
            <td>{{$count}}</td>
            <td>{{$product->name}}</td>
            <td>{{$product->price}}</td>
            <td>isset($product->category->name)</td>
            <td>{{$product->user->name ?? 'N/A'}}</td>
            <td>
           
                {{-- <img src="{{asset('images/'.$product->image)}}" style="width: 40%;" alt=""> --}}
                @if (File::exists(public_path($product->image)))
                    <img style="width:20%;height:20%;" src="{{ asset($product->image) }}" alt="">
                @else
                    <img style="width:20%;height:20%;" src="{{ asset('images/' .$product->image) }}" alt="">
                @endif

            </td>

            <td class="d-flex">
           
                <a href="{{route('products.edit',['id'=>$product->id])}}" class="btn btn-success ">Edit</a>

                    <form action="{{route('products.destroy',['id'=>$product->id])}}" method="post">
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

{{--  to display the all the user --}}

{{-- this is for the layout of the laravel --}}
@extends('layouts.app')

{{-- to give title for the page --}}
@section('title')
    Product Restore
@endsection

{{-- to give the content for the page --}}
@section('content')

    <div class="container">

        <a href="{{route('products.index')}}" class="btn btn-success">Go Back</a>

        <table class="table">
            <thead>
                <th>Product Id</th>
                <th>Name</th>
                <th>Price</th>
                <th>Created By</th>
                <th>Action</th>
            </thead>
            <tbody>
                {{-- Looping through Users --}}
                @php
                    $count = 0;
                @endphp
                {{-- for displaying the data that comes as the associative array --}}
                @foreach($products as $key => $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->user->name}}</td>
                    <td class="d-flex">

                        {{-- to delete the product based on the id provided --}}
                        <form action="{{route('products.restore',['id'=>$product->id])}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-info">Restore</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection




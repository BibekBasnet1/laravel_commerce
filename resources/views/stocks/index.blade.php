@extends('layouts.app')

@section('title')
    Stocks
@endsection

@section('content')
<div class="container">

    <table class="table">
        <thead>
            <th>Id</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Action</th>
        </thead>
        {{-- it is used to add  a new role --}}
        <p class="fs-3">Create Product Stock</p>
        <a href="{{route('stocks.create')}}" class="btn btn-success">Add </a>
        <tbody>
            @php
                $count = 0;
            @endphp
            @foreach ($stocks as $stock)
                <tr class="">
                    <td>{{ ++$count }}</td>
                    <td>{{$stock->name}}</td>
                    <td>{{$stock->quantity}}</td>
                    {{-- <td></td> --}}
                        {{-- when being clicked id is passed on which student we are giving authorization to   --}}
                        <td class="d-flex">
                            <a href="{{route('stocks.edit',['id'=>$stock->id])}}" class="btn btn-info">Edit</a>
                            {{-- <a href="" class="btn btn-primary">Edit</a> --}}
                             {{-- to delete the product based on the id provided --}}
                            <form action="{{route('stocks.destroy',['id'=>$stock->id])}}" method="post">
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




{{-- this is for the layout of the laravel --}}
@extends('layouts.app')

{{-- to give title for the page --}}
@section('title')
    Product Edit
@endsection

{{-- to give the content for the page --}}
@section('content')
<div class="container border border-2 fs-3" style="width: 50%">
    <p class=text-center>Edit Product</p>
    <form action="{{route('products.update',['id' => $product->id])}}" method="post" enctype="multipart/form-data">
        {{-- we need to pass the csrf token for each user as we need it very much --}}
        @csrf
        <div class="form-group">
            <label for="" class="form-label mt-2 mb-2 fs-6">Product Name</label>
            <input placeholder="Product Name" class="form-control" name="name" type="text" value="{{$product->name}}">
            <label for="" class="form-label mt-2 mb-2 fs-6">Product Price</label>
            <input placeholder="Product Price" class="form-control" name="price" type="number" value="{{$product->price}}">
            <label for="" class="form-label mt-2 mb-2 fs-6">Product Image</label>
            <input placeholder="" class="form-control mb-2" name="image"  type="file">
            <button type="submit" class="btn btn-primary mt-3">
                Submit
            </button>
        </div>
    </form>
</div>
@endsection


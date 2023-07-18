@extends('layouts.app')

@section('title')
    Add Product
@endsection

@section('content')
<div class="container border border-2" style="width: 50%">
    <p class="text-center fs-3">Create Product</p>
    <form action="{{route('products.store')}}" class="form" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group container">
            <label for="" class="form-label mt-2 mb-2 fs-6">Product Name</label>
            <input placeholder="" class="form-control mb-2" name="name" type="text" value="">
            <label for="" class="form-label mt-2 mb-2 fs-6">Product Price</label>
            <input placeholder="" class="form-control mb-2" name="price" type="number" value="">
            <label for="" class="form-label mt-2 mb-2 fs-6">Category</label>
            <select name="category_id" class="form-select">
                @foreach ($categoryProducts as $key=> $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>            
            <label for="" class="form-label mt-2 mb-2 fs-6">Product Image</label>
            <input placeholder="" class="form-control mb-2" name="image" type="file">

            <label for="" class="form-label mt-2 mb-2 fs-6">No of Stock</label>
            <input placeholder="" class="form-control mb-2" name="stock" type="number">

            <button type="submit" class="btn btn-success mt-2">
                Submit
            </button>
        </div>
    </form>
</div>
@endsection

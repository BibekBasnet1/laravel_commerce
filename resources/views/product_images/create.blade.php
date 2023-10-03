@extends('layouts.app')

@section('title')
    Add Product Images
@endsection

@section('content')
    <div class="container ">

        <div class="title-container">
            <h1>Add Image to The product</h1>
            <button class="btn btn-primary mb-5">Add Image To Product</button>
        </div>

        <form  action="{{route('productImages.store')}}" enctype="multipart/form-data" method="post" class="w-50">
            @csrf
            <div class="mb-3">

              <label for="productName" class="form-label fs-5">Select Product</label><br>
              
              <select name="productId" id="productName" class="w-100 p-1">

                  @foreach($productsDetails as $product)
                        <option value="{{$product->id}}">
                            {{$product->name}}
                        </option>
                  @endforeach

              </select>
              
            </div>

            <div class="mb-3">

                <label for="" class="form-label fs-5">Add Color</label>
                <select name="productColor" id="" class="w-100 p-1">
                    @foreach($productColors as $productColor)
                        <option value="{{$productColor->id}}">{{$productColor->name}}</option>
                    @endforeach
                </select>

            </div>

            <div class="mb-3">

              <label for="exampleInputPassword1" class="form-label fs-5">Add Image</label>
              <br>
              <input type="file" class="form-control" name="image" value="image">

            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
          
        </form>
    
    </div>
@endsection

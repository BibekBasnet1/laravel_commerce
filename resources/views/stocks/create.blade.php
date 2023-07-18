@extends('layouts.app')

@section('title')
    Stocks Create
@endsection

@section('content')
<div class="container border border-2" style="width: 50%">

    <p class="text-center fs-3">Create Stocks</p>
 
    {{-- this is used to show if any errors has actually occurred and inform the user --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{route('stocks.store')}}" method="post">
        {{-- we need to pass the csrf token for each user as we need it very much --}}
        @csrf
        <div class="form-group">
            {{-- {{dd($products)}} --}}
            <label for="product_id" class="form-label mt-2 mb-2 fs-6">Product</label>
            <select name="product_id" id="product_id" class="form-select">
            @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
            </select>

            {{-- for the quantity --}}
            <label for="quantity" class="form-label mt-2 mb-2 fs-6">Quantity</label>
            <input type="text" name="quantity" class="form-control">
        
            <button type="submit" class="btn btn-primary mt-4">
                Submit
            </button>
            
        </div>
    </form>
</div>
@endsection


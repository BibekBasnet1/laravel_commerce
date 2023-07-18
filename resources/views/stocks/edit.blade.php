{{-- this is for the layout of the laravel --}}
@extends('layouts.app')

{{-- to give title for the page --}}
@section('title')
    Stocks Edit
@endsection

{{-- to give the content for the page --}}
@section('content')
<div class="container border border-2" style="width: 50%">
    <p class="text-center fs-3">Stocks</p>
    {{-- it is not actually stock it is proudct-id of the stock --}}
    <form action="{{route('stocks.update',['id' => $stock->id])}}" method="post">
        {{-- we need to pass the csrf token for each user as we need it very much --}}
        @csrf
        <div class="form-group">

            <select name="product_id" class="form-select">
                {{-- @foreach ($stocks as $stock) --}}
                    {{-- @foreach($slider['category'] as $item) --}}
                    <option value="{{$stock->id}}">{{$product}}</option>
                    {{-- @endforeach --}}
                {{-- @endforeach --}}
            </select>         

            {{-- to take the form input for the name --}}
            {{-- @foreach ($stocks as $stock) --}}
            {{-- @endforeach --}}
            <label for="" class="form-label mt-2 mb-2">Quantity</label>
            <input placeholder="quantity" class="form-control" name="quantity" type="text" value="{{$stock->quantity}}">
              
        
        </div>
 
    <div class="btn-container d-flex justify-content-center " style="min-width: 100%;">
    <button type="submit" class="btn btn-primary mt-4 ">
        Submit
    </button>
    </div>
</form>
</div>

@endsection


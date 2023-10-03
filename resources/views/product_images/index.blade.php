@extends('layouts.app')

@section('title')
    Product Images
@endsection

@section('content')
    <div class="container">
        
        <h1>Add Image to The product</h1>
        <a href="{{route('productImages.create')}}">

            <button class="btn btn-primary mb-5">Add Image To Product</button>
        </a>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.N</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Image</th>
                    <th scope="col">Product Color</th>
                </tr>
            </thead>
            @php
                $count = 0;
            @endphp
            <tbody>
                @foreach ($products as $product)
                @foreach ($product->images as $prod)
                    @php
                        $count++;
                    @endphp
                    <tr>
                        <th scope="row">{{ $count }}</th>
                        <td>{{ $product->name }}</td>
            
                        <td>
                            @if (File::exists(public_path($prod->image)))
                                <img style="width:150px;height:100px;" src="{{ asset($prod['image_path']) }}" alt="">
                            @else
                                <img style="width:150px;height:100px;" src="{{ asset('images/' . $prod['image_path']) }}" alt="">
                            @endif
                        </td>
            
                        {{-- Filter and loop through relevant $productImages --}}
                        @php
                            $relevantProductImages = $productImages->where('product_id', $product['id']);
                        @endphp
            
                        @foreach ($relevantProductImages as $productImage)
                            <td>{{ $productImage->product_color->name ?? '' }}</td>
                        @endforeach
            
                    </tr>
                @endforeach
            @endforeach
            

            </tbody>
        </table>
    </div>
@endsection

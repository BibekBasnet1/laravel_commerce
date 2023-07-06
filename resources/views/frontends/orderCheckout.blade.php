@extends('layouts.frontend')

@section('style')
    <style>
        

    </style>
@endsection
@section('title')
    Order Checkout
@endsection

@section("home")
    {{-- this is the main container  --}}
    <main class="d-flex justify-content-center row">

        {{-- This is used for paragraph container  --}}
        <div class="para col">
            <p class="fs-3">Confirmed Order</p>
        </div>
        <div class="information-container">    
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">S.N</th>
                        <th scope="col">Products</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                @php
                    $count = 0;
                @endphp
                <tbody>
                    {{-- @foreach ($userorders as $index => $userOrder) --}}
                    @php
                    // count the total number of elements in the json object
                    $count = count(json_decode($userOrder->order_details));
                    // dd(json_decode($userOrder->order_details));
                    $i = 0;
                    if($count == 0 )
                    {
                        return;
                    }
                    @endphp

                        <tbody>
                            @foreach (json_decode($userOrder->order_details) as $order)
                           @php
                               ++$i;
                           @endphp 
                            <tr scope='row'>
                                <td>{{$i}}</td>        
                                    <td>{{ $order->name }}</td>
                                    <td>{{$order->price}}</td>
                            </tr>
                                                                            
                           @endforeach
                           
                        </tbody>
                        
                        
                        <tr class="col">
                            <td colspan="3">
                                <p class="fs-5 text-end me-5 text-success">
                                    Total : {{$userOrder->total}}
                                </p>
                            </td>
                        </tr>                    
              
                </tbody>
            </table>
            <button class="btn btn-primary">
                Download Receipt
            </button>
        </div>
    </main>
@endsection

@section('script')
    <script>

    </script>
@endsection
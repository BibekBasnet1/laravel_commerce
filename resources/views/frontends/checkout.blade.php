@extends('layouts.frontend')

@section('title')
    Checkout
@endsection

@section('style')
@endsection

@section('home')
    <div class="container d-flex justify-content-center align-items-center vh-100">

        @php

            // for random string
            function random_string($length) {
                $key = '';
                $keys = array_merge(range(0, 9), range('a', 'z'));

                for ($i = 0; $i < $length; $i++) {
                    $key .= $keys[array_rand($keys)];
                }

                return $key;
            }
            
            $total_amount = "100";
            $transaction_uuid = random_string(10);
            $product_code = "EPAYTEST";

            $secretKey = "8gBm/:&EnhH.1/q";

            $signed_field_names = "total_amount,transaction_uuid,product_code";

            $data = "total_amount={$total_amount},transaction_uuid={$transaction_uuid},product_code={$product_code}";

            $signature = base64_encode(hash_hmac('sha256', $data, $secretKey, true));
            

        @endphp



        <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST" class="esewa-form">
            <input type="text" id="amount" name="amount" value="{{$total_amount}}" required>
            <input type="text" id="tax_amount" name="tax_amount" value ="0" required>
            <input type="text" id="total_amount" name="total_amount" value={{$total_amount}} required>
            <input type="text" id="transaction_uuid" name="transaction_uuid" value={{random_string(10)}} required>
            <input type="text" id="product_code" name="product_code" value ={{$product_code}} required>
            <input type="text" id="product_service_charge" name="product_service_charge" value="0" required>
            <input type="text" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
            <input type="text" id="success_url" name="success_url" value="https://esewa.com.np" required>
            <input type="text" id="failure_url" name="failure_url" value="https://google.com" required>
            <input type="text" id="signed_field_names" name="signed_field_names" 
                value="total_amount,transaction_uuid,product_code"
                 required>
            <input type="text" id="signature" name="signature" value={{$signature}}  required>
            <input value="Submit" type="submit">
        </form>
       
            <div class="row border border-1 p-2">
                <p class="fs-3 text-center">Checkout</p>
                <div class="col">
                    <!-- Card -->
                    <div>
                        @php
                            $totalAmount = 0;
                            $itemPrice = [];
                            $orderDetails = [];
                        @endphp

                         @foreach ($products as $product)
            {{-- {{dd($products)}} --}}
            <div class="card-body border">
                <h5 class="card-title p-2 m-2">Product: <span style="color: #fc6000;">{{ $product->name }}</h5>
                <p class="card-quantity p-2 m-2 fs-5">Quantity * <span
                        style="color: #fc6000;">{{ $product->quantity }}</span></p>
                <p class="card-text p-2 m-2 price">Price: <span style="color: #fc6000;">{{ $product->price }}
                </p>
                @php
                    array_push($itemPrice, $product->price * $product->quantity);
                    $orderDetails[] = [
                        'name' => $product->name,
                        'price' => $product->price * $product->quantity,
                    ];
                @endphp
            </div>
            @endforeach

            @foreach ($itemPrice as $price)
                @php
                    $totalAmount += $price;
                @endphp
            @endforeach

            <div class="card-footer">
                Total Amount:
                <p class="card-text text-success fs-5 text-end mt-2 totalPrice">

                    {{ $totalAmount }}
                </p>
            </div>
    </div>
    </div>

    <div class="row mt-4 p-4 ">
        <div class="form-check col">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
                Cash
            </label>
        </div>

        <div class="form-check col">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
            <label class="form-check-label" for="flexRadioDefault2">

                Esewa
            </label>
        </div>

    </div>
    <div class="row">
        <a href="" class="btn btn-primary mt-4 btn-submit w-100">
            Cash
        </a>
    </div>

    <div class="row">
        <a href="" class="btn btn-success esewaBtn mt-4 btn-submit w-100">
            Pay With Esewa
        </a>
    </div>

    </div>

    </div>
@endsection

@section('script')
    <script>
        const btn = document.querySelector('.btn-submit');
        btn.addEventListener('click', (e) => {
            // To prevent the default form submission
            e.preventDefault();

            // Create an array to store the order details
            const orderDetails = [];

            // Iterate over the card elements to extract product information
            const cardElements = document.querySelectorAll('.card-body');
            cardElements.forEach(card => {
                // taking out the price of the card and pushing it into the object 
                const name = card.querySelector('.card-title').textContent.replace('Product: ', '');
                const price = card.querySelector('.card-text').textContent.replace('Price: ', '');
                const quantity = card.querySelector('.card-quantity').textContent.replace('Quantity *', '');
                // const price = parseFloat(priceAmount * quantity);
                orderDetails.push({
                    name,
                    price,
                    quantity
                });
            });

            // Calculate the total amount for the each product

            let totalAmount = 0;
            orderDetails.forEach(item => {
                totalAmount += parseFloat(item.price * item.quantity);
            });

            // for the validation if the order has not been placed at all
            if (totalAmount == 0) {
                toastr.info("Please place Order first");
                return;
            }

            // Create the POST request body
            const requestBody = {
                order_details: orderDetails,
                total: totalAmount,
            };


            // Send the POST request using fetch
            fetch('order/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify(requestBody, totalAmount),
                })


                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        url = `checkout/order/items/` + data.orderId;
                        window.location.replace(url);
                        toastr.success("Order Placed");
                    } else {
                        toastr.info(data.message);
                    }

                })
                .catch(error => {
                    console.error(error);
                    // toastr.warning("Something went wrong");

                });
        });

        const esewaBtn = document.querySelector('.esewaBtn');
        const productAmount = document.querySelector('#amount');

        const submitEsewa = document.querySelector('.esewa-form');

        const totalPriceProducts = document.querySelector(".totalPrice").textContent.trim();

        esewaBtn.addEventListener('click', (e) => {
            e.preventDefault();

            submitEsewa.submit();

        })
    </script>
@endsection

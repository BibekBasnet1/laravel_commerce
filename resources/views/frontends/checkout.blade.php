@extends('layouts.frontend')

@section('title')
    Checkout
@endsection

@section('style')
@endsection

@section('home')
    <div class="container d-flex justify-content-center align-items-center vh-100">

        @php

            $signed_field_names = 'total_amount,transaction_uuid,product_code';

        @endphp



        <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST" class="esewa-form"
            {{-- style="display:none;" --}}>
            <input type="text" id="amount" name="amount" value="0" required>
            <input type="text" id="tax_amount" name="tax_amount" value ="0" required>
            <input type="text" id="total_amount" name="total_amount" value="0" required>
            <input type="text" id="transaction_uuid" name="transaction_uuid" value="" required>
            <input type="text" id="product_code" name="product_code" value ="" required>
            <input type="text" id="product_service_charge" name="product_service_charge" value="0" required>
            <input type="text" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
            <input type="text" id="success_url" name="success_url" value="" required>
            <input type="text" id="failure_url" name="failure_url" value="https://google.com" required>
            <input type="text" id="signed_field_names" name="signed_field_names"
                value="total_amount,transaction_uuid,product_code" required>
            <input type="text" id="signature" name="signature" value="" required>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/hmac-sha256.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/enc-base64.min.js"></script>
    <script>
        const btn = document.querySelector('.btn-submit');
        let orderId = 0;

        function placeOrder() {

            const orderDetails = [];

            const cardElements = document.querySelectorAll('.card-body');
            cardElements.forEach(card => {

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


            let totalAmount = 0;
            orderDetails.forEach(item => {
                totalAmount += parseFloat(item.price * item.quantity);
            });

            if (totalAmount == 0) {
                toastr.info("Please place Order first");
                return;
            }


            const requestBody = {
                order_details: orderDetails,
                total: totalAmount,
            };

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
                        // url = `checkout/order/items/` + data.orderId;
                        // window.location.href = url
                        orderId= data.orderId;
                        toastr.success("Order Placed");
                    } else {
                        toastr.info(data.message);
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }


        btn.addEventListener('click', (e) => {
    
            e.preventDefault();

            const orderDetails = [];

            const cardElements = document.querySelectorAll('.card-body');
            cardElements.forEach(card => {
 
                const name = card.querySelector('.card-title').textContent.replace('Product: ', '');
                const price = card.querySelector('.card-text').textContent.replace('Price: ', '');
                const quantity = card.querySelector('.card-quantity').textContent.replace('Quantity *', '');

                orderDetails.push({
                    name,
                    price,
                    quantity
                });
            });

            let totalAmount = 0;
            orderDetails.forEach(item => {
                totalAmount += parseFloat(item.price * item.quantity);
            });

            
            if (totalAmount == 0) {
                toastr.info("Please place Order first");
                return;
            }

            
            const requestBody = {
                order_details: orderDetails,
                total: totalAmount,
            };


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
                        window.location.href = url
                        toastr.success("Order Placed");
                    } else {
                        toastr.info(data.message);
                    }

                })
                .catch(error => {
                    console.error(error);
            });

        });



        const esewaBtn = document.querySelector('.esewaBtn');
        const productAmount = document.querySelector('#amount');
        const totalAmountForm = document.querySelector('#total_amount');
        const success_return = document.querySelector('#success_url');
        const product_code_value = document.querySelector('#product_code');
        const transaction_uuid_values = document.querySelector('#transaction_uuid');
        const signature = document.querySelector('#signature');
        const submitEsewa = document.querySelector('.esewa-form');

        const totalPriceProducts = document.querySelector(".totalPrice").textContent.trim();

        esewaBtn.addEventListener('click', (e) => {

            e.preventDefault();

            productAmount.value = totalPriceProducts;
            const product_code = "EPAYTEST";

            const transaction_uuid = Math.random().toString(20).substr(2, 6);
            transaction_uuid_values.value = transaction_uuid;

            totalAmountForm.value = totalPriceProducts;
            product_code_value.value = product_code;
            const secretKey = "8gBm/:&EnhH.1/q";

            const message =
                `total_amount=${totalPriceProducts},transaction_uuid=${transaction_uuid},product_code=${product_code}`;

            const hash = CryptoJS.HmacSHA256(message, secretKey);
            const signatureValue = CryptoJS.enc.Base64.stringify(hash);

            signature.value = signatureValue;
            placeOrder();

            setTimeout(()=>{  
                const successUrl = `http://localhost:8000/checkout/order/items/${orderId}`;
                success_return.value = successUrl;
            },200)

            setTimeout(()=>{
                submitEsewa.submit();
            },300)
        });
    </script>
@endsection

@extends('layouts.frontend')

@section('title')
    Checkout
@endsection 

@section('home')

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row border border-1 p-2">
        <p class="fs-3 text-center">Checkout</p>
        <div class="col">
            <!-- Card -->
            <div>
                @php
                    $totalAmount = 0;
                    $itemPrice = array();
                    $orderDetails = array();
                @endphp
            
                @foreach ($products as $product)
                {{-- {{dd($products)}} --}}
                    <div class="card-body border">
                        <h5 class="card-title p-2 m-2">Product:  <span style="color: #fc6000;">{{$product->name}}</h5>
                        <p class="card-quantity p-2 m-2 fs-5">Quantity * <span style="color: #fc6000;">{{$product->quantity}}</span></p>
                        <p class="card-text p-2 m-2" >Price:  <span style="color: #fc6000;">{{($product->price)}} </p>
                        @php
                            array_push($itemPrice, $product->price * $product->quantity);
                            $orderDetails[] = array(
                                'name' => $product->name,
                                'price' => $product->price * $product->quantity,
                                
                            );
                        @endphp
                    </div>
                @endforeach
            
                @foreach ($itemPrice as $price)
                    @php
                        $totalAmount += $price;
                    @endphp
                @endforeach
            
                <div class="card-footer">
                    <p class="card-text text-success fs-5 text-end mt-2">
                    
                        Total Amount: {{$totalAmount}}
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
                Submit
            </a>
        </div>
    </div>
</div>
{{-- <div class="row m-4">
    @foreach ($orders as $order)
    @endforeach
    
</div> --}}

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
                orderDetails.push({ name, price ,quantity});
            });

            // Calculate the total amount for the each product
            
            let totalAmount = 0;
            orderDetails.forEach(item => {
                totalAmount += parseFloat(item.price * item.quantity);
            });

            // for the validation if the order has not been placed at all
            if(totalAmount == 0 )
            {
                toastr.info("Please place Order first");
                return;
            }

            // Create the POST request body
            const requestBody = {
                order_details: orderDetails,
                total : totalAmount,
            };


            // Send the POST request using fetch
            fetch('order/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify(requestBody,totalAmount),
            })


            .then(response => response.json())
            .then(data => {
               if(data.success)
               {
                    url = `checkout/order/items/`+ data.orderId;
                    window.location.replace(url);
                    toastr.succes("Order Placed");
               }
    
            })
            .catch(error => {
                console.error(error);
                // toastr.warning("Something went wrong");
            
            });
        });


    </script>
@endsection 










@extends('layouts.app')
@section('title')
    Order Details
@endsection

@section('content')

    <div class="modal fade" id="productView" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body product-information-body">


                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                    {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
                </div>
            </div>
        </div>
    </div>


    <div class="container">

        {{-- for creating a new Product --}}
        <h2>Order Details</h2>

        <table class="table">
            <thead>
                <th>S.N</th>
                <th>UserName</th>
                {{-- <th>Product Id</th> --}}
                <th>Order Id</th>
                <th>Price</th>
                {{-- <th>Quantity</th> --}}
                <th>Action</th>
            </thead>
            <tbody>
                {{-- Looping through Users --}}
                @php
                    $count = 0;
                @endphp
                {{-- for displaying the data that comes as the associative array --}}
                @foreach ($orderDetails as $order)
                    @php
                        ++$count;
                    @endphp
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->id }}</td>

                        {{-- adding the sum of price  --}}
                        <td>{{ $order->order_details()->sum('price') }}</td>

                        {{-- <td>{{ $order->order_details()->sum('quantity') }}</td> --}}

                        <td class="d-flex">
                            <button type="submit" data-orderDetails="{{ $order->id }}"
                                class="btn btn-success viewProductBtn" data-bs-toggle="modal"
                                data-bs-target="#productView">View Details</button>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@section('script')
    <script>
        const viewProductBtn = document.querySelectorAll(".viewProductBtn");
        // console.log(viewProductBtn);
        const productInformation = document.querySelector('.product-information-body');
        const modalFooter = document.querySelector(".modal-footer");


        viewProductBtn.forEach((btn) => {
            btn.addEventListener('click', (e) => {
                let orderId = btn.getAttribute('data-orderDetails');
                productInformation.textContent = "";
                modalFooter.textContent = "";
                fetch(`/admin/orderDetails/information/`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            'X-CSRF-TOKEN': metaTag,
                        },
                        body: JSON.stringify({
                            orderId: orderId,

                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {

                        console.log(data.message);
                        // productInformation.textcontent = data.message;

                        // creation of the elements 
                        const divElement = document.createElement('div');
                        let nameElement = document.createElement('p');
                        let price = document.createElement('p');
                        let order_details = document.createElement('p');

                        // adding classes
                        nameElement.classList.add('fs-4','text-center');
                        price.classList.add('fs-4','text-success');
                        order_details.classList.add('fs-4');

                        // giving properties
                        nameElement.textContent = data.message.user.name;
                        price.textContent = "Total Price: " + data.message.total;
                        divElement.appendChild(nameElement);
                        // divElement.appendChild(price);

                        // Loop through order_details array to extract product_ids
                        let productName = "Product Name: ";
                        let productPrice = "Price: ";
                        // let productQuantity = 'Quantity: ';


                        for (const orderDetail of data.message.order_details) {
                            // Create a new <p> element for each product name
                            let productNameElement = document.createElement('p');
                            let productPriceElement = document.createElement('p');
                            // let productQuantityElement = document.createElement('p');
                            
                            productNameElement.textContent = productName + orderDetail.product.name;
                            productPriceElement.textContent = (productPrice + orderDetail.product.price) + " * " +  orderDetail.quantity;
                            // productQuantityElement.textContent = productQuantity + orderDetail.quantity;

                            // Append the <p> element to the <div> element
                            divElement.appendChild(productNameElement);
                            divElement.appendChild(productPriceElement);    

                            // divElement.appendChild(productQuantityElement);
                        }

                     
                        divElement.appendChild(order_details);
                        productInformation.appendChild(divElement);
                        modalFooter.appendChild(price);


                    })
                    .catch(error => {

                        console.error("An error occurred:", error);

                    });
            });
        });
    </script>
@endsection

@endsection

@extends('layouts.frontend')
@php
       use Illuminate\Support\Facades\File;

@endphp

   <style>
        .carousel-image{
            width: 300px;
            height: 400px;
            /* object-fit: cover; */
            object-fit: cover;
        }
        .card{
            max-width: 300px;
        }
     
        .card-image{
            height: 200px;
        }

    </style>
@section('title')
home page
@endsection 
@section('home')
    <div class="container-fluid p-0 m-0">  
        <div class="carousel-container">
            <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                  @foreach ($slider as $item)
                    <div class="carousel-item {{ $loop->first ? ' active' : '' }}">
                        <a href="">
                        <img src="{{ asset('images/'.$item->image) }}"  class="d-block w-100 img-fluid carousel-image" alt="..."  style="max-width: 100%; max-height: 400px;">
                        </a>
                        <div class="carousel-caption d-none d-md-block">
                            <h5 class="text-info">{{$item->name}}</h5>
                            <p class="text-white">{{$item->caption}}</p>
                            <a href="{{route('frontends.categories',['id'=>$item->category_id])}}">
                                <button class="btn btn-primary">Shop Now</button>
                            </a>
                        </div>                
                    </div>
                   @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        {{-- end of the slider --}}
        <p class="fs-3 text-center m-3" id="products">Products</p>

        <div class="products-container container-fluid " >
            <div class="row container-fluid justify-content-center" style="max-width: 100%;">
                @foreach($products as $product)
                        <div class="col d-flex justify-content-center">
                            <div class="card card-1 m-3 border-dark border p-2" style="width: 18rem; height: 350px;">
                               
                                {{-- if the file exists display the image --}}
                                @if (File::exists(public_path('images/' . $product->image)))
                                <img style="width:100%; height:100%;" class="card-img-top" src="{{ asset('images/' . $product->image) }}" alt="">
                                @else
                                {{-- if the image doesn't exists then displaying custom image --}}
                                <img style="width:100%; height:100%;" class="card-img-top" src="{{ asset('images/fashion.jpg') }}" alt="">
                                @endif

                                {{-- this is the card body --}}
                                <div class="card-body bg-white">
                                   
                                    <p class="fs-3 card-title">{{$product->name}}</p>
                                    <p class="card-text text-black">Price : {{$product->price}}</p>

                                    {{-- it is beasically used to get the product id --}}
                                    <a href="#" class="cart " data-product-id="{{$product->id}}">
                                        <i class="fa-solid fa-cart-shopping cart data-cart-id"></i>
                                    </a>
                                   {{-- end of the logic  --}}

                                </div>
                            </div>
                        </div>
                @endforeach
             </div>
        </div>
    </div>

    
@section('script')
    <script>


        const carts = document.querySelectorAll('.cart');
        carts.forEach(cart=>{
            cart.addEventListener('click',(e)=>{
                // for preveting the default submission 
                e.preventDefault();
                // to get the data attribute on which being clicked
                cardId = cart.getAttribute('data-product-id');
                
                fetch(`/carts`,{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                    },
                    // to pass the product id
                    body: JSON.stringify({ product_id: cardId }),
                    
                })
                .then(response => response.json())
                
                .then(data => {
                    console.log(data);
                    // Handle the response from the server
                    if(data.hasOwnProperty('success') && data.success)
                    {
                        toastr.success('Product added successfully');
                    }else{
                        
                        toastr.error('Product added successfully');
                    }
                })    
                .catch(error => {
                    // console.log('asdf');
                    // console.error(error);  s  
                });         
            })
        })
        // to add the cart in the and modals in the 
        const allCartButton = document.querySelector('.allCart');
        const modalBody = document.querySelector('.modal-body');
        const modalFooter = document.querySelector('.modal-footer');
      

        var items = {
            cartItems: []
        };
        
   
        allCartButton.addEventListener('click', function() {
            fetch(`/cart-details`)
            .then(response => response.json())
            .then(data => {
                $('.total-price').text('');
                if (data.cartItems) {
                    modalBody.innerHTML = '';
                    let totalAmount = [];
                    items = {
                        cartItems: []
                    };
                    data.cartItems.forEach(item => {
                        
                        let quantity = item.quantity;
                        // Creating the first div container
                        const divElement = document.createElement('div');

                        // Adding the class row
                        divElement.classList.add('row');
                        
                        const imageColumn = document.createElement('div');
                        imageColumn.classList.add('col');
                        // Adding the class col and creating a new element for the image column

                        const productImage = document.createElement('img');
                        
                        // productImage.src = '{{ asset("images")}}' + "/" + item.image;
                        productImage.src = '@if(file_exists(public_path("images/" . "' + item.image + '"))){{ asset("images")}}' + "/" + item.image + '@else{{ asset("images/fashion.jpg") }}@endif';

                        productImage.style.width = "200px";
                        productImage.style.height = "100px";
                        imageColumn.appendChild(productImage);


                        // Creating a new element for the product column

                        const productColumn = document.createElement('div');
                        productColumn.classList.add('col');
                        const productName = document.createElement('p');

                        productName.classList.add('fs-5');

                        // adding the quantity name 
                        productName.textContent = 'Product Name: ' + item.name  + "*" + quantity;
                        const productPrice = document.createElement('p');
                        productPrice.classList.add('fs-5');
                        productPrice.textContent = 'Product Price: ' + item.price * quantity;
                        productColumn.appendChild(productName);
                        productColumn.appendChild(productPrice);

                        // to add the productName and price in the objects 
                        // Push the price and name into the cartItems array
      
                        items.cartItems.push({
                            name: item.name,
                            // passing the quantity of the product
                            price: item.price * quantity,
                            // quantity: item.quantity,
                        });

                        // updateTotalPrice(items); 
                        // totalPrice+=item.price;

                        // Creating the delete button
                    
                        const deleteButton = document.createElement('button');
                        deleteButton.classList.add('row');
                        deleteButton.textContent = 'Delete';
                        deleteButton.classList.add('btn', 'btn-danger', 'delete-btn','m-2');

                        deleteButton.style.width = "200px";
                    
                        divElement.appendChild(imageColumn);
                        divElement.appendChild(productColumn);
                        divElement.appendChild(deleteButton);
                        modalBody.appendChild(divElement);

                        // deletion logic
                        deleteButton.addEventListener('click',()=>{
                          
                            fetch(`/cart-delete`,{
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                            },
                            // to pass the id of the product that has been clicked 
                            body: JSON.stringify({ product_id: item.product_id}),
                        })

                            //  to get the response form the contoller as json format 
                            .then(response => response.json())
                        
                            // to get the data we got from the json 
                            .then((data)=>{
                                toastr.warning("data delted succesfully!");
                                // removes the div element when being delete button clicked
                                divElement.remove();
                                updateTotalPrice(items);

                            })
                            // to find if something has gone wrong 
                            .catch(error => console.log(error))

                        })

                    });

                    const totalElement = document.createElement('p');
                    totalElement.classList.add('total-price','text-end','fs-5');
                    totalElement.textContent = 'Total Price ' + totalPrice(items);
                    modalFooter.appendChild(totalElement);
                   
                }
                })
                .catch(error => {
                    console.error(error);
                });
                
        });

        
        const totalPrice = (items) => {
           
            let total = 0;
            for (let i = 0; i < items.cartItems.length; i++) {
                total += parseFloat(items.cartItems[i].price);
            }
            return total.toFixed(2);
        }
    //     const updateTotalPrice = (items) => {
    //     const totalElement = document.querySelector('.total-price');
    //     totalElement.textContent = 'Total Price: ' + totalPrice(items);
    // };


        </script>

@endsection 
@endsection 
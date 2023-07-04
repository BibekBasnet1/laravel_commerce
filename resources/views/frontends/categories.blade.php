@extends('layouts.categoriesApp')

@section('style')
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
@endsection
@section('title')
    <>Document
@endsection
@section('content')

    <div class="container-fluid p-0 m-0">

        {{-- start of the navbar container --}}
        <nav class="navbar navbar-expand-lg bg-dark border-bottom border-bottom-dark text-white d-flex justify-content-around" style="min-width: 100%;">

            {{-- this is for the logo  --}}
            <div class="logo">
                <p class="fs-3">Ecommerce</p>
            </div>

            {{-- this is for the nav-bar --}}
        
            <div class="links-container d-flex justify-content-center align-items-center">
                <ul class="navbar-nav d-flex justify-content-center" style="width: auto">
                    <li class="nav-item m-2 ">
                        <a href="" class="nav-link active text-white">Home</a>
                    </li>
                    
                    <li class="nav-item m-2">
                        <a href="" class="nav-link text-white">About</a>
                    </li>
                    

                    <li class="nav-item m-2">
                        <a href="#" class="nav-link text-white">Products</a>
                    </li>

                    <li class="nav-item m-2">
                        <a href="#" class="nav-link text-white">Contact</a>
                    </li>
                   
                </ul>

                {{--  --}}
                <div class="ms-5">
                 {{-- it is beasically used to get the product id --}}
                    <a href="#" class="allCart" data-bs-toggle="modal" data-bs-target="#cart_model" data-user-id="{{ auth()->user()->id }}">
                        <i class="fa-solid fa-cart-shopping cart data-allCart-id"></i>
                    </a>
                </div>
               {{-- end of the logic  --}}
            </div>

            <div class="btn-container d-flex">
                
                {{-- this is for the login and register --}}
                
                @if (Route::has('login'))
                @auth
                    {{-- <a href="{{ url('/home') }}" class="nav-link ms-1">
                        <button class="btn btn-primary">Home</button>
                    </a>                        --}}
                @else
                    <a href="{{ route('login') }}" class="nav-link me-1">
                        <button class="btn btn-primary">Login</button>
                    </a>
        
                    @if (Route::has('register'))
            
                    <a href="{{route('register')}}" class="nav-link text-white align-self-end me-1">
                        <button class="btn border border-1 text-white">Register</button>
                    </a>
                    @endif
                @endauth
                @endif           

            </div>
        </nav>
       
        <p class="fs-3 text-center m-3">{{$categories->name}}</p>

         <!-- Modal -->
         <div class="modal fade" id="cart_model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">My Cart</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- for carts products display --}}
                    
                    <p class="fs-5">Product Name: </p>
                    <p class="fs-5">Product Price: </p>

                    {{-- for displaying the products display --}}

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
            </div>
        </div>

        {{-- this part of the code will give the images based on the category--}}
        @foreach($categories->products as $product)
        {{-- {{dd($product->image)}} --}}
                <div class="products-container container-fluid ">
                    <div class="row container-fluid " style="max-width: 100%;">
                        <div class="col">
                            <div class="card card-1 m-3 p-2" style="width: 18rem; height: 350px;">
                                <img src="{{asset('images/'.$product->image)}}" style="width:100%; height:100%;" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <p class="fs-3 card-title">{{$product->name}}</p>
                                    <p class="card-text text-primary">Price : {{$product->price}}</p>

                                    {{-- it is beasically used to get the product id --}}
                                    <a href="#" class="cart" data-product-id="{{$product->id}}">
                                        <i class="fa-solid fa-cart-shopping cart data-cart-id"></i>
                                    </a>
                                   {{-- end of the logic  --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @endforeach
        {{-- end of the logic  --}}
    </div>
@endsection

@section('script')

    <script>
        // toastr.error('Product added successfully');
        // which cart font being clicked 
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
                    // Handle the response from the server
                    if(data.hasOwnProperty('success') && data.success)
                    {
                        toastr.success('Product added successfully');
                    }else{

                        toastr.error('Product added successfully');
                    }
                })
                
                .catch(error => {
                    console.error(error);    
                });
                
            })
        })
             // it is for passing the cart id 
            const deleteCart = (id)=>{
            console.log(id);
        }



        // to add the cart in the and modals in the 
        const allCartButton = document.querySelector('.allCart');
        const modalBody = document.querySelector('.modal-body');

        allCartButton.addEventListener('click', function() {
            fetch(`/cart-details`)
                .then(response => response.json())
                .then(data => {
                    if (data.cartItems) {
                    modalBody.innerHTML = '';

                    data.cartItems.forEach(item => {

                        const productImage = document.createElement('img');
                        productImage.src = '{{ asset("images")}}' + "/" + item.image;
                        productImage.style.width = "200px";
                        productImage.style.height = "100px";
                        modalBody.appendChild(productImage);

                        const productName = document.createElement('p');
                        productName.classList.add('fs-5');
                        productName.textContent = 'Product Name: ' + item.name;
                        modalBody.appendChild(productName);
                        
                        const productPrice = document.createElement('p');
                        productPrice.classList.add('fs-5');
                        productPrice.textContent = 'Product Price: ' + item.price;
                        modalBody.appendChild(productPrice);

                        const deleteButton = document.createElement('button');
                        deleteButton.textContent = 'Delete';
                        deleteButton.classList.add('btn', 'btn-danger','delete-btn');
                        modalBody.appendChild(deleteButton);

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
                            })
                            // to find if something has gone wrong 
                            .catch(error => console.log(error))

                        })

                    });
                }
                })
                .catch(error => {
                    console.error(error);
                });
        });

   
    
    </script>

@endsection







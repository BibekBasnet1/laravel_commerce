@extends('layouts.frontend')

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
@section('home')

    <div class="container-fluid p-0 m-0">
       
        <p class="fs-3 text-center m-3">{{$categories->name}}</p>

        {{-- this part of the code will give the images based on the category--}}
        {{-- {{dd($product->image)}} --}}
        <div class="products-container container-fluid ">
            <div class="row container-fluid justify-content-center" style="max-width: 100%;">
                @foreach($categories->products as $product)
                        <div class="col d-flex justify-content-center">
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
                @endforeach
             </div>
        </div>
        {{-- end of the logic  --}}
        
    </div>
@endsection

@section('script')

    <script>
        // toastr.error('Product added successfully');
        // which cart font being clicked 
        const carts = document.querySelectorAll('.cart');
        cartProducts = [];
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
                    toastr.error('Something Went Wrong!');
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

                        // Creating the first div container
                        const divElement = document.createElement('div');

                        // Adding the class row
                        divElement.classList.add('row');


                        // Adding the class col and creating a new element for the image column

                        const imageColumn = document.createElement('div');
                        imageColumn.classList.add('col');

                        const productImage = document.createElement('img');
                        productImage.src = '{{ asset("images")}}' + "/" + item.image;
                        productImage.style.width = "200px";
                        productImage.style.height = "100px";
                        imageColumn.appendChild(productImage);

                        // Creating a new element for the product column
                        const productColumn = document.createElement('div');
                        productColumn.classList.add('col');
                        const productName = document.createElement('p');

                        productName.classList.add('fs-5');
                        productName.textContent = 'Product Name: ' + item.name;
                        const productPrice = document.createElement('p');
                        productPrice.classList.add('fs-5');
                        productPrice.textContent = 'Product Price: ' + item.price;
                        productColumn.appendChild(productName);
                        productColumn.appendChild(productPrice);

                        // Creating the delete button
                        const deletDiv = document.createElement('div');
                        deletDiv.classList.add('row');
                        const deleteButton = document.createElement('button');
                        deleteButton.textContent = 'Delete';
                        deleteButton.classList.add('btn', 'btn-danger', 'delete-btn','m-2');
                        deleteButton.style.width = "200px";
                        deletDiv.appendChild(deleteButton);
                        // Appending the elements

                        // deletDiv.appendChild(deleteButton);
                        divElement.appendChild(imageColumn);
                        divElement.appendChild(productColumn);
                        divElement.appendChild(deleteButton);
                        modalBody.appendChild(divElement);

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







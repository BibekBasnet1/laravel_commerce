@extends('layouts.frontend')

@section('title')
    Product Categories
@endsection
@section('style')
    <style>
        
    </style>
@endsection


@section('home')

{{-- <p class="fs-3 m-5 border-bottom " id="products">Products</p> --}}
    
<div class="products-container container-fluid " >
 
    <div class="sorting d-flex justify-content-end align-items-center">
        <div class="select-container">

        {{-- performing ajax request to sort the data where while posting value is used from option  --}}
        <form action="" method="post">
            <select class="form-select" id="sorting" name="sorting" aria-label="Default select example">
                {{-- <option value=""></option> --}}
                <option value="desc">Highest Price</option>
                <option value="asc">Lowest Price</option>
                {{-- <option value="name">By Name</option> --}}
            </select>
        </form>
        {{-- end of the logic  --}}
    
        </div>
    
        <div class="sort-icon">
            <i class='bx bx-sort m-4'></i>
        </div>

    </div>
    <div class="row container-fluid justify-content-center" id="dynamicProducts" style="max-width: 100%;">
        {{-- <table class="table row"> --}}
            @foreach($products as $product)
            {{-- <tr> --}}

                <div class="col d-flex justify-content-center">
                    {{-- when click it should be redirected to the particular product id  --}}
                    <a href="{{route('frontends.imageCheckout',['id'=>$product->id])}}" class="text-decoration-none">
                        
                        {{-- if the image exists it will display that image otherwise some random image --}}
                        <div class="card card-1 m-3 border border-2 p-2 card-container" style="width: 18rem; height: 350px; position: relative;">
                            @if (File::exists(public_path($product->image)))
                                <img style="width:100%; height:100%;" src="{{ asset($product->image) }}" class="card-img-top" alt="">
                            @else
                                <img style="width:100%; height:100%;" src="{{ asset('images/fashion.jpg') }}" alt="">
                            @endif

                            <div class="card-body bg-white" style="height: 50%;">
                                <p class="m-0" style="color: #fc6000;font-size:1rem;">{{$product->name}}</p>
                                <p class="m-0 text-black">{{$product->category->name}}</p>
                                <p class="fs-5" style="color: #fc6000;">Price : {{$product->price}}</p>
                                <a href="" class="carts d-flex justify-content-end" data-product-id="{{$product->id}}">
                                    {{-- <i class="fas fa-cart-plus"></i> --}}
                                    <i class="fa-solid fa-cart-shopping data-cart-id "></i>
                                </a>
                            </div>
                        </div>
            {{-- </tr> --}}
                    </a>
                </div>
            @endforeach
     
        {{-- </table> --}}
        
    </div>
</div>

@endsection

@section('script')

<script>
    // taking all the data which is send through controller
    const categoriesById = @json($categories);
    
    const carts = document.querySelectorAll('.carts');
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

                                // Find the index of the deleted item in items.cartItems array
                                const deletedIndex = items.cartItems.findIndex(cartItem => cartItem.product_id === item.product_id);

                                // Check if the deleted item exists in the array
                                if (deletedIndex > -1) {
                                // Get the deleted item's price
                                const deletedItemPrice = parseFloat(items.cartItems[deletedIndex].price);

                                // Subtract the deleted item's price from the total
                                const newTotal = parseFloat(totalElement.textContent.substring(12)) - deletedItemPrice;

                                // Update the totalElement with the new total
                                totalElement.textContent = 'Total Price: ' + newTotal.toFixed(2);

                                // Remove the deleted item from items.cartItems array
                                items.cartItems.splice(deletedIndex, 1);
                                }

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
        
        
        const totalPrice = (items) => 
        {
            let total = 0;
            for (let i = 0; i < items.cartItems.length; i++) 
            {
                total += parseFloat(items.cartItems[i].price);
            }
            return total.toFixed(2);
        }   

        // it takes out the value for the search 
        const searchParam = new URLSearchParams(window.location.search).get('search');
        console.log(searchParam)
        // Split the search parameter into an array of individual words
        // const searchWords = searchParam.split(/\s+/);

        // Concatenate the search words into a single string
        // const concatenatedSearch = searchWords.join(' ');


        // this code is for sorting the elements 
        let sortingElement = document.querySelector('#sorting');
        const searchValue = document.querySelector("#searchInput").value;
        // if any change occurse trigger the event and get the value from the inputbox
        sortingElement.onchange = (event) =>
        {

            let sortValue = event.target.value;
            
            fetch('searchInput/sortByprice/',
        {
            method: 'POST',
            headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                    },
                    
            // to pass the product id
            body: JSON.stringify({ 

                // pass the value in sorting 
                sortBy : sortValue,
                searchValue : searchParam,
                
            }),
                    
        })
            .then(response=>response.json())
            .then(data => {
                if(data.success){
                
                let dynamicProductsContainer = document.querySelector('#dynamicProducts');
                dynamicProductsContainer.innerHTML = '';

                const products = data.products;
                products.forEach(product => {
                    let divElement = document.createElement('div');
                    divElement.classList.add('col', 'd-flex', 'justify-content-center');
                    // Create a card element
                    let card = document.createElement('div');
                    card.classList.add('card', 'card-1', 'm-3', 'border', 'border-2', 'p-2', 'card-container');
                    card.style.width = '18rem';
                    card.style.height = '350px';
                    card.style.position = 'relative';

                    // Check if the image exists
                    let imageSrc = '{{ asset('images/fashion.jpg') }}';
                    if (product.image && '{{ File::exists(public_path(':path')) }}'.replace(':path', 'images/'+product.image)) {
                        imageSrc = '{{ asset(':image') }}'.replace(':image', product.image);
                    }

                    // Set the card HTML
                    card.innerHTML = `
                        <a href="{{ route('frontends.imageCheckout', ['id' => ':id']) }}" class="text-decoration-none">
                            <img style="width: 100%; height: 100%;" src="${product.image}" class="card-img-top" alt="">
                            <div class="card-body bg-white" style="height: 50%;">

                                <p class="fs-5" style="color: #fc6000;">${product.name}</p>
                                <p class="m-0 text-black">${categoriesById[product.category_id].name}</p>
                                
                                <p class="fs-5" style="color: #fc6000;">Price : ${product.price}</p>
                                
                                <a href="" class="carts d-flex justify-content-end" data-product-id="${product.id}">
                                    <i class="fa-solid fa-cart-shopping data-cart-id "></i>
                                </a>
                            </div>
                        </a>
                    `;

                    // Append the card to the dynamicProductsContainer
                    divElement.appendChild(card);
                    dynamicProductsContainer.appendChild(divElement);
                });

                }
            })
            .catch(error => console.log(error));

            }


</script>

@endsection
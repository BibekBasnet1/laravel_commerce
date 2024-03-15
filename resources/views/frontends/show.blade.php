@extends('layouts.frontend')
@php
    use Illuminate\Support\Facades\File;
    
@endphp

@section('style')
    {{-- <link rel="stylesheet" type="text/css" href="slick/slick.css"/> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <style>
        .carousel-image {
            width: 300px;
            height: 400px;
            /* object-fit: cover; */
            object-fit: cover;
        }


        .card:hover {
            /* transform: translate(10px, -10px); */
            /* background: #ffffff69; */
            box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
        }

        .swiper {
            width: 600px;
            height: 300px;
        }

        .card:hover .carts {
            /* transform: rotate(360deg); */
            transition: transform 0.5s ease;
            /* background-color: black; */
            /* color: #ffffff; */
            color: #fc6000;
        }

        .autocomplete {
            /*the container must be positioned relative:*/
            position: relative;
            display: inline-block;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        .autocomplete-items div:hover {
            /*when hovering an item:*/
            background-color: #e9e9e9;
        }

        .autocomplete-active {
            /*when navigating through the items using the arrow keys:*/
            background-color: DodgerBlue !important;
            color: #ffffff;
        }

        .swiper-product:hover {
            /* box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px; */
            /* box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; */
            box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
        }
    </style>
@endsection

@section('title')
    home page
@endsection



@section('home')
    <div class="container-fluid" style="">
        <div class="carousel-container d-flex">
            <div class="flex-shrink-0 p-3" style="width: 280px;">
                <a href="/"
                    class="d-flex align-items-center pb-3 mb-3 link-body-emphasis text-decoration-none border-bottom">
                    <svg class="bi pe-none me-2" width="30" height="24">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                    <span class="fs-5 fw-semibold">All Categories</span>
                </a>

                <ul class="list-unstyled ps-0">

                    {{-- Start of the listing --}}
                    @foreach ($categories as $category)
                        <li class="mb-1">
                            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                                data-bs-toggle="collapse" data-bs-target="{{ '#' . $category->id }}" aria-expanded="false">
                                {{ $category->name }}
                            </button>

                            {{-- Giving the id as data-bs-target so that it will properly know which is being selected --}}
                            <div class="collapse" id="{{ $category->id }}" style="">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    @foreach ($category->subcategory as $subcategory)
                                        <li class="">

                                            {{-- for the subcategories --}}
                                            <a href="{{ url('categories/' . $subcategory->id) }}">

                                                <button id="subcategory"
                                                    class="btn btn-toggle d-inline-flex align-items-center ms-3 rounded border-0 collapsed"
                                                    data-bs-toggle="collapse" data-bs-target="{{ '#' . $subcategory->id }}"
                                                    aria-expanded="false">
                                                    {{ $subcategory->name }}
                                                </button>

                                            </a>
                                            {{-- end of the subcategories --}}

                                            {{-- <a href="{{route('frontends.sidebarCategories',['id'=>$subcategory->id])}}">
                                          
                                        </a> --}}

                                            {{-- Check if the subcategory has subcategories --}}
                                            @if ($subcategory->subcategory->isNotEmpty())
                                                {{-- Nested list to display sub-subcategories --}}
                                                <div class="collapse" id="{{ $subcategory->id }}" style="">
                                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small"
                                                        id="lists">
                                                        @foreach ($subcategory->subcategory as $subsubcat)
                                                            <li class="">
                                                                <button
                                                                    class="btn btn-toggle d-inline-flex align-items-center ms-4 rounded border-0 collapsed"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="{{ '#' . $subcategory->id }}"
                                                                    aria-expanded="false">
                                                                    {{ $subsubcat->name }}
                                                                </button>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>


            </div>
            <div id="carouselExample" class="carousel slide w-100">

                <div class="carousel-inner border">

                    @foreach ($slider as $item)
                        <div class="carousel-item {{ $loop->first ? ' active' : '' }}">
                            <a href="">

                                {{-- if the image exist in the public folder itself show it  otherwise go to images folder and find it --}}

                                @if (File::exists(public_path($item->image)))
                                    <img src="{{ asset($item->image) }}" class="d-block w-100 img-fluid carousel-image"
                                        style="max-width: 100%; max-height: 400px;" alt="...">
                                @else
                                    <img src="{{ asset('images/' . $item->image) }}"
                                        class="d-block w-100 img-fluid carousel-image"
                                        style="max-width: 100%; max-height: 400px;" alt="...">
                                @endif

                            </a>
                            <div class="carousel-caption d-none d-md-block">

                                <h5 class="text-info">{{ $item->name }}</h5>
                                <p class="text-white">{{ $item->caption }}</p>

                                <a href="{{ url('categories/' . $item->category_id) }}">
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


        {{-- this is for the new Arrival Products --}}
        <p class="fs-3 m-5 mb-2 border-bottom " id="newArrival">New Arrival</p>


        <div class="newArrival">
            <!-- Slider main container -->
            <div style="position: relative !important; " class="swiper-container swiper-container-free-mode">

                <!-- Additional required wrapper -->
                <div class="swiper-wrapper p-5 ">
                    <!-- Slide -->
                    @foreach ($featuredProducts as $item)
                        <div class="swiper-slide border border-1 swiper-product ms-2"
                            style="max-width: 300px;max-height:300px;" data-swiper-autoplay="1000">
                            {{-- <div style="height:100%;width:100%;"> --}}
                            <a href="{{ route('frontends.imageCheckout', ['id' => $item->id]) }}"
                                class="text-decoration-none ">
                                <img src="{{ asset($item->image) }}" style="object-fit:cover;" width="100%;"
                                    height="100%">
                                <p class="text-center text-black" style="height:20%">{{ $item->name }}</p>
                                <p class="fs-5 text-center mb-2" style="color: #fc6000;">Price: {{ $item->price }}</p>
                            </a>
                            {{-- </div> --}}
                        </div>
                    @endforeach

                </div>

                <!-- If we need navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

                <!-- If we need scrollbar -->
                <div class="swiper-scrollbar" style="mt-5"></div>

            </div>



        </div>

        {{-- end of the new Arrival Products --}}

        <p class="fs-3 m-5 border-bottom " id="products">Products</p>

        <div class="products-container container-fluid ">
            <div class="row container-fluid justify-content-center" style="max-width: 100%;">
                {{-- <ta class="table row"> --}}
                @foreach ($products as $product)
                    <div class="col d-flex justify-content-center">
                        {{-- when click it should be redirected to the particular product id  --}}
                        <a href="{{ route('frontends.imageCheckout', ['id' => $product->id]) }}"
                            class="text-decoration-none">
                            {{-- if the image exists it will display that image otherwise some random image --}}
                            <div class="card card-1 m-3 border p-2"
                                style="width: 18rem; height: 350px; position: relative;">
                                @if (File::exists(public_path($product->image)))
                                    <img style="width:100%; height:100%;" src="{{ asset($product->image) }}"
                                        class="card-img-top" alt="">
                                @else
                                    <img style="width:100%; height:100%;" src="{{ asset('images/fashion.jpg') }}"
                                        alt="">
                                @endif

                                <div class="card-body bg-white w-100" style="height: 50%;">
                                    <p class="m-0" style="color: #fc6000;font-size:1rem;">{{ $product->name }}</p>
                                    <p class="m-0 text-black">{{ isset($product->category->name) }}</p>
                                    <p class="fs-5" style="color: #fc6000;">Price : {{ $product->price }}</p>

                                    {{-- this container holds the icons of the cart whislist and the cart --}}

                                    <div class="icon-container w-100 d-flex justify-content-end">
                                        {{-- this is for directly adding to the cart  --}}
                                        <a href="" class="carts" data-product-id="{{ $product->id }}">
                                            {{-- <i class="fas fa-cart-plus"></i> --}}
                                            <i class="fa-solid fa-cart-shopping data-cart-id "></i>
                                        </a>

                                        {{-- this is for the wishlist --}}
                                        <a href="" class="wishlist" data-product-id="{{ $product->id }}">
                                            <i class="fa-solid fa-heart text-primary mx-3 "></i>
                                        </a>
                                    </div>


                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

                {{-- logic for pagination  --}}
                <div class="d-flex justify-content-center w-100 mt-4 mb-5">
                    <a href="" class="btn text-decoration-none">
                        {{ $products->links() }}
                    </a>

                </div>

                {{-- end of logic --}}
            </div>

        </div>

        <p class="fs-3 mb-3 ms-4 border-bottom" id="products">Featured Products</p>

    @section('featured')
        <!-- Slider main container -->
        <div style="position: relative !important; m-4" class="swiper-container swiper-container-free-mode">

            <!-- Additional required wrapper -->
            <div class="swiper-wrapper p-5 ">
                <!-- Slide -->
                @foreach ($featuredProducts as $item)
                    <div class="swiper-slide border border-1 swiper-product ms-2"
                        style="max-width: 300px;max-height:300px;" data-swiper-autoplay="1000">
                        {{-- <div style="height:100%;width:100%;"> --}}
                        <a href="{{ route('frontends.imageCheckout', ['id' => $item->id]) }}"
                            class="text-decoration-none ">
                            <img src="{{ asset($item->image) }}" style="object-fit:cover;" width="100%;"
                                height="100%">
                            <p class="text-center text-black" style="height:20%">{{ $item->name }}</p>
                            <p class="fs-5 text-center mb-2" style="color: #fc6000;">Price: {{ $item->price }}</p>
                        </a>
                        {{-- </div> --}}
                    </div>
                @endforeach

            </div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

            <!-- If we need scrollbar -->
            <div class="swiper-scrollbar" style="mt-5"></div>

        </div>

    </div>
@endsection


<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
@section('script')
    <script>
        const swiper = new Swiper('.swiper-container', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,
            slidesPerView: 7,
            speed: 1000,
            grabCursor: true,
            mousewheelControl: true,
            keyboardControl: true,
            autoplay: {
                delay: 1,
                disableOnInteraction: false
            },
            // If we need pagination
            // pagination: {
            //     el: '.swiper-pagination',
            // },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
            },
        });


        // const carts = document.querySelectorAll('.carts');

        // carts.forEach(cart => {
        //     cart.addEventListener('click', (e) => {
        //         // for preveting the default submission 
        //         e.preventDefault();
        //         // to get the data attribute on which being clicked
        //         cardId = cart.getAttribute('data-product-id');

        //         fetch(`/carts`, {
        //                 method: 'POST',
        //                 headers: {
        //                     'Content-Type': 'application/json',
        //                     'X-CSRF-TOKEN': '{{ csrf_token() }}',
        //                 },
        //                 // to pass the product id
        //                 body: JSON.stringify({
        //                     product_id: cardId
        //                 }),

        //             })
        //             .then(response => response.json())

        //             .then(data => {
        //                 // console.log(data);
        //                 // Handle the response from the server
        //                 if (data.hasOwnProperty('success') && data.success) {
        //                     toastr.success('Product added successfully');
        //                     const updatedCount = parseInt(cartCount.innerHTML) + 1;
        //                     cartCount.innerHTML = updatedCount;

        //                 } else {

        //                     toastr.error('Product added successfully');
        //                 }
        //             })
        //             .catch(error => {
        //                 // console.log('asdf');
        //                 // console.error(error);  s  
        //             });
        //     })
        // })
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

                            // productImage.src = '{{ asset('images') }}' + "/" + item.image;
                            productImage.src =
                                '@if (file_exists(public_path('images/' . "' + item.image + '"))){{ asset('images') }}' + "/" +
                                item.image +
                                '@else{{ asset('images/fashion.jpg') }}@endif';

                            productImage.style.width = "200px";
                            productImage.style.height = "100px";
                            imageColumn.appendChild(productImage);


                            // Creating a new element for the product column

                            const productColumn = document.createElement('div');
                            productColumn.classList.add('col');
                            const productName = document.createElement('p');

                            productName.classList.add('fs-5');

                            // adding the quantity name 
                            productName.textContent = 'Product Name: ' + item.name + "*" + quantity;
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

                            });


                            const deleteButton = document.createElement('button');
                            deleteButton.classList.add('row');
                            deleteButton.textContent = 'Delete';
                            deleteButton.classList.add('btn', 'btn-danger', 'delete-btn', 'm-2');

                            deleteButton.style.width = "200px";

                            divElement.appendChild(imageColumn);
                            divElement.appendChild(productColumn);
                            divElement.appendChild(deleteButton);
                            modalBody.appendChild(divElement);

                            // deletion logic
                            deleteButton.addEventListener('click', () => {

                                fetch(`/cart-delete`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        },
                                        // to pass the id of the product that has been clicked 
                                        body: JSON.stringify({
                                            product_id: item.product_id
                                        }),
                                    })

                                    //  to get the response form the contoller as json format 
                                    .then(response => response.json())

                                    // to get the data we got from the json 
                                    .then((data) => {
                                        toastr.warning("data delted succesfully!");

                                        // removes the div element when being delete button clicked
                                        divElement.remove();

                                        // Find the index of the deleted item in items.cartItems array
                                        const deletedIndex = items.cartItems.findIndex(
                                            cartItem => cartItem.product_id === item
                                            .product_id);

                                        // Check if the deleted item exists in the array
                                        if (deletedIndex > -1) {
                                            // Get the deleted item's price
                                            const deletedItemPrice = parseFloat(items
                                                .cartItems[deletedIndex].price);

                                            // Subtract the deleted item's price from the total
                                            const newTotal = parseFloat(totalElement
                                                    .textContent.substring(12)) -
                                                deletedItemPrice;

                                            // Update the totalElement with the new total
                                            totalElement.textContent = 'Total Price: ' +
                                                newTotal.toFixed(2);

                                            // Remove the deleted item from items.cartItems array
                                            items.cartItems.splice(deletedIndex, 1);
                                        }

                                    })

                                    // to find if something has gone wrong 
                                    .catch(error => console.log(error))

                            })

                        });

                        const totalElement = document.createElement('p');
                        totalElement.classList.add('total-price', 'text-end', 'fs-5');
                        totalElement.textContent = 'Total Price ' + totalPrice(items);
                        modalFooter.appendChild(totalElement);
                    }

                })

                .catch(error => {
                    console.error(error);
                });

        });

        // deletion logic 



        const totalPrice = (items) => {
            let total = 0;
            for (let i = 0; i < items.cartItems.length; i++) {
                total += parseFloat(items.cartItems[i].price);
            }
            return total.toFixed(2);
        }

        //  for creating the dropdown menu
        const subElement = document.querySelectorAll('#subcategory');
        const liElement = document.querySelector('#lists');
        // console.log(subElement);
        subElement.forEach(subBtn => {
            let emptyElement = "";
            subBtn.addEventListener('mouseover', () => {
                // console.log('hovered');
                emptyElement +=
                    ` @foreach ($subcategory->subcategory as $subsubcat)
                    {{-- <li class=""> --}}
                        <button class="btn btn-toggle d-inline-flex align-items-center ms-4 rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="{{ '#' . $subcategory->id }}" aria-expanded="false">
                                {{ $subsubcat->name }}
                        </button>
                    {{-- </li> --}}
                  @endforeach`;
                subElement.innerHTML = emptyElement;
            });

        })


        // this is for the whishlist 
        const wishlistIcon = document.querySelectorAll('.wishlist');

        const countWish = document.querySelector('.wishlist-count');

        // start of the logic 
        wishlistIcon.forEach(wishlistBtn => {
            wishlistBtn.addEventListener('click', (e) => {
                e.preventDefault();
                let productId = wishlistBtn.getAttribute('data-product-id');
                console.log(productId);
                fetch(`wishlist/products`, {

                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },

                        // to pass the product id
                        body: JSON.stringify({

                            // pass the value in sorting 
                            productId: productId,

                        }),

                    })
                    .then(response => response.json())
                    .then((data) => {
                            console.log(data);
                            // Handle the response from the server
                            if (data.hasOwnProperty('success') && data.success) {
                                toastr.success("Successfully added to the wishlist");
                                // optimized by incrementing the count instead of querying each time 
                                const updatedCount = parseInt(countWish.innerHTML) + 1;
                                countWish.innerHTML = updatedCount;

                            } else {
                                toastr.error("Already Added to the wishlist");
                            }

                        }

                    )
                    .catch(error => console.log(error))
            })
        })

        // end of the logic 
    </script>
@endsection
@endsection

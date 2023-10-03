@extends('layouts.frontend')

@section('title')
    Product Description
@endsection

@section('style')
    <style>
        .col {
            width: 100%;
            height: auto;
            max-height: 400px;
            /* Set a maximum height to maintain aspect ratio */
        }

        .item-product-images {
            /* border:2px solid red; */

        }

        .carousel-inner {
            /* border: 2px solid black; */
            width: 500px !important;

        }

        .item-product-images img {
            width: 500px !important;
            height: 400px !important;
        }

        .col img {
            /* border: 2px solid red; */
        }

        .currentColor.active {
            /* background-color: #ff0000; */
            /* color: #fff; */
        }

        .currentColor {
            /* border: 2px solid blue; */
        }

        .currentColor.active i.fa-solid.fa-check.check-icon {
            visibility: visible;
            !important;
            position: relative;
            /* color: #fff; */
            top: 38px;
            right: 5px;
        }

        .radio-toolbar input[type="radio"] {
            opacity: 0;
            position: fixed;
            width: 0;
        }

        .radio-toolbar label {
            display: inline-block;
            background-color: #ddd;
            padding: 10px 10px;
            font-family: sans-serif, Arial;
            font-size: 16px;
            border: 2px solid #444;
            border-radius: 4px;
        }


        .radio-toolbar input[type="radio"]:checked+label {
            background-color: #bfb;
            border-color: #4c4;
        }

        .radio-toolbar input[type="radio"]:focus+label {
            border: 2px dashed #444;
        }

        .radio-toolbar label:hover {
            background-color: #dfd;
        }
    </style>
@endsection

@section('home')
    <div class="container-fluid ">

        <div class="container d-flex fs-5">

            {{-- if parent Id exists then print the  --}}

            @if ($product->category->parent_id != null)
                <a href="{{ route('frontends.categories', ['id' => $productCategory->id]) }}"
                    class="nav-link ">{{ $productCategory->name }}</a>
                &nbsp;>&nbsp;
            @endif <a href="" class="nav-link ">{{ $product->category->name }}</a> &nbsp;>&nbsp;
            <a href="" class="nav-link">{{ $product->name }}</a>

        </div>

        <div class="container d-flex justify-content-center align-items-center vh-100">

            <div class="row">

                <div class="col">

                    <!-- Debugging -->
                    {{-- @if (count($product->images) == 0)
                    <p>No images found.</p>
                @else
                    <p>Images found: {{ count($product->images) }}</p>
                @endif --}}

                    @if (count($product->images) == 0)
                        <div class="carousel-item item-product-images active">
                            <a href="#">
                                {{-- If no images are associated with the product, display the product's image --}}
                                {{-- @if (File::exists(public_path($product->image))) --}}
                                <img src="{{ asset($product->image) }}" class="d-block img-fluid carousel-image"
                                    alt="...">
                                {{-- @endif --}}
                            </a>
                            <div class="carousel-caption d-none d-md-block">
                                {{-- Caption code here --}}
                            </div>
                        </div>
                    @else
                        <div id="carouselExample" class="carousel slide w-100">
                            <div class="carousel-inner">

                                {{-- Looping through product Images --}}
                                @foreach ($product->images as $image)
                                    <div data-imageColor="{{ $image->color_name }}"
                                        class="carousel-item item-product-images {{ $loop->first ? ' active' : '' }}">
                                        <a href="#">

                                            {{-- If the image exists in the public folder itself, show it --}}
                                            @if (File::exists(public_path($image['image_path'])))
                                                <img src="{{ asset($image['image_path']) }}"
                                                    class="d-block img-fluid carousel-image" alt="...">
                                            @endif
                                        </a>
                                        <div class="carousel-caption d-none d-md-block">

                                        </div>
                                    </div>
                                @endforeach


                                {{-- End of looping through product images --}}
                            </div>

                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>

                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>

                        </div>
                    @endif

                </div>

                <div class="col">

                    {{-- create a slider with images here  --}}
                    <h3 class="fs-5" style="color: #fc6000;">
                        {{ $product->name }}
                    </h3>

                    <p class="text-black">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam, incidunt. <br>
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Commodi, deleniti.
                    </p>

                    {{-- paragraph color --}}
                    <p class="fs-5" style="color: #fc6000">Color</p>

                    <div class="attributes-container d-flex">
                        <div class="radio-toolbar">
                            @foreach (json_decode($product->attributes) as $key => $attribute)
                                <span class="fs-4">{{ $key }}</span>
                                @php $groupUniqueId =  $key; @endphp
                                <div class="radio-group" id="{{ $groupUniqueId }}">
                                    @foreach ($attribute as $value => $attribute_name)
                                        @php $uniqueId = 'attributeName_' . $key . '_' . $value; @endphp
                                        <input type="radio" id="{{ $uniqueId }}" name="{{ $groupUniqueId }}"
                                            value="{{ $attribute_name }}" class="inputRadio"
                                            data-currentAttribute="{{ $attribute_name }}">
                                        <label for="{{ $uniqueId }}" class="mb-4 m-4"> {{ $attribute_name }} </label>
                                    @endforeach
                                </div>
                                <br>
                            @endforeach
                        </div>
                    </div>


                    <div class="color-container d-flex">
                        @foreach ($product['images'] as $image)
                            <div style="text-align: center;" class="currentColor" data-color="{{ $image['color_name'] }}">
                                <i class="fa-solid fa-check check-icon" style="color: #ffffff;visibility: none;"></i>
                                <span
                                    style="background-color: {{ $image['color_name'] }}; padding: 5px; border-radius: 5px; margin: 0px 5px 10px 0;width: 50px;height:50px;display: block"></span>
                                {{ $image['color_name'] }}
                                {{-- <i class="fa-solid fa-check" style="display: none;"></i> --}}
                            </div>
                        @endforeach
                    </div>

                    {{-- <div class="variants">
                        @foreach ($productVariants as $product)
                            @foreach ($product['variants'] as $variant)
                                <p>{{ $variant['name'] }}</p>
                                <p>Variant Price: {{ $variant['price'] }}</p>
                            @endforeach
                        @endforeach
                    </div> --}}

                    {{-- product price --}}
                    <p class="fs-4 mt-4" id="productPrice" style="color: #fc6000">
                        Price <br>
                        @if (isset($productVariants->variants))
                            {
                            <?php echo 'variants exist'; ?>
                            }
                        @endif
                    </p>

                    {{-- this is for the input group --}}
                    <div class="input-group">
                        <button class="btn btn-secondary" onclick="decreaseAmount()">-</button>
                        <input type="hidden" value="{{ $product->price }}" id="fixedPrice" class="form-control">
                        <input type="text" id="amount" class="form-control text-center" value="1">
                        <button class="btn btn-secondary" onclick="increaseAmount()">+</button>
                    </div>

                    {{-- this is btn for checking out and adding to the cart  --}}
                    <div class="btn-container w-100 d-flex justify-content-around">
                        {{-- redirect to the checkout section --}}
                        <a href="{{ route('frontends.checkout') }}" class="btn btn-primary mt-4 w-50 btn-buy-disabled">
                            Buy Now
                        </a>
                        <button class="btn mt-4 text-white ms-1 w-50 add-cart btn-disabled"
                            data-product-id="{{ $product->id }}" style="background: #fc6000;">Add To Cart</button>
                    </div>

                </div>
            </div>
        </div>

    </div>


@endsection
@section('script')
    <script>
        const colors = document.querySelectorAll('.currentColor');
        const colorContainer = document.querySelector('.color-container');
        const itemProductImages = document.querySelectorAll(".item-product-images");
        const currrentItemBeingClicked = document.querySelectorAll('.inputRadio');

        let productDescriptionPrice = document.querySelector('#productPrice');

        const productVariants = @json($productVariants);
        
        // Select all radio groups
        const radioGroups = document.querySelectorAll('.radio-group');

        // Get all radio buttons on the page
        let checkedValues = [];

        function handleRadioButtonChange(event) {
            const groupName = event.target.name;
            const selectedValue = event.target.value;
            checkedValues[groupName] = selectedValue;

            let currentCombo = "";

            for (var key of Object.keys(checkedValues)) {
                currentCombo += checkedValues[key] + "-";
            }

            currentCombo = currentCombo.slice(0, -1); 

            for(variant of productVariants.variants)
            {
                if(variant.name.includes(currentCombo))
                {
                    productDescriptionPrice.innerHTML = variant.price;
                    console.log(variant);
                }
            }

        }

        const radioButtons = document.querySelectorAll('input[type="radio"]');
        radioButtons.forEach((radioButton) => {
            radioButton.addEventListener('change', handleRadioButtonChange);

        });

        colors.forEach((color) => {
            color.addEventListener('click', (e) => {

                e.preventDefault();
                let currentColor = color.getAttribute('data-color');

                // Use attribute selector to select the div with the specific data-imageColor attribute
                let currentCarouselImageColor = document.querySelector(
                    `[data-imageColor="${currentColor}"]`);

                itemProductImages.forEach((carousel) => {
                    carousel.classList.remove('active');
                })

                currentCarouselImageColor.classList.add('active');

                // Remove 'active' class from all color boxes
                colors.forEach((c) => {
                    c.classList.remove('active');
                });

                // Add 'active' class only to the clicked color box
                color.classList.add('active');

            })
        })


        let product = document.querySelector("#productPrice");
        let fixedPrice = parseFloat(document.querySelector("#fixedPrice").value);
        let quantityAmount = document.querySelector("#amount");
        let stockQuantity = @json($product->stocks->quantity);
        let btn = document.querySelector('.btn-disabled');
        // console.log(btn)
        let btn_buy_disabled = document.querySelector('.btn-buy-disabled');
        // let stockQuantity = @json_encode();
        // console.log(fixedPrice);
        const productPrice = product;
        let productData = {

            amount: parseFloat(productPrice.textContent)
        };

        const disableButton = () => {
            btn.disabled = true;
            btn_buy_disabled.removeAttribute('href');
            btn_buy_disabled.style.opacity = "0.6";
        }

        if (stockQuantity == 0) {
            disableButton();
        }

        quantityAmount.onchange = (e) => {
            e.preventDefault();
            // console.log('changed');

            // let product.textContent = quantityAmount.value * fixedPrice;
            if (stockQuantity < quantityAmount.value) {
                disableButton();
            } else {
                btn.disabled = false;
                btn_buy_disabled.addAttribute('href');
                btn_buy_disabled.style.opacity = "1";
            }


        }

        // it is for increasing the amount
        function increaseAmount() {
            let quantityInput = document.querySelector("#amount");
            let currentQuantity = parseInt(quantityInput.value);

            if (currentQuantity >= 1 && currentQuantity < stockQuantity) {
                currentQuantity += 1;
                // it will be fixed Price
                productData.amount = fixedPrice * currentQuantity;
                quantityInput.value = currentQuantity.toString(); // Update input value
                product.textContent = productData.amount.toFixed(2);
            }
        }

        // it is for decreasing the amount
        function decreaseAmount() {
            let quantityInput = document.querySelector("#amount");
            let currentQuantity = parseInt(quantityInput.value);

            if (currentQuantity > 1) {
                currentQuantity -= 1;
                productData.amount -= fixedPrice;
                quantityInput.value = currentQuantity.toString();
                product.textContent = productData.amount.toFixed(2);
            }

        }

        // when the user clicks on the add to cart button 
        let cart = document.querySelector(".add-cart");

        // variable authUserId and loginRoute initialized in frontend.blade.php

        // let authUserId = @json(auth()->check());
        // let loginRoute = @json(route('login'));

        const checkAuthentication = (element) => {
            element.addEventListener('click', (e) => {
                e.preventDefault();
                window.location.href = loginRoute;
            })
        }

        if (authUserId) {
            cart.addEventListener('click', (e) => {
                // to prevent the default submission
                e.preventDefault();

                let quantityInput = document.querySelector("#amount");
                let currentQuantity = parseInt(quantityInput.value);
                // to get the data attribute on which being clicked
                productId = cart.getAttribute('data-product-id');
                fetch(`/carts-store`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },


                        // to pass the product id
                        body: JSON.stringify({
                            product_id: productId,
                            product_quantity: currentQuantity,
                        }),

                    })
                    .then(response => response.json())

                    .then(data => {
                        // console.log(data);
                        // Handle the response from the server
                        if (data.hasOwnProperty('success') && data.success) {
                            toastr.success('Product added successfully');
                        } else {

                            toastr.error('Product added successfully');
                        }
                    })
                    .catch(error => {
                        // console.log('asdf');
                        console.error(error);
                    });

            });
        } else {
            checkAuthentication(cart);
        }


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
                                // quantity: item.quantity,
                            });

                            // updateTotalPrice(items); 
                            // totalPrice+=item.price;

                            // Creating the delete button

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
                                        const total = 0;
                                        // if the total price is 0 make it 0
                                        console.log(items);
                                        if (totalPrice(items) === 0) {
                                            totalElement.textContent = 'Total Price ' +
                                                total;
                                        } else {
                                            totalElement.textContent = 'Total Price ' + (
                                                totalPrice(items) - parseFloat(item
                                                    .price));
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


        const totalPrice = (items) => {
            let total = 0;
            for (let i = 0; i < items.cartItems.length; i++) {
                total += parseFloat(items.cartItems[i].price);
            }
            return total.toFixed(2);
        }
    </script>
@endsection

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
</head>
<body>   
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
                        <a href="{{route('frontends.show')}}" class="nav-link active text-white">Home</a>
                    </li>
                    
                    

                    <li class="nav-item m-2">
                        <a href="#products" class="nav-link text-white">Products</a>
                    </li>

                    <li class="nav-item m-2">
                        <a href="#contacts" class="nav-link text-white">Contact</a>
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
                    {{-- < class="row-container"> --}}

                    
                    {{-- data here will be rendered through javascript --}}

                    {{-- for displaying the products display --}}

                </div>
                <div class="modal-footer row">
                    {{-- it will be redirected towards the checkout section --}}
                    <a href="{{route('frontends.checkout')}}">
                        <button type="button" class="btn btn-info" >Checkout</button>
                    </a>
                {{-- </div> --}}
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
            </div>
        </div>
        <main class="d-flex justify-content-center m-1" style="width: 100%;">
        @yield('home')
        </main>

        <div class="b-example-divider"></div>
        <div class="container-fluid bg-dark text-white p-4" id="contacts">
            <footer class="py-5">
              <div class="row">
                <div class="col-6 col-md-2 mb-3">
                  <h5>Section</h5>
                  <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Home</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Features</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Pricing</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">FAQs</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">About</a></li>
                  </ul>
                </div>
          
                <div class="col-6 col-md-2 mb-3">
                  <h5>Section</h5>
                  <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary>Home</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Features</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Pricing</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">FAQs</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">About</a></li>
                  </ul>
                </div>
          
                <div class="col-6 col-md-2 mb-3">
                  <h5>Section</h5>
                  <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Home</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Features</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Pricing</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">FAQs</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">About</a></li>
                  </ul>
                </div>
          
                <div class="col-md-5 offset-md-1 mb-3">
                  <form>
                    <h5>Subscribe to our newsletter</h5>
                    <p>Monthly digest of what's new and exciting from us.</p>
                    <div class="d-flex flex-column flex-sm-row w-100 gap-2">
                      <label for="newsletter1" class="visually-hidden">Email address</label>
                      <input id="newsletter1" type="text" class="form-control" placeholder="Email address">
                      <button class="btn btn-primary" type="button">Subscribe</button>
                    </div>
                  </form>
                </div>
              </div>
          
              <div class="d-flex flex-column flex-sm-row justify-content-between border-top">
                <p class="text-center">© 2023 Bibek, Inc. All rights reserved.</p>
                <ul class="list-unstyled d-flex">
                  <li class="ms-3"><a class="link-body-emphasis" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"></use></svg></a></li>
                  <li class="ms-3"><a class="link-body-emphasis" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"></use></svg></a></li>
                  <li class="ms-3"><a class="link-body-emphasis" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"></use></svg></a></li>
                </ul>
              </div>
            </footer>
          </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
@yield('script')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
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
  </head>
    <title>Document</title>
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
        
            <div class="links-container">
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
        {{-- end of the nav-bar container --}}


        {{-- start of the slider  --}}
        {{-- @php
            dd($slider);
        @endphp --}}
                  {{-- @foreach ($slider as $item)
                  1
                  @endforeach --}}
        
        <div class="carousel-container">
            <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                  @foreach ($slider as $item)
                    <div class="carousel-item active">
                        <a href="">
                        <img src="{{ asset('images/'.$item->image) }}"  class="d-block w-100 img-fluid carousel-image" alt="...">
                        </a>
                        <div class="carousel-caption d-none d-md-block">
                            <h5>First slide label</h5   >
                            <p>Representation</p>
                            <a href="{{route('frontends.categories',['id'=>$item->category_id])}}">
                                <button class="btn btn-info">Shop Now</button>
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
        <p class="fs-3 text-center m-3">Products</p>
        <div class="products-container container-fluid ">
            
            {{-- first row product --}}
            

            {{-- first row product --}}
            <div class="row container-fluid" style="max-width: 100%;">
                {{-- this is the first card --}}
                <div class="col">
                    <div class="card card-1 m-3 p-2" style="width: 18rem; height: 350px;">
                        <img src="{{asset('images/mobile.jpg')}}" style="width:100%; height:100%;" class="card-img-top card-images img-fluid" alt="...">
                        <div class="card-body">
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </div>
                </div>

                {{-- this is the second card --}}
                <div class="col">
                    <div class="card card-2 m-3 p-2" style="width: 18rem; height: 350px;">
                        <img src="{{asset('images/mobile.jpg')}}" style="width:100%; height:100%;" class="card-img-top card-images" alt="...">
                        <div class="card-body">
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </div>
                </div>

                {{-- this is the third card --}}
                <div class="col">
                    <div class="card card-3 m-3 p-2" style="width: 18rem; height: 350px;">
                        <img src="{{asset('images/mobile.jpg')}}" style="width:100%; height:100%;" class="card-img-top card-images" alt="...">
                        <div class="card-body">
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </div>
                </div>
            </div>


           {{-- end of the first row product --}}

           {{-- start of the second row product --}}
            
           <div class="row container-fluid" style="max-width: 100%;">
            {{-- this is the first card --}}
            <div class="col">
                <div class="card card-1 m-3 p-2" style="width: 18rem; height: 350px;">
                    <img src="{{asset('images/mobile.jpg')}}" style="width:100%; height:100%;" class="card-img-top card-images img-fluid" alt="...">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>

            {{-- this is the second card --}}
            <div class="col">
                <div class="card card-2 m-3 p-2" style="width: 18rem; height: 350px;">
                    <img src="{{asset('images/mobile.jpg')}}" style="width:100%; height:100%;" class="card-img-top card-images" alt="...">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>

            {{-- this is the third card --}}
            <div class="col">
                <div class="card card-3 m-3 p-2" style="width: 18rem; height: 350px;">
                    <img src="{{asset('images/mobile.jpg')}}" style="width:100%; height:100%;" class="card-img-top card-images" alt="...">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
        </div>

           {{-- end of the second row product --}}

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</body>
</html>
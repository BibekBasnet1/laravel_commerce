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
    <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"
  />
  <link rel="stylesheet"
  href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    @yield("style")
  <style>

.card:hover{
        /* transform: translate(10px, -10px); */
        /* background: #ffffff69; */
        box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
    }
  </style>
</head>
<body style="">   
    <div class="container-fluid p-0 m-0 " style="overflow:hidden;">

        {{-- start of the navbar container --}}
        <nav class="navbar navbar-expand-lg  border-bottom border-bottom-dark bg-dark text-white d-flex justify-content-around" style="min-width: 100%;">

            {{-- this is for the logo  --}}
            <div class="logo d-flex justify-content-center align-items-center">
                <p class="fs-5">Bibek</p>
            </div>

            {{-- this is for the nav-bar --}}
        
            <div class="links-container d-flex justify-content-center align-items-center">
                <ul class="navbar-nav d-flex justify-content-center" style="width: auto">
                    {{-- <li class="nav-item m-2 ">
                        <a href="{{route('frontends.show')}}" class="nav-link active text-white">Home</a>
                    </li> --}}
                    
                    

                    <li class="nav-item m-2">
                        <a href="#products" class="nav-link text-white">Products</a>
                    </li>

                    <li class="nav-item m-2">
                        <a href="#contacts" class="nav-link text-white">Contact</a>
                    </li>
                    
                </ul>
                
                {{--  --}}
               
               {{-- end of the logic  --}}

            </div>
            

            <div class="btn-container d-flex">
                
                {{-- this is for the login and register --}}
                
                @if (Route::has('login'))
                @auth
                    <a href="{{ route('frontends.show')}}" class="nav-link ms-1">
                        <button class="btn btn-primary">Home</button>
                    </a>                        
                @else
                    <a href="{{ route('login') }}" class="nav-link me-1">
                        <button class="btn btn-primary ">Login</button>
                    </a>
        
                    @if (Route::has('register'))
            
                    <a href="{{route('register')}}" class="nav-link text-white align-self-end me-1">
                        <button class="btn border btn-primary">Register</button>
                    </a>
                    @endif
                @endauth
                @endif           

            </div>
        </nav>

        {{-- this is for the searching functionality --}}

        <div class="search-container d-flex justify-content-center align-items-center">

          <form class="d-flex w-50 m-4 justify-content-center form-search" autocomplete="off" role="search"  action="{{route('frontends.searchInput')}}">
    
              <div class="autocomplete" style="width:400px;">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="searchInput" name="search">
              </div>
          
              <button class="btn btn-outline-primary btn-search ms-3" type="submit">Search</button>
          
          </form>
          
          <div class="ms-5">
              {{-- it is beasically used to get the product id --}}
                <a href="#" class="allCart" data-bs-toggle="modal" data-bs-target="#cart_model" data-user-id="{{ auth()->user()->id }}">
                     <i class="fa-solid fa-cart-shopping data-allCart-id "></i>
                </a>
                
                <a href=""> <i class="fa-solid fa-heart text-primary mx-3"></i></a>
          </div>
       
        </div>
       {{-- this is the end of the searching functionality --}}

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

        <section class="featured-products ">
          @yield("featured")
      </section>

        <div class="b-example-divider"></div>
        <div class="container-fluid bg-dark text-white p-4 mt-4" id="contacts">
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
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    
    // Select the search input field
    let searchInput = document.querySelector('#searchInput');
    let formSearch = document.querySelector('.form-search');
  
    let prevSearchValue = '';

    function autocomplete(inp, arr) {
        var currentFocus;

        inp.addEventListener("input", function(e) {
          var val = this.value;
          closeAllLists();

          
          if (val.trim() === '') {
            return false;
          }


          currentFocus = -1;

          
          var matches = arr.filter(function(item) {
            return item.substr(0, val.length).toUpperCase() === val.toUpperCase();
          });
          // console.log(matches);

          var listContainer = document.createElement("div");
          listContainer.setAttribute("id", this.id + "autocomplete-list");
          listContainer.setAttribute("class", "autocomplete-items");
          // console.log(this.parentNode);
          this.parentNode.appendChild(listContainer);

          matches.forEach(function(match, index) {
            var listItem = document.createElement("div");
            listItem.innerHTML = "<strong>" + match.substr(0, val.length) + "</strong>";
            listItem.innerHTML += match.substr(val.length);
            listItem.innerHTML += "<input type='hidden' value='" + match + "'>";

            listItem.addEventListener("click", function(e) {
              inp.value = this.getElementsByTagName("input")[0].value;
              closeAllLists();
            });

            listContainer.appendChild(listItem);
          });
        });
       
        inp.addEventListener("keydown", function(e) {
          var x = document.getElementById(this.id + "autocomplete-list");
          if (x) {
            x = x.getElementsByTagName("div");
          }

          if (e.keyCode == 40) {
            currentFocus++;
            addActive(x);
          } else if (e.keyCode == 38) {
            currentFocus--;
            addActive(x);
          } else if (e.keyCode == 13) {
            e.preventDefault();
            if (currentFocus > -1) {
              if (x) {
                x[currentFocus].click();
              }
            }
          }
        });

        function addActive(x) {
          if (!x) {
            return false;
          }
       

          if (currentFocus >= x.length) {
            currentFocus = 0;
          }

          if (currentFocus < 0) {
            currentFocus = x.length - 1;
          }

          removeActive(x)
          x[currentFocus].classList.add("autocomplete-active");
          
        }

        function removeActive(x) {
          for (var i = 0; i < x.length; i++) {
            if (i !== currentFocus) {
              x[i].classList.remove("autocomplete-active");
              // x[i].classList.remove("active-item"); // Remove the custom CSS class from non-selected items
            }
          }
        }


        function closeAllLists(elmnt) {
          var x = document.getElementsByClassName("autocomplete-items");
          for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
              x[i].parentNode.removeChild(x[i]);
            }
          }
        }

        // when clicked on recommended option just close it 
        document.addEventListener("click", function(e) 
        {
        
          // to get the searched value of the document 
          let searchValue = searchInput.value.trim();

          // setting the value in the local storage
          localStorage.setItem("input",searchValue);  
          // submission of the form 
          formSearch.submit();

        });
        
      }
      
      let storedInput = localStorage.getItem("input");
      searchInput.value = storedInput;
      
      // end of the autocomplete code 
  
      function search(searchValue)
      {
        fetch('/search', {
              method: 'POST',
              body: JSON.stringify({ search: searchValue }),
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
              },  
            })
            .then(response => response.json())
            .then(data => {
                // updateAutocompleteResults(data.products);
                var products = data.products.map(function(product){
                  return product.name;
                })
                autocomplete(searchInput,products);
                // console.log(products);
            })
            .catch(error => console.log(error));
      }

         // Add event listener for input event
         searchInput.addEventListener('input', (e) => 
         {
           let searchValue = searchInput.value.trim();  
            // calling the function that performs ajax request
            search(searchValue);
         });

</script>
@yield('script')
</body>
</html>

@extends('layouts.app')

@section('title')
    User Details
@endsection

@section('content')
<div class="container">

    <div class="create-container">
        <h3>Want to enter new entry?</h3>
        <a href="{{ route('users.addUser') }}" class="btn btn-primary mb-3">Create User</a>
    </div>

        <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal fade" id="product_model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                ...
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
            </div>
        </div>

    <table class="table">
        <thead>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </thead>
        <tbody>
            @php
                $count = 0;
            @endphp
            @foreach ($users as $key => $user)
                <tr class="">
                    <td>{{ ++$count }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>                        
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary view-products" data-bs-toggle="modal" data-bs-target="#product_model" data-user-id="{{$user->id}}">
                            View
                        </button>
                    </td>
                    <td class="d-flex align-items-center">
                        <a href="{{ route('users.edit',['id'=>$user->id]) }}" class="btn btn-success m-1">Edit</a>
                        <form action="{{ route('users.delete',['id' => $user->id]) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger m-1" onclick="return confirm('Are you sure you want to delete this {{$user->name}}?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('script')
    <script>
        
            
            const btns = document.querySelectorAll('.view-products');
            const modalBody = document.querySelector(".modal-body");

            // ajax request to take the data from the database and return it as json
            btns.forEach(btn => {
            btn.addEventListener('click', () => {
                const userId = btn.getAttribute('data-user-id');
                fetch(`/user/product/${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        modalBody.innerHTML = ''; // Clear previous content
                        data.products.forEach(product => {
                            let productName = product.name;
                            modalBody.innerHTML += productName + '<br>'; // Append product name to modal body
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

    </script>
@endsection

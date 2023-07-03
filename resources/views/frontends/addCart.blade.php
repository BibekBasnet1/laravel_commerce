@extends('layouts.categoriesApp')

@section('title')
    Category
@endsection 

@section('content')

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row border border-2 p-5">
        <div class="col-md-6">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Card Title</h5>
                    <p class="card-text">This is some sample content in the card.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Input Box -->
            <div class="input-group mb-3">
                <input type="number" class="form-control" placeholder="">
                <div class="input-group-append">
                    <span class="input-group-text">+</span>
                </div>
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>

@endsection 

@section('script')
    <script>

    </script>
@endsection 










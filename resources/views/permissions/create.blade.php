@extends('layouts.app')

@section('title')
    Add Permission
@endsection

@section('content')
<div class="container border border-2" style="width: 50%">
    <p class="text-center fs-3 m-3">Create Permission </p>
    <form action="{{route('permissions.store')}}" class="form" method="post">
        @csrf
        <div class="form-group container">
            <label for="" class="form-label mt-2 mb-2 fs-6">Permission Name</label>
            <input placeholder="" class="form-control mb-2" name="name" type="text" value="">

            {{-- <input placeholder="Product Price" class="form-control mb-2" name="price" type="number" value=""> --}}
            
            <button type="submit" class="btn btn-primary mt-2">
                Submit
            </button>
        </div>
    </form>
</div>
@endsection

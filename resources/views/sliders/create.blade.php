@extends('layouts.app')

@section('title')
    Create Sliders
@endsection

@section('content')
<div class="container border border-2" style="width: 50%">
    <p class="text-center fs-2">Create Sliders</p>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
 
    <form action="{{route('sliders.store')}}" class="form" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group container">     
            <label for="" class="form-label mt-2 mb-2 fs-6">Slider Name</label> 
            <input placeholder="" class="form-control mb-2" name="name" type="text" value="">
            <label for="" class="form-label mt-2 mb-2 fs-6">Caption Name</label> 
            <input placeholder="" class="form-control mb-2" name="caption" type="text" value="">
            {{-- <label for="" class="form-label mt-2 mb-2 fs-6">Image Name</label> 
            <input placeholder="" class="form-control mb-2" name="image" type="text" value=""> --}}
            <label for="" class="form-label mt-2 mb-2 fs-6">Product Image</label>
            <input placeholder="" class="form-control mb-2" name="image" type="file">

            <label for="" class="form-label mt-2 mb-2 fs-6">Categories Name</label> <br>
            
            <select name="category_id" class="form-select">
                @foreach ($categories as $key=> $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        {{-- <div class="permission-container" style="">
            <p class="fs-4 text-center">Permissions</p>
            @foreach($permissions as $permission)
            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="m-2" />{{ $permission->name }}_user <br>
            @endforeach
        </div> --}}
        <div class="btn-container d-flex justify-content-center " style="min-width: 100%;">
        <button type="submit" class="btn btn-success mt-5">
            Submit
        </button>
        </div>
    </form>
</div>
@endsection

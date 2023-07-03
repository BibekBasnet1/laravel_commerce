{{-- this is for the layout of the laravel --}}
@extends('layouts.app')

{{-- to give title for the page --}}
@section('title')
    Sliders Edit
@endsection

{{-- to give the content for the page --}}
@section('content')
<div class="container border border-2" style="width: 50%">
    <p class="text-center fs-3">Sliders</p>
    <form action="{{route('sliders.update',['id' => $slider->id])}}" method="post">
        {{-- we need to pass the csrf token for each user as we need it very much --}}
        @csrf
        <div class="form-group">
            {{-- to take the form input for the name --}}
            <label for="" class="form-label mt-2 mb-2">Name</label>
            <input placeholder="Name" class="form-control" name="name" type="text" value="{{$slider->name}}">
            <label for="" class="form-label mt-2 mb-2 fs-6">Caption Name</label> 
            <input placeholder="" class="form-control mb-2" name="caption" type="text" value="{{$slider->caption}}">
            <label for="" class="form-label mt-2 mb-2 fs-6">Image Name</label> 
            <input placeholder="" class="form-control mb-2" name="image" type="text" value="{{$slider->image}}">
            <label for="" class="form-label mt-2 mb-2 fs-6">Categories Name</label> <br>
            
            <select name="category_id" class="form-select">
                @foreach ($sliders as $key=> $slider)
                    {{-- @foreach($slider['category'] as $item) --}}
                    <option value="{{$slider->id}}">{{$slider->category->name}}</option>
                    {{-- @endforeach --}}
                @endforeach
            </select>           
        
        </div>
 
    <div class="btn-container d-flex justify-content-center " style="min-width: 100%;">
    <button type="submit" class="btn btn-primary mt-4 ">
        Submit
    </button>
    </div>
</form>
</div>

@endsection


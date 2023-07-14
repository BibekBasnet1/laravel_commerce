@extends('layouts.app')

@section('title')
    Create Categories
@endsection

@section('content')
<div class="container border border-2" style="width: 50%">
    <p class="text-center fs-2">Create Categories</p>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
 
    <form action="{{route('categories.store')}}" class="form" method="post">
        @csrf
        <div class="form-group container">     
            <label for="" class="form-label mt-2 mb-2 fs-6">Category Name</label> 
            <input placeholder="" class="form-control mb-2" name="name" type="text" value="">

            <label for="subCategory" class="form-label mt-2 mb-2 fs-6">Sub Category</label>
            
            <select type="text" name="parent_id" class="form-control">
                <option value="">None</option>
                @if($categories)
                    @foreach($categories as $category)
                        <?php $dash=''; ?>
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @if(count($category->subcategory))
                            {{-- @include('subCategoryList-option',['subcategories' => $category->subcategory]) --}}
                        @endif
                    @endforeach
                @endif
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

@extends('layouts.Dashboard')

@section('title', 'Edit Products ')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="mb-3">
        <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="form-group mb-2">
                <label for="store_id">Store ID</label>
                <input type="number" class="form-control" name="store_id"
                    value="{{ old('store_id', $product->store_id) }}" />
            </div>

            <div class="form-group mb-2">
                <label for="category_id">Category ID</label>
                <input type="number" class="form-control" name="category_id"
                    value="{{ old('category_id', $product->category_id) }}" />
            </div>

            <div class="form-group mb-2">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $product->name) }}" />
            </div>

            <div class="form-group mb-2">
                <label for="slug">Slug</label>
                <input type="text" class="form-control" name="slug" value="{{ old('slug', $product->slug) }}" />
            </div>

            <div class="form-group mb-2">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-group mb-2">
                <label for="price">Price</label>
                <input type="number" step="0.01" class="form-control" name="price"
                    value="{{ old('price', $product->price) }}" />
            </div>

            <div class="form-group mb-2">
                <label for="compare_price">Compare Price</label>
                <input type="number" step="0.01" class="form-control" name="compare_price"
                    value="{{ old('compare_price', $product->compare_price) }}" />
            </div>

            <div class="form-group mb-2">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" name="stock" value="{{ old('stock', $product->stock) }}" />
            </div>

            <div class="form-group mb-2">
                <label for="tags">Tags</label>
                <input type="text" class="form-control" name="tags" value="{{ old('tags', $tags) }}" />
            </div>

            <div class="form-group mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="featured" value="1" id="featured"
                        @if (old('featured', $product->featured)) checked @endif>
                    <label class="form-check-label" for="featured">
                        Featured
                    </label>
                </div>
            </div>

            <div class="status mb-3 mt-2">
                <label for="status">Status</label>
                <x-form.radio name="status" :option="['active' => 'Active', 'archived' => 'Archived', 'draft' => 'Draft']" :checked="old('status', $product->status)" />
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

@endsection

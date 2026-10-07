@extends('layouts.dashboard')

@section('title', 'Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')

    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-2">
            <label for="store_id">Store ID</label>
            <input type="number" class="form-control" name="store_id" />
        </div>

        <div class="form-group mb-2">
            <label for="category_id">Category ID</label>
            <input type="number" class="form-control" name="category_id" />
        </div>

        <div class="form-group mb-2">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" />
        </div>

        <div class="form-group mb-2">
            <label for="slug">Slug</label>
            <input type="text" class="form-control" name="slug" />
        </div>

        <div class="form-group mb-2">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" rows="3"></textarea>
        </div>

        <div class="form-group mb-2">
            <label for="price">Price</label>
            <input type="number" step="0.01" class="form-control" name="price" />
        </div>

        <div class="form-group mb-2">
            <label for="compare_price">Compare Price</label>
            <input type="number" step="0.01" class="form-control" name="compare_price" />
        </div>

        <div class="form-group mb-2">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" name="stock" />
        </div>

        <div class="form-group mb-2">
            <label for="tags">Tags</label>
            <input type="text" class="form-control" name="tags" />
        </div>

        <div class="form-group mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="featured" value="1" id="featured">
                <label class="form-check-label" for="featured">
                    Featured
                </label>
            </div>
        </div>

        <div class="status mb-3 mt-2">
            <label for="status">Status</label>
            <x-form.radio name="status" :option="['active' => 'Active', 'archived' => 'Archived', 'draft' => 'Draft']" />
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>

@endsection

@extends('layouts.dashboard')

@section('title', 'Import Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Import Products</li>
@endsection

@section('content')

    <form action="{{ route('products.import') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-2">
            <label for="count">Count</label>
            <input type="number" class="form-control" name="count" />
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Import</button>
        </div>
    </form>

@endsection

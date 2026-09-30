@extends('layouts.Dashboard')

@section('title', __('Products'))

@section('breadcrumb')
@parent
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{route('products.index')}}">{{ __('Products') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{route('products.create')}}">{{ __('Create') }}</a></li>
@endsection

<x-alert />

<div class="mb-5">
    <a href="{{route('products.create')}}" class="btn btn-ms btn-outline-primary">{{ __('Create') }}</a>
    {{-- <a href="{{route('products.trashed')}}" class="btn btn-ms btn-outline-info">{{ __('Trash') }}</a> --}}
</div>

<form action="{{URL::current()}}" method="get" class="d-flix justify-content-between mb-4">
    <input type="text" class="bg-white text-black" name="name" :value="request('name')">
    <select name="status" id="" class="form-control">
        <option value="active" @selected(request('status')=='active') >{{ __('Active') }}</option>
        <option value="inactive"  @selected(request('status')=='inactive') >{{ __('Inactive') }}</option>
    </select>
    <button type="submit" class="btn btn-dark mx-2">{{ __('Filter') }}</button>
</form>

<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>{{ __('ID') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Category') }}</th>
            <th>{{ __('Store') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Created_at') }}</th>
            <th>{{ __('Updated_at') }}</th>
            <th colspan="1">{{ __('Edit') }}</th>
            <th colspan="1">{{ __('Delete') }}</th>
        </tr>
    </thead>
    <tbody>
        @if($products->count())
        @foreach ( $products as $key => $product )
        <tr>
            <td></td>
            <td>{{ $key + 1 }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name}}</td>
            <td>{{ $product->store->name }}</td>
            <td>{{ $product->status }}</td>
            <td>{{ $product->created_at->format('d M, Y') }}</td>
            <td>{{ $product->updated_at->format('d M, Y') }}</td>
                <td><a href="{{route('products.edit',$product->id)}}"class="btn btn-sm btn-outline-success">{{ __('Edit') }}</a></td>
                <td><form action="{{route("products.destroy",$product->id)}}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Delete') }}</button>
            </form></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="7" class="alert alert-danger">{{ __('no products Found') }}</td>
        </tr>
        @endif
    </tbody>
</table>
    {{$products->withQueryString()->links()}}
@endsection

@extends('layouts.Dashboard')

@section('title', __('Products'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Products') }}</li>
@endsection

@section('content')
    <x-alert />

    <div class="mb-5">
        <a href="{{ route('products.create') }}" class="btn btn-ms btn-outline-primary">{{ __('Create') }}</a>
        {{-- <a href="{{ route('products.trashed') }}" class="btn btn-ms btn-outline-info">{{ __('Trash') }}</a> --}}
    </div>

    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
        <input type="text" class="bg-white text-black" name="name" value="{{ request('name') }}">
        <select name="status" id="status" class="form-control">
            <option value="">{{ __('All') }}</option>
            <option value="active" @selected(request('status') == 'active')>{{ __('Active') }}</option>
            <option value="inactive" @selected(request('status') == 'inactive')>{{ __('Inactive') }}</option>
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
                <th>{{ __('Edit') }}</th>
                <th>{{ __('Delete') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td></td>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category?->name ?? '-' }}</td>
                    <td>{{ $product->store?->name ?? '-' }}</td>
                    <td>{{ $product->status }}</td>
                    <td>{{ $product->created_at->format('d M, Y') }}</td>
                    <td>{{ $product->updated_at->format('d M, Y') }}</td>
                    <td>
                        <a href="{{ route('product.edit', $product->id) }}"
                            class="btn btn-sm btn-outline-success">{{ __('Edit') }}</a>
                    </td>
                    <td>
                        <form action="{{ route('products.destroy', $product->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Delete') }}</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="alert alert-danger">{{ __('no products Found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $products->withQueryString()->links() }}
@endsection

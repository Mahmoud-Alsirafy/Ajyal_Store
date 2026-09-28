@extends('layouts.Dashboard')

@section('title', $categorie->name)

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('Categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('Categories.create') }}">Create</a></li>
@endsection

<x-alert />

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Status</th>
            <th>Created_at</th>

        </tr>
    </thead>
    <tbody>
        @if ($categorie->count())
            @foreach ($categorie->Products as $key => $product)
                <tr>
                    {{-- <td>{{ $key + 1 }}</td> --}}
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->status }}</td>
                    <td>
                        @if ($product->logo_image)
                            <img src=" {{ $product->logo_image }}" height="100px" width="100px" />
                        @endif
                    </td>
                    <td>
                        @if ($Categorie->cover_images)
                            @foreach (explode(',', $Categorie->cover_images) as $image)
                                <img src="{{ asset('storage/uploads/' . $image) }}" height="50px" width="50px"
                                    style="margin:2px;" />
                            @endforeach
                        @endif
                    </td>
                    <td>{{ $product->created_at->format('d M, Y') }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="alert alert-danger">no categories Found</td>
            </tr>
        @endif
    </tbody>
</table>
@endsection

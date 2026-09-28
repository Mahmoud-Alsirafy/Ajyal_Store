@extends('layouts.Dashboard')

@section('title', 'Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('Categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('Categories.create') }}">Create</a></li>
@endsection

<x-alert />

<div class="mb-5">
    <a href="{{ route('Categories.create') }}" class="btn btn-ms btn-outline-primary">Create</a>
    <a href="{{ route('Categories.trashed') }}" class="btn btn-ms btn-outline-info">Trash</a>
</div>

<form action="{{ URL::current() }}" method="get" class="d-flix justify-content-between mb-4">
    <input type="text" class="bg-white text-black" name="name" :value="request('name')">
    <select name="status" id="" class="form-control">
        <option value="active" @selected(request('status') == 'active')>Active</option>
        <option value="inactive" @selected(request('status') == 'inactive')>Inactive</option>
    </select>
    <button type="submit" class="btn btn-dark mx-2">Filter</button>
</form>

<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Logo Image</th>
            <th>Cover Images</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Count</th>
            <th>Status</th>
            <th>Created_at</th>
            <th>Updated_at</th>
            <th colspan="1">Edit</th>
            <th colspan="1">Delete</th>
        </tr>
    </thead>
    <tbody>
        @if ($Categories->count())
            @foreach ($Categories as $key => $Categorie)
                <tr>
                    <td></td>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        @if ($Categorie->logo_image)
                            {{-- <img src="{{ asset('storage/uploads/' . $Categorie->logo_image) }}" height="100px"
                                width="100px" /> --}}
                            <img src="{{ $Categorie->logo_image }}" height="100px" width="100px" />
                        @endif
                    </td>
                    <td>
                        @if ($Categorie->cover_images)
                            {{-- @foreach (explode(',', $Categorie->cover_images) as $image)
                                <img src="{{ asset('storage/uploads/' . $image) }}" height="50px" width="50px"
                                    style="margin:2px;" />
                            @endforeach --}}
                            <img src="{{ $Categorie->cover_images }}" height="50px" width="50px"
                                style="margin:2px;" />
                        @endif
                    </td>
                    <td><a href="{{ route('Categories.show', $Categorie->id) }}">{{ $Categorie->name }}</a></td>
                    <td>{{ $Categorie->parent->name }}</td>
                    <td>{{ $Categorie->product_number }}</td>
                    <td>{{ $Categorie->status }}</td>
                    <td>{{ $Categorie->created_at->format('d M, Y') }}</td>
                    <td>{{ $Categorie->updated_at->format('d M, Y') }}</td>
                    <td><a
                            href="{{ route('Categories.edit', $Categorie->id) }}"class="btn btn-sm btn-outline-success">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('Categories.destroy', $Categorie->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="alert alert-danger">no categories Found</td>
            </tr>
        @endif
    </tbody>
</table>
{{ $Categories->withQueryString()->links() }}
@endsection

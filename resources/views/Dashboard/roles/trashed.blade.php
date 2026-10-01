@extends('layouts.Dashboard')

@section('title', 'Trashed Roles')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('Roles.index') }}">Roles</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('Roles.create') }}">Create</a></li>
@endsection

<x-alert />

<div class="mb-5">
    <a href="{{ route('Roles.index') }}" class="btn btn-ms btn-outline-primary">Back</a>
</div>

<form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
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
            <th>Status</th>
            <th>Created_at</th>
            <th>Updated_at</th>
            <th>Deleted_at</th>
            <th colspan="1">Restore</th>
            <th colspan="1">Delete</th>
        </tr>
    </thead>
    <tbody>
        @if ($categories->count())
            @foreach ($categories as $key => $Categorie)
                <tr>
                    <td></td>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        @if ($Categorie->logo_image)
                            <img src="{{ asset('storage/uploads/' . $Categorie->logo_image) }}" height="100px"
                                width="100px" />
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
                    <td>{{ $Categorie->name }}</td>
                    <td>{{ $Categorie->parent_id }}</td>
                    <td>{{ $Categorie->status }}</td>
                    <td>{{ $Categorie->created_at->format('d M, Y') }}</td>
                    <td>{{ $Categorie->updated_at->format('d M, Y') }}</td>
                    <td>{{ $Categorie->deleted_at->format('d M, Y') }}</td>
                    <td>
                        <form action="{{ route('Roles.restore', $Categorie->id) }}" method="post">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-sm btn-outline-info">Restore</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('Roles.force-delete', $Categorie->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
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
{{ $categories->withQueryString()->links() }}
@endsection

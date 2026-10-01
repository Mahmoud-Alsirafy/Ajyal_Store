@extends('layouts.Dashboard')

@section('title', __('Categories'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('Categories.index') }}">{{ __('Categories') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('Categories.create') }}">{{ __('Create') }}</a></li>
@endsection

<x-alert />

<div class="mb-5">
    @if (Auth::user()->can('category.create'))
        <a href="{{ route('Categories.create') }}" class="btn btn-ms btn-outline-primary">{{ __('Create') }}</a>
    @endif
    <a href="{{ route('Categories.trashed') }}" class="btn btn-ms btn-outline-info">{{ __('Trash') }}</a>
</div>

<form action="{{ URL::current() }}" method="get" class="d-flix justify-content-between mb-4">
    <input type="text" class="bg-white text-black" name="name" :value="request('name')">
    <select name="status" id="" class="form-control">
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
            <th>{{ __('Logo Image') }}</th>
            <th>{{ __('Cover Images') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Parent') }}</th>
            <th>{{ __('Count') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Created_at') }}</th>
            <th>{{ __('Updated_at') }}</th>
            <th colspan="1">{{ __('Edit') }}</th>
            <th colspan="1">{{ __('Delete') }}</th>
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
                    <td>
                        @can('category.update')
                            <a
                                href="{{ route('Categories.edit', $Categorie->id) }}"class="btn btn-sm btn-outline-success">{{ __('Edit') }}</a>
                        @endcan
                    </td>
                    <td>
                        @can('category.delete')
                            <form action="{{ route('Categories.destroy', $Categorie->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Delete') }}</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="alert alert-danger">{{ __('no categories Found') }}</td>
            </tr>
        @endif
    </tbody>
</table>
{{ $Categories->withQueryString()->links() }}
@endsection

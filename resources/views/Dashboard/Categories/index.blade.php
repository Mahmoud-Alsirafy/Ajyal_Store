@extends('layouts.Dashboard')

@section('title', __('Categories'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Categories') }}</li>
@endsection

@section('content')
    <x-alert />
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach

    <div class="mb-5">
        @can('create', 'App\Models\Categorie')
            <a href="{{ route('Categories.create') }}" class="btn btn-ms btn-outline-primary">{{ __('Create') }}</a>
        @endcan
        <a href="{{ route('Categories.trashed') }}" class="btn btn-ms btn-outline-info">{{ __('Trash') }}</a>
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
                <th>{{ __('Logo Image') }}</th>
                <th>{{ __('Cover Images') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Parent') }}</th>
                <th>{{ __('Count') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Created_at') }}</th>
                <th>{{ __('Updated_at') }}</th>
                <th>{{ __('Edit') }}</th>
                <th>{{ __('Delete') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($Categories as $Categorie)
                <tr>
                    <td></td>
                    <td>{{ $Categorie->id }}</td>
                    <td>
                        @if ($Categorie->logo_image)
                            <img src="{{ $Categorie->logo_image }}" height="100" width="100"
                                alt="{{ $Categorie->name }}" />
                        @endif
                    </td>
                    <td>
                        @if ($Categorie->cover_images)
                            @php
                                $coverImages = is_array($Categorie->cover_images)
                                    ? $Categorie->cover_images
                                    : explode(',', $Categorie->cover_images);
                            @endphp
                            @foreach (array_filter($coverImages) as $image)
                                <img src="{{ trim($image) }}" height="50" width="50" style="margin:2px;"
                                    alt="{{ $Categorie->name }}" />
                            @endforeach
                        @endif
                    </td>
                    <td><a href="{{ route('Categories.show', $Categorie->id) }}">{{ $Categorie->name }}</a></td>
                    <td>{{ $Categorie->parent?->name ?? '-' }}</td>
                    <td>{{ $Categorie->product_number }}</td>
                    <td>{{ $Categorie->status }}</td>
                    <td>{{ $Categorie->created_at->format('d M, Y') }}</td>
                    <td>{{ $Categorie->updated_at->format('d M, Y') }}</td>
                    <td>
                        @can('update', $Categorie)
                            <a href="{{ route('Categories.edit', $Categorie->id) }}"
                                class="btn btn-sm btn-outline-success">{{ __('Edit') }}</a>
                        @endcan
                    </td>
                    <td>
                        @can('delete', $Categorie)
                            <form action="{{ route('Categories.destroy', $Categorie->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Delete') }}</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="alert alert-danger">{{ __('no categories Found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $Categories->withQueryString()->links() }}
@endsection

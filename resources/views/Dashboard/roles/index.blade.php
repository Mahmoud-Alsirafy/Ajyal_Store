@extends('layouts.Dashboard')

@section('title', __('Role'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('Roles.index') }}">{{ __('Roles') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('Roles.create') }}">{{ __('Create') }}</a></li>
@endsection

<x-alert />

<div class="mb-5">
    @if (Auth::user()->can('category.create'))
        <a href="{{ route('Roles.create') }}" class="btn btn-ms btn-outline-primary">{{ __('Create') }}</a>
    @endif
    <a href="{{ route('Roles.trashed') }}" class="btn btn-ms btn-outline-info">{{ __('Trash') }}</a>
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
            <th>{{ __('Name') }}</th>
            <th>{{ __('Created_at') }}</th>
            {{-- <th colspan="1">{{ __('Edit') }}</th>
            <th colspan="1">{{ __('Delete') }}</th> --}}
        </tr>
    </thead>
    <tbody>
        @if ($Roles->count())
            @foreach ($Roles as $key => $Role)
                <tr>
                    <td></td>
                    <td>{{ $key + 1 }}</td>

                    <td><a href="{{ route('Roles.show', $Role->id) }}">{{ $Role->name }}</a></td>
                    <td>{{ $Role->parent->name }}</td>
                    <td>{{ $Role->created_at->format('d M, Y') }}</td>

                    <td>
                        @can('category.update')
                            <a
                                href="{{ route('Roles.edit', $Role->id) }}"class="btn btn-sm btn-outline-success">{{ __('Edit') }}</a>
                        @endcan
                    </td>
                    <td>
                        @can('category.delete')
                            <form action="{{ route('Roles.destroy', $Role->id) }}" method="post">
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
                <td colspan="9" class="alert alert-danger">{{ __('no roles Found') }}</td>
            </tr>
        @endif
    </tbody>
</table>
{{ $Roles->withQueryString()->links() }}
@endsection

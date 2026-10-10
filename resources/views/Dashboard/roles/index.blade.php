@extends('layouts.Dashboard')

@section('title', __('Role'))

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('Roles.index') }}">{{ __('Roles') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('Roles.create') }}">{{ __('Create') }}</a></li>
@endsection
@section('content')
    <x-alert />

    <div class="mb-5">
        @can('create', 'App\Models\Role')
            <a href="{{ route('Roles.create') }}" class="btn btn-ms btn-outline-primary">{{ __('Create') }}</a>
        @endcan
    </div>

    <table class="table">
        <thead>
            <tr>

                <th>{{ __('ID') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Created_at') }}</th>
                <th>{{ __('Edit') }}</th>
            </tr>
        </thead>
        <tbody>
            @if ($Roles->count())
                @foreach ($Roles as $key => $Role)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><a href="{{ route('Roles.show', $Role->id) }}">{{ $Role->name }}</a></td>
                        <td>{{ $Role->created_at->format('d M, Y') }}</td>

                        <td>
                            @can('update', $Role)
                                <a
                                    href="{{ route('Roles.edit', $Role->id) }}"class="btn btn-sm btn-outline-success">{{ __('Edit') }}</a>
                            @endcan
                        </td>
                        <td>
                            @can('delete', $Role)
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
                    <td colspan="6" class="alert alert-danger">{{ __('no roles Found') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{ $Roles->withQueryString()->links() }}
@endsection

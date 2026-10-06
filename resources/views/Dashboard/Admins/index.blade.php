@extends('layouts.dashboard')

@section('title', 'Admins')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Admins</li>
@endsection

@section('content')


    <x-alert type="success" />
    <x-alert type="info" />
    <x-alert type="error" />

    <div class="mb-5">
        <a href="{{ route('admins.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Created At</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($admins as $admin)
                <tr>
                    <td>{{ $admin->id }}</td>
                    <td><a href="{{ route('admins.edit', $admin->id) }}">{{ $admin->name }}</a></td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        @forelse ($admin->roles as $role)
                            <span class="badge bg-primary text-white">{{ $role->name }}</span>
                        @empty
                            <span class="text-muted">-</span>
                        @endforelse
                    </td>
                    <td>{{ $admin->created_at?->format('d M, Y') }}</td>
                    <td>
                        @can('admins.update')
                            <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-sm btn-outline-success">Edit</a>
                        @endcan
                    </td>
                    <td>
                        @can('admins.delete')
                            <form action="{{ route('admins.destroy', $admin->id) }}" method="post">
                                @csrf
                                <!-- Form Method Spoofing -->
                                <input type="hidden" name="_method" value="delete">
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No admins defined.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $admins->withQueryString()->links() }}

@endsection

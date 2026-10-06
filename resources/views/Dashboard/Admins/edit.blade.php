@extends('layouts.dashboard')

@section('title', 'Edit Admin')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('admins.index') }}">Admins</a></li>
    <li class="breadcrumb-item active">Edit Admin</li>
@endsection

@section('content')

    <x-alert type="error" />

    <form action="{{ route('admins.update', $admin->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        @include('dashboard.admins._form', [
            'button_label' => 'Update',
        ])
    </form>

@endsection

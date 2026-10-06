@extends('layouts.dashboard')

@section('title', 'Create Admin')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('admins.index') }}">Admins</a></li>
    <li class="breadcrumb-item active">Create Admin</li>
@endsection

@section('content')

    <x-alert type="error" />

    <form action="{{ route('admins.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        @include('dashboard.admins._form')
    </form>

@endsection

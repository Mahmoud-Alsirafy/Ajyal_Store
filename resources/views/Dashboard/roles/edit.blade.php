@extends('layouts.Dashboard')

@section('title', 'Edit Roles')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('Roles.index') }}">Roles</a></li>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="mb-3">
        <form action="{{ route('Roles.update', $role->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <label for="name">Name</label>
            <input type="name" class="form-control" name="name" value="{{ $role->name }}" />

            <div>
                <button type="submit" class="btn btn-primary">update</button>
            </div>
        </form>
    </div>

@endsection

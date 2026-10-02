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
        <form action="{{ route('Roles.update', $Role->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <label for="name">Name</label>
            <input type="name" class="form-control" name="name" value="{{ $Role->name }}" />

            <label for="abilities">Abilities</label>
            @foreach (config('abilities') as $ability_code => $ability_name)
                <div class="row mb-2">
                    <div class="col-md-6">
                        {{ $ability_name }}
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="abilities[{{ $ability_code }}]" @checked((old('abilities')[$ability_code] ?? ($role_abilities[$ability_code] ?? '')) == 'allow')
                            id="" value="allow">
                        Allow
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="abilities[{{ $ability_code }}]" @checked((old('abilities')[$ability_code] ?? ($role_abilities[$ability_code] ?? '')) == 'deny')
                            id="" value="deny">
                        Deny
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="abilities[{{ $ability_code }}]" @checked((old('abilities')[$ability_code] ?? ($role_abilities[$ability_code] ?? '')) == 'inherit')
                            id="" value="inherit">
                        Inherit
                    </div>
                </div>
            @endforeach

            <div>
                <button type="submit" class="btn btn-primary">update</button>
            </div>
        </form>
    </div>

@endsection

@extends('layouts.Dashboard')

@section('title', 'Edit Profile')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
@endsection
<x-alert />
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
        <form action="{{ route('profiley.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <label for="name">First Name</label>
            <input type="name" class="form-control" name="first_name" value="{{ $user->profile->first_name }}" /><label
                for="name">Last Name</label>
            <input type="name" class="form-control" name="last_name" value="{{ $user->profile->last_name }}" />
            <label for="birthday">birthday</label>
            <input type="date" class="form-control" name="birthday" value="{{ $user->profile->birthday }}" />
            <label for="street_address">street_address</label>
            <input type="street_address" class="form-control" name="street_address" value="{{ $user->profile->street_address }}" />
            <label for="street_address">street_address</label>
            <input type="city" class="form-control" name="city" value="{{ $user->profile->city }}" />
            <label for="state">state</label>
            <input type="state" class="form-control" name="state" value="{{ $user->profile->state }}" />
            <label for="postal_code">postal_code</label>
            <input type="postal_code" class="form-control" name="postal_code" value="{{ $user->profile->postal_code }}" />
            <label for="street_address">street_address</label>
            <input type="street_address" class="form-control" name="street_address" value="{{ $user->profile->street_address }}" />
            <div class="gender">
                <x-form.radio name="gender" :option="['male' => 'male', 'female' => 'female']" :checked="$user->profile->gender" />
            </div>
            <div>
                <button type="submit" class="btn btn-primary">update</button>
            </div>
        </form>
    </div>

@endsection

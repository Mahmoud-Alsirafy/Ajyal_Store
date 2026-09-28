@extends('layouts.Dashboard')

@section('title','Categories')

@section('breadcrumb')
@parent
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{route('Categories.index')}}">Categories</a></li>
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
    <form action="{{route('Categories.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <label for="name">Name</label>
    <input type="name" class="form-control" name="name" value="{{old('name')}}"/>
    <label for="parent_id">Parent</label>
    <select class="form-control" name="parent_id">
        <option value="">Select Parent</option>
        @foreach ( $Parents as $Parent )
            <option value="{{ $Parent->id }}" @selected(old('parent_id') == $Parent->id)>{{ $Parent->name }}</option>
        @endforeach
    </select>
    <label for="slug">Slug</label>
        <input type="slug" class="form-control" name="slug" value="{{old('slug')}}"/>
    <label for="description">Description</label>
        <input type="description" class="form-control" name="description" value="{{old('description')}}" />
    <x-form.label id='logo_iamge' name="Logo Iamge" />
        <input type="file" class="form-control" name="logo_image"/>
    <x-form.label id='cover_iamge' name="Cover Iamge" />
        <input type="file" class="form-control" name="cover_images[]" multiple />
   <div class="status">
    <x-form.radio name="status" :option="['active'=>'Active','inactive'=>'Inactive']" />
    </div>
    <button type="submit" class="btn btn-primary">Store</button>
    </div>
</form>
</div>

@endsection

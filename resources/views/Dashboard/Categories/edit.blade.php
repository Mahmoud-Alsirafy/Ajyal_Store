@extends('layouts.Dashboard')

@section('title','Edit Categories')

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
        <form action="{{route('Categories.update',$categorie->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <label for="name">Name</label>
                    <input type="name" class="form-control" name="name" value="{{$categorie->name}}"/>
                    <label for="parent_id">Parent</label>
                    <select class="form-control" name="parent_id">
                        <option value="">Select Parent</option>
                        @foreach ( $Parents as $Parent )
                            <option value="{{ $Parent->id }}" @if($Parent->id == $categorie->parent_id) selected @endif>{{ $Parent->name }}</option>
                        @endforeach
                    </select>
                    <label for="slug">Slug</label>
                        <input type="slug" class="form-control" name="slug" value="{{$categorie->slug}}"/>
                    <label for="description">Description</label>
                        <input type="description" class="form-control" name="description" value="{{$categorie->description}}"/>
                    <x-form.label id='logo_iamge' name="Logo Iamge" />
                        <input type="file" class="form-control" name="logo_image" accept="image/*"/>
                    @if($categorie->logo_image)
                        <img src="{{asset('storage/uploads/'.$categorie->logo_image)}}" height="100px" width="100px"/>
                    @endif
                    <x-form.label id='cover_iamge' name="Cover Iamge" />
                        <input type="file" class="form-control" name="cover_images[]" multiple  accept="image/*"/>
                    @if($categorie->cover_images)
                        <div>
                            @foreach(explode(',', $categorie->cover_images) as $image)
                                <img src="{{asset('storage/uploads/'.$image)}}" height="100px" width="100px" style="margin:2px;" />
                            @endforeach
                        </div>
                    @endif
                <div class="status">
                        <x-form.radio name="status" :option="['active'=>'Active','inactive'=>'Inactive']" :checked="$categorie->status"/>

                </div>
            <div>
                <button type="submit" class="btn btn-primary">update</button>
            </div>
        </form>
</div>

@endsection

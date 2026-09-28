<div>
@section('content')

@if(session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session()->has('danger'))
    <div class="alert alert-danger">{{ session('danger') }}</div>
@endif
</div>

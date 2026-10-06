@props([
    'type' => null,
])

@if (session()->has('success') && (!$type || $type === 'success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session()->has('error') && (!$type || $type === 'error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if (session()->has('info') && (!$type || $type === 'info'))
    <div class="alert alert-info">{{ session('info') }}</div>
@endif

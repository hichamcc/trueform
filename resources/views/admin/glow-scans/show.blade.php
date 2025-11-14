@extends('admin.layouts.admin')

@section('page-title', 'Glow Scan Details')
@section('page-subtitle', $scan->user->name)

@section('content')
<p class="text-silver-400">Glow scan details</p>
<a href="{{ route('admin.glow-scans.index') }}" class="text-blue-400 hover:text-blue-300">Back to Glow Scans</a>
@endsection

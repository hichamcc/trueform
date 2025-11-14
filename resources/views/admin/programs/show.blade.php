@extends('admin.layouts.admin')

@section('page-title', 'Program Details')
@section('page-subtitle', $enrollment->user->name . ' - Day ' . $enrollment->getCurrentDay())

@section('content')
<p class="text-silver-400">Program details for {{ $enrollment->user->name }}</p>
<a href="{{ route('admin.programs.index') }}" class="text-blue-400 hover:text-blue-300">Back to Programs</a>
@endsection

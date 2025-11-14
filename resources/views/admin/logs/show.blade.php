@extends('admin.layouts.admin')

@section('page-title', 'Daily Log Details')
@section('page-subtitle', $log->user->name . ' - ' . \Carbon\Carbon::parse($log->log_date)->format('M d, Y'))

@section('content')
<p class="text-silver-400">Log details</p>
<a href="{{ route('admin.logs.index') }}" class="text-blue-400 hover:text-blue-300">Back to Logs</a>
@endsection

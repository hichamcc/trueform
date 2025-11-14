@extends('layouts.dashboard')

@section('title', 'Profile Settings')
@section('page-title', 'Profile Settings')

@section('content')
    <div class="max-w-5xl space-y-6">
        <!-- Update Profile Information -->
        <div class="bg-[#141414] border border-[#2a2a2a] rounded-2xl p-8 shadow-lg">
            <div class="max-w-2xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="bg-[#141414] border border-[#2a2a2a] rounded-2xl p-8 shadow-lg">
            <div class="max-w-2xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account -->
        <div class="bg-[#141414] border border-red-900/30 rounded-2xl p-8 shadow-lg">
            <div class="max-w-2xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection

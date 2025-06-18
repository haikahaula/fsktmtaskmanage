@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4 bg-white rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Change Password</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('auth.update-password') }}">
        @csrf

        <div class="mb-4">
            <label for="current_password" class="block">Current Password</label>
            <input type="password" name="current_password" id="current_password" class="w-full border rounded p-2">
            @error('current_password')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="new_password" class="block">New Paswword</label>
            <input type="password" name="new_password" id="new_password" class="w-full border rounded p-2">
            @error('new_password')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="new_password_confirmation" class="block">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="w-full border rounded p-2">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection

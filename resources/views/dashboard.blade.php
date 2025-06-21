@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-black overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                @php
                    $role_id = Auth::user()->role_id;
                @endphp

                {{-- Admin Dashboard --}}
                @if ($role_id == 1)
                    <p class="text-lg mb-4">You are logged in as <strong>Admin</strong></p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-indigo-600 text-black p-6 rounded-xl shadow hover:shadow-lg transition">
                            <h3 class="text-3xl font-bold">{{ $newUsers }}</h3>
                            <p>New Users</p>
                            <a href="{{ route('admin.users.index') }}" class="underline text-black text-sm">View Users</a>
                        </div>

                        <div class="bg-blue-500 text-white p-6 rounded-xl shadow hover:shadow-lg transition">
                            <h3 class="text-3xl font-bold">{{ $allUsers }}</h3>
                            <p>List Users</p>
                            <a href="{{ route('admin.users.index') }}" class="underline text-white text-sm">Manage Users</a>
                        </div>

                        <div class="bg-gray-500 text-white p-6 rounded-xl shadow hover:shadow-lg transition">
                            <h3 class="text-3xl font-bold">{{ $adminCount }}</h3>
                            <p>Total Admin</p>

                            <h3 class="text-3xl font-bold">{{ $headCount }}</h3>
                            <p>Total Academic Head</p>

                            <h3 class="text-3xl font-bold">{{ $staffCount }}</h3>
                            <p>Total Academic Staff</p>
                            <a href="{{ route('admin.roles.index') }}" class="underline text-white text-sm">Manage Roles</a>
                        </div>
                    </div>

                {{-- Academic Head Dashboard --}}
                @elseif ($role_id == 2)
                    <p class="text-lg mb-4">You are logged in as <strong>Academic Head</strong></p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-blue-600 text-white p-6 rounded-xl shadow hover:shadow-lg transition">
                            <h3 class="text-2xl font-bold">📋 Tasks</h3>
                            <p>View all tasks</p>
                            <a href="{{ route('academic-head.tasks.index') }}" class="underline text-white text-sm">View Tasks</a>
                        </div>

                        <div class="bg-green-500 text-white p-6 rounded-xl shadow hover:shadow-lg transition">
                            <h3 class="text-2xl font-bold">👥 Groups</h3>
                            <p>Manage academic groups</p>
                            <a href="{{ route('academic-head.groups.index') }}" class="underline text-white text-sm">Manage Groups</a>
                        </div>
                    </div>

                {{-- Academic Staff Dashboard --}}
                @elseif ($role_id == 3)
                    <p class="text-lg mb-4">You are logged in as <strong>Academic Staff</strong></p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-blue-500 text-white p-6 rounded-xl shadow hover:shadow-lg transition">
                            <h3 class="text-2xl font-bold">📝 My Tasks</h3>
                            <p>Tasks assigned to you</p>
                            <a href="{{ route('academic-staff.tasks.index') }}" class="underline text-white text-sm">View My Tasks</a>
                        </div>

                        <div class="bg-red-500 text-white p-6 rounded-xl shadow hover:shadow-lg transition">
                            <h3 class="text-2xl font-bold">👥 My Groups</h3>
                            <p>Groups you're involved in</p>
                            <a href="{{ route('academic-staff.groups.index') }}" class="underline text-white text-sm">View My Groups</a>
                        </div>
                    </div>
                @else
                    <p class="text-red-600">Unknown role. Please contact the system administrator.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

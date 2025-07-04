@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-4 bg-white rounded shadow">
    <h2 class="text-2xl font-semibold mb-6">Create New Task</h2>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('academic-head.tasks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1" for="title">Title <span class="text-red-600">*</span></label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1" for="description">Description</label>
            <textarea name="description" id="description" rows="4"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1" for="due_date">Due Date <span class="text-red-600">*</span></label>
            <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" required
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Assign to Users</label>
            <select name="assigned_user_id[]" class="selectpicker w-full" multiple data-live-search="true" title="Select users">
                @foreach ($users->where('role_id', '!=', 1) as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label class="block font-semibold mb-1">Assign to Group</label>
            <select name="group_id" class="selectpicker w-full" data-live-search="true" title="-- Select Group --">
                <option value="">-- Select Group --</option>
                @foreach ($groups as $group)
                    <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                        {{ $group->name }}
                    </option>
                @endforeach
            </select>
            <p class="text-sm text-gray-500 mt-1">You can assign to a user or a group, but not both.</p>
        </div>


        <div class="mb-4">
            <label class="block font-semibold">Upload Documents:</label>
            <input type="file" name="documents[]" multiple class="w-full">
            <p class="text-sm text-gray-500 mt-1">You can upload multiple files.</p>
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">Create Task</button>
    </form>
</div>
@endsection

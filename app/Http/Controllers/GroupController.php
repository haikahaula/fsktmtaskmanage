<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::with('users', 'createdBy')->get();
        return view('groups.index', compact('groups'));
    }

        public function create()
    {
            $users = User::all();
            return view('groups.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'users' => 'array',
            'users.*' => 'exists:users,id',
        ]);

        $group = Group::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'created_by' => Auth::id(), // ✅ Simpan siapa yang cipta group
        ]);

        if (!empty($validated['users'])) {
            $group->users()->sync($validated['users']);
        }

        return redirect()->route('groups.index')->with('success', 'Group created successfully.');
    }

        public function show($id)
        {
            $group = Group::findOrFail($id);
            return view('groups.show', compact('group'));
        }

        public function edit($id)
        {
            $group = Group::with('users')->findOrFail($id);
            $users = User::all();
            return view('groups.edit', compact('group', 'users'));
        }

        public function update(Request $request, Group $group)
        {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'users' => 'array',
                'users.*' => 'exists:users,id',
            ]);

            $group->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
            ]);

            $group->users()->sync($validated['users'] ?? []);

            return redirect()->route('groups.index')->with('success', 'Group updated successfully.');
        }
        
        public function destroy($id)
        {
            $group = Group::findOrFail($id);
            $group->delete();

            return redirect()->route('groups.index')->with('success', 'Group deleted.');
        }

        public function creator()
        {
        }
}

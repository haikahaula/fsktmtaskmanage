<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function create(Task $task)
    {
        return view('comments.create', compact('task'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string|max:1000',
        ]);

        $comment = new Comment();
        $comment->task_id = $request->task_id;
        $comment->user_id = Auth::id();
        $comment->content = $request->content;
        $comment->save();


        $taskId = $request->task_id;
        $roleId = Auth::user()->role_id;

        if ($roleId == 3) { // academic staff
            return redirect()->route('academic-staff.tasks.show', $taskId)
                            ->with('success', 'Comment added successfully.');
        } elseif ($roleId == 2) { // academic head
            return redirect()->route('academic-head.tasks.show', $taskId)
                            ->with('success', 'Comment added successfully.');
        } elseif ($roleId == 1) { // admin
            return redirect()->route('admin.tasks.show', $taskId)
                            ->with('success', 'Comment added successfully.');
        }

        return redirect()->back()->with('success', 'Comment added.');
    }

    // public function edit(Comment $comment)
    // {
    //     $prefix = request()->segment(1); // Get 'academic-head' from URL

    //     return view('comments.edit', compact('comment', 'prefix'));
    // }

    
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment); // Optional: use policy

        $request->validate(['content' => 'required|string']);
        $comment->update(['content' => $request->content]);

        $prefix = request()->segment(1);     
        return redirect()->route("$prefix.tasks.show", $comment->task_id)
                        ->with('success', 'Comment updated.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted.');
    }
}

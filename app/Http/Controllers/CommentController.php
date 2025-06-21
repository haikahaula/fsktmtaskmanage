<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use App\Notifications\NewCommentNotification;
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

        $comment = Comment::create([
            'task_id' => $request->task_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        // Load task + assigned users + creator
        $task = Task::with('users')->find($request->task_id);

        // Notify all assigned users
        foreach ($task->users as $user) {
            if ($user->id !== Auth::id()) {
                $user->notify(new NewCommentNotification($comment, $task));
            }
        }

        // Notify the Head (creator) if not the one commenting
        if ($task->created_by && $task->created_by != Auth::id()) {
            $creator = \App\Models\User::find($task->created_by);
            if ($creator) {
                $creator->notify(new NewCommentNotification($comment, $task));
            }
        }

        return redirect()->back()->with('success', 'Comment posted and users notified.');
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

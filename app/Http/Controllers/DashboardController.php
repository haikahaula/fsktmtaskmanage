<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        $newUsers = User::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $allUsers = User::count();

        // Manual role count
        $adminCount = User::where('role_id', 1)->count();
        $headCount = User::where('role_id', 2)->count();
        $staffCount = User::where('role_id', 3)->count();

        // Return the shared dashboard view with data
        switch ($user->role_id) {
            case 1:
            case 2:
            case 3:
                return view('dashboard', compact(
                    'newUsers',
                    'allUsers',
                    'adminCount',
                    'headCount',
                    'staffCount'
                ));
            default:
                abort(403, 'Unauthorized');
        }
    }
}

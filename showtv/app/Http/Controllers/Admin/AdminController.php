<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Cannot delete your own account');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}

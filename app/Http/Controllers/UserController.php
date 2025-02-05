<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{

    public function index()
    {
        return view('admin.users', [
            'users' => User::with('office')->get()->except(auth()->id())
        ]);
    }

    public function create()
    {
        return view('admin.create_user');
    }

    public function edit(User $user)
    {
        return view('admin.create_user', [
            'user' => $user
        ]);
    }

    public function delete(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'تم حذف الموظف بنجاح');
    }

}

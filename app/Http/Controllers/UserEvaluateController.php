<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserEvaluateController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $rolesEvaluatedByUser = Role::where('evaluator_id', $user->role->id)->get()->pluck('id')->toArray();
        $users = User::whereHas('roles', function ($query) use ($rolesEvaluatedByUser) {
            $query->whereIn('role_id', $rolesEvaluatedByUser);
        })->get();
        if ($user->office) {
            $users = $users->filter(fn($needElevalte) => $user->office->id === $needElevalte->office->id);
        }
        return view('user-evaluate.index', compact('users'));
    }

    public function evaluate(User $user)
    {
        
    }
}

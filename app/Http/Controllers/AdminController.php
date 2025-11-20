<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil 5 user terbaru (berdasarkan created_at descending)
        $users = User::latest('created_at')->take(5)->get();

        // Statistik user
        $totalUser = User::count();
        $newUser = User::whereDate('created_at', today())->count();
        $activeUser = User::whereNotNull('email_verified_at')->count();

        return view('admin.dashboard', compact('users', 'totalUser', 'newUser', 'activeUser'));
    }
}
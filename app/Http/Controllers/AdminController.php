<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Car;
use App\Models\Tag;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalCars' => Car::count(),
            'totalUsers' => User::count(),
            'totalTags' => Tag::count(),
        ]);
    }

    public function tagStats()
    {
        $tags = Tag::withCount('cars')->with('cars')->get();

        return view('admin.tags.stats', compact('tags'));
    }
}
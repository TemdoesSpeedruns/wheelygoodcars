<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Car;
use App\Models\Tag;
use App\Models\CarView;

class AdminController extends Controller
{
    public function dashboard()
    {
        $activeUsers = User::has('cars')->count();

        $avgCarsPerUser = $activeUsers > 0
            ? Car::count() / $activeUsers
            : 0;

        return view('admin.dashboard', [
            'totalCars' => Car::count(),
            'totalUsers' => User::count(),
            'totalTags' => Tag::count(),
            'carsSold' => Car::whereNotNull('sold_at')->count(),
            'carsToday' => Car::whereDate('created_at', today())->count(),
            'viewsToday' => CarView::whereDate('created_at', today())->count(),
            'avgCarsPerUser' => $avgCarsPerUser,
        ]);
    }

    public function tagStats()
    {
        $tags = Tag::withCount('cars')->get();

        return view('admin.tags.stats', compact('tags'));
    }

    public function suspiciousUsers()
    {
        $users = User::with(['cars.tags'])
            ->where('is_ignored_suspicious', false)
            ->get();

        $flagged = [];

        foreach ($users as $user) {

            $score = 0;
            $reasons = [];

            if (empty($user->phone)) {
                $score++;
                $reasons[] = 'Geen telefoonnummer';
            }

            if ($user->cars->count() > 0) {
                $hasTags = $user->cars->contains(function ($car) {
                    return $car->tags->count() > 0;
                });

                if (!$hasTags) {
                    $score++;
                    $reasons[] = 'Geen tags gebruikt';
                }
            }

            if ($user->cars->count() > 0 && $user->cars->avg('price') < 1000) {
                $score++;
                $reasons[] = 'Alleen goedkope auto’s';
            }

            foreach ($user->cars as $car) {
                if ($car->production_year < 2005 && $car->mileage < 80000) {
                    $score++;
                    $reasons[] = 'Verdachte km/jaar combinatie';
                    break;
                }
            }

            $lastCar = $user->cars->sortByDesc('created_at')->first();

            if (!$lastCar || $lastCar->created_at < now()->subYear()) {
                $score++;
                $reasons[] = 'Geen recente activiteit';
            }

            if ($score >= 2) {
                $flagged[] = [
                    'user' => $user,
                    'score' => $score,
                    'reasons' => $reasons
                ];
            }
        }

        return view('admin.suspicious_users', compact('flagged'));
    }

    public function ignoreUser(User $user)
    {
        $user->is_ignored_suspicious = true;
        $user->save();

        return back()->with('success', 'User verwijderd uit suspicious list');
    }
}
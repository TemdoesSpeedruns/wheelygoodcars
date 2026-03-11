<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car; 

class CarController extends Controller
{
    public function create_step1()
    {
        return view('cars.create_step1');
    }

    public function store_step1(Request $request)
    {
        $request->validate([
            'license_plate' => 'required'
        ]);

        return redirect('/cars/create/' . $request->license_plate);
    }

    public function create_step2($license_plate)
    {
        return view('cars.create_step2', compact('license_plate'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'license_plate' => 'required',
            'make' => 'required',
            'model' => 'required',
            'mileage' => 'required|integer',
            'price' => 'required|numeric'
        ]);

        $validated['user_id'] = auth()->id();

        Car::create($validated);

        return redirect('/')->with('success', 'Car added!');
    }
}

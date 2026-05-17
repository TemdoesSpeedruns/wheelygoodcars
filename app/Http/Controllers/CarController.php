<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

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

        $licensePlate = str_replace('-', '', $request->license_plate);

        $response = Http::get(
            'https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken=' . $licensePlate
        );

        $carData = $response->json();

        if (empty($carData)) {
            return back()->withErrors([
                'license_plate' => 'Kenteken niet gevonden'
            ]);
        }

        return view('cars.create_step2', [
            'license_plate' => $request->license_plate,
            'rdw' => $carData[0]
        ]);
    }

    public function create_step2($license_plate)
    {
        return view('cars.create_step2', compact('license_plate'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'license_plate' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'mileage' => 'required|integer',
            'price' => 'required|numeric',
            'production_year' => 'nullable|integer',
            'color' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();

        Car::create($validated);

        return redirect()->route('cars.mine')
            ->with('success', 'Auto toegevoegd!');
    }

    public function mine()
    {
        $cars = Car::where('user_id', auth()->id())->get();

        return view('cars.mine', compact('cars'));
    }

    public function index()
    {
        $cars = Car::all();

        return view('cars.index', compact('cars'));
    }

    public function destroy(Car $car)
    {
        if ($car->user_id !== auth()->id()) {
            abort(403);
        }

        $car->delete();

        return redirect()->route('cars.mine')
            ->with('success', 'Auto verwijderd!');
    }

    public function pdf(Car $car)
    {
        if ($car->user_id !== auth()->id()) {
            abort(403);
        }

        $pdf = Pdf::loadView('cars.pdf', compact('car'));

        return $pdf->download('auto-' . $car->license_plate . '.pdf');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Tag;
use App\Models\CarView;
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

        $request->session()->put('rdw', $carData[0]);

        return redirect()->route('cars.create.step2', $licensePlate);
    }

    public function create_step2($license_plate)
    {
        $tags = Tag::all();
        $rdw = session('rdw');

        return view('cars.create_step2', compact('license_plate', 'tags', 'rdw'));
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
        $validated['views'] = 0;
        $validated['sold_at'] = null;

        $car = Car::create($validated);

        if ($request->has('tags')) {
            $car->tags()->attach($request->tags);
        }

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
        $cars = Car::whereNull('sold_at')
            ->orderBy('created_at', 'desc')
            ->get();

        // F5: random featured car
        $featuredId = null;

        if ($cars->count() > 0) {
            $featuredId = $cars->random()->id;
        }

        return view('cars.index', compact('cars', 'featuredId'));
    }

    public function show(Car $car)
    {
        $car->increment('views');

        CarView::create([
            'car_id' => $car->id
        ]);

        $viewsToday = CarView::where('car_id', $car->id)
            ->whereDate('created_at', today())
            ->count();

        return view('cars.show', compact('car', 'viewsToday'));
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

    public function toggleSold(Car $car)
    {
        if ($car->user_id !== auth()->id()) {
            abort(403);
        }

        $car->sold_at = $car->sold_at ? null : now();
        $car->save();

        return back();
    }

    public function updatePrice(Request $request, Car $car)
    {
        if ($car->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'price' => 'required|numeric'
        ]);

        $car->update([
            'price' => $request->price
        ]);

        return back();
    }
}
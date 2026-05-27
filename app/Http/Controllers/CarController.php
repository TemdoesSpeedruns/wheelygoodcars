<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Tag;
use App\Models\CarView;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        $response = Http::timeout(15)->get(
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            if ($file && $file->isValid()) {
                try {
                    $tmpPath = $file->getPathname();
                    if (empty($tmpPath)) {
                        throw new \RuntimeException('Uploaded file temp path missing');
                    }

                    $extension = $file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'png';
                    $filename = Str::uuid()->toString() . '.' . $extension;

                    $targetDir = storage_path('app/public/cars');
                    if (! is_dir($targetDir)) {
                        mkdir($targetDir, 0755, true);
                    }

                    $moved = $file->move($targetDir, $filename);

                    if ($moved === false) {
                        throw new \RuntimeException('Unable to move uploaded file.');
                    }

                    $imagePath = 'cars/' . $filename;

                } catch (\Throwable $e) {
                    return back()->withErrors(['image' => 'Upload failed: ' . $e->getMessage()]);
                }
            }
        }

        $car = Car::create([
            'license_plate' => $validated['license_plate'],
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'mileage' => $validated['mileage'],
            'price' => $validated['price'],
            'production_year' => $validated['production_year'] ?? null,
            'color' => $validated['color'] ?? null,
            'user_id' => auth()->id(),
            'views' => 0,
            'sold_at' => null,
            'image' => $imagePath,
        ]);


        $car->tags()->sync($request->input('tags', []));

        return redirect()
            ->route('cars.mine')
            ->with('success', 'Auto toegevoegd!');
    }

    public function mine()
    {
        $cars = Car::with('tags')
            ->where('user_id', auth()->id())
            ->get();

        return view('cars.mine', compact('cars'));
    }

    public function index(Request $request)
    {
        $query = Car::whereNull('sold_at');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        $cars = $query->with('tags')
            ->orderBy('created_at', 'desc')
            ->paginate(9)
            ->withQueryString();

        $featuredId = $cars->count() > 0 ? $cars->random()->id : null;

        $tags = Tag::all();

        return view('cars.index', compact('cars', 'featuredId', 'tags'));
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

    public function edit(Car $car)
    {
        if ($car->user_id !== auth()->id())
            abort(403);

        $tags = Tag::all();

        return view('cars.edit', compact('car', 'tags'));
    }

    public function update(Request $request, Car $car)
    {
        if ($car->user_id !== auth()->id())
            abort(403);

        $validated = $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'mileage' => 'required|integer',
            'price' => 'required|numeric',
            'production_year' => 'nullable|integer',
            'color' => 'nullable|string',
        ]);

        $car->update($validated);
        $car->tags()->sync($request->input('tags', []));

        return redirect()->route('cars.mine')
            ->with('success', 'Auto aangepast!');
    }

    public function destroy(Car $car)
    {
        if ($car->user_id !== auth()->id())
            abort(403);

        $car->delete();

        return redirect()->route('cars.mine')
            ->with('success', 'Auto verwijderd!');
    }

    public function pdf(Car $car)
    {
        if ($car->user_id !== auth()->id())
            abort(403);

        $pdf = Pdf::loadView('cars.pdf', compact('car'));

        return $pdf->download('auto-' . $car->license_plate . '.pdf');
    }

    public function toggleSold(Car $car)
    {
        if ($car->user_id !== auth()->id())
            abort(403);

        $car->sold_at = $car->sold_at ? null : now();
        $car->save();

        return back();
    }

    public function updatePrice(Request $request, Car $car)
    {
        if ($car->user_id !== auth()->id())
            abort(403);

        $request->validate([
            'price' => 'required|numeric'
        ]);

        $car->update([
            'price' => $request->price
        ]);

        return back();
    }
}
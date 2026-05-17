<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Auto PDF</title>
</head>
<body>

    <h1>Auto gegevens</h1>

    <p><strong>Kenteken:</strong> {{ $car->license_plate }}</p>
    <p><strong>Merk:</strong> {{ $car->brand }}</p>
    <p><strong>Model:</strong> {{ $car->model }}</p>
    <p><strong>Prijs:</strong> €{{ $car->price }}</p>
    <p><strong>Kilometerstand:</strong> {{ $car->mileage }}</p>
    <p><strong>Bouwjaar:</strong> {{ $car->production_year }}</p>
    <p><strong>Kleur:</strong> {{ $car->color }}</p>

</body>
</html>
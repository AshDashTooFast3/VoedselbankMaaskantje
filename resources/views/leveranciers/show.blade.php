<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leverancier Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <h1 class="h3 mb-3">Leverancier Details</h1>

        <div class="card mb-4">
            <div class="card-body">
                <div><strong>Naam:</strong> {{ $leverancier->Naam }}</div>
                <div><strong>Contactpersoon:</strong> {{ $leverancier->Contactpersoon }}</div>
                <div><strong>Leveranciernummer:</strong> {{ $leverancier->LeverancierNummer }}</div>
                <div><strong>LeverancierType:</strong> {{ $leverancier->LeverancierType }}</div>
                <div><strong>Email:</strong> {{ $leverancier->Email }}</div>
                <div><strong>Mobiel:</strong> {{ $leverancier->Mobiel }}</div>
            </div>
        </div>

        <h2 class="h5">Producten</h2>
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Barcode</th>
                        <th>Status</th>
                        <th>Datum Aangeleverd</th>
                        <th>Eerstvolgende Levering</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($producten as $product)
                        <tr>
                            <td>{{ $product->Naam }}</td>
                            <td>{{ $product->Barcode }}</td>
                            <td>{{ $product->Status }}</td>
                            <td>{{ $product->DatumAangeleverd }}</td>
                            <td>{{ $product->DatumEerstVolgendeLevering }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Geen producten gevonden</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('leveranciers.edit', $leverancier->LeverancierId) }}" class="btn btn-secondary">Wijzig</a>
            <a href="{{ route('leveranciers.index') }}" class="btn btn-primary">Terug</a>
        </div>
    </div>
</body>
</html>

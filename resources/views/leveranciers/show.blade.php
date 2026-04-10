<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht producten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid py-3">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <h1 class="h2 text-success text-decoration-underline mb-3">Overzicht producten</h1>

        <div class="table-responsive mb-4" style="max-width: 550px;">
            <table class="table table-bordered align-middle fw-bold mb-0">
                <tbody>
                    <tr>
                        <th>Naam:</th>
                        <td>{{ $leverancier->Naam }}</td>
                    </tr>
                    <tr>
                        <th>Leveranciernummer:</th>
                        <td>{{ $leverancier->LeverancierNummer }}</td>
                    </tr>
                    <tr>
                        <th>Leveranciertype:</th>
                        <td>{{ $leverancier->LeverancierType }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle fw-bold">
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Soort Allergie</th>
                        <th>Barcode</th>
                        <th>Houdbaarheidsdatum</th>
                        <th class="text-center">Wijzig Product</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($producten as $product)
                        <tr>
                            <td>{{ $product->Naam }}</td>
                            <td>{{ $product->SoortAllergie ?? '-' }}</td>
                            <td>{{ $product->Barcode }}</td>
                            <td>{{ \Carbon\Carbon::parse($product->Houdbaarheidsdatum)->format('d-m-Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('leveranciers.producten.edit', ['leverancierId' => $leverancier->LeverancierId, 'productId' => $product->ProductId]) }}"
                                    class="btn bg-light border-0 rounded-0 d-inline-flex align-items-center justify-content-center"
                                    style="width: 64px; height: 44px;"
                                    title="Wijzig Product"
                                    aria-label="Wijzig Product">
                                    <i class="bi bi-pencil-square text-primary fs-4"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Geen producten gevonden</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ route('leveranciers.index') }}" class="btn btn-primary">Terug</a>
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Home</a>
        </div>
    </div>
</body>
</html>

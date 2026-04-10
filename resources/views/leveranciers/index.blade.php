<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Leveranciers</title>
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

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h2 text-success text-decoration-underline m-0">Overzicht Leveranciers</h1>
            <form action="{{ route('leveranciers.index') }}" method="GET" class="d-flex gap-3">
                <select name="leverancier_type" class="form-select" style="min-width: 260px;">
                    <option value="">Selecteer LeverancierType</option>
                    @foreach ($leverancierTypes as $type)
                        <option value="{{ $type }}" {{ $selectedType === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-secondary">Toon Leveranciers</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle fw-bold">
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Contactpersoon</th>
                        <th>Email</th>
                        <th>Mobiel</th>
                        <th>Leveranciernummer</th>
                        <th>LeverancierType</th>
                        <th class="text-center">Product Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leveranciers as $leverancier)
                        <tr>
                            <td>{{ $leverancier->Naam }}</td>
                            <td>{{ $leverancier->Contactpersoon }}</td>
                            <td>{{ $leverancier->Email }}</td>
                            <td>{{ $leverancier->Mobiel }}</td>
                            <td>{{ $leverancier->LeverancierNummer }}</td>
                            <td>{{ $leverancier->LeverancierType }}</td>
                            <td class="text-center">
                                <a href="{{ route('leveranciers.show', $leverancier->LeverancierId) }}"
                                    class="btn bg-light border-0 rounded-0 d-inline-flex align-items-center justify-content-center"
                                    style="width: 64px; height: 44px;"
                                    title="Details"
                                    aria-label="Bekijk details">
                                    <i class="bi bi-file-earmark-text text-primary fs-4"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="alert alert-warning text-center mb-0">
                                    Er zijn geen leveranciers bekend van het geselecteerde leveringstype
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-primary">Terug</a>
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Home</a>
        </div>
    </div>
</body>
</html>

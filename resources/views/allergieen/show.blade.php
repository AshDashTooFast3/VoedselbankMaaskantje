<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allergieën in het gezin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">

        <h2 class="mb-4 text-success text-decoration-underline fw-semibold fs-3">
            Allergieën in het gezin
        </h2>

        {{-- Gezin info blok --}}
        <table class="table table-bordered w-auto mb-4">
            <tbody>
                @php
                    // Pak de eerste record uit de gezin collectie voor gezinsgegevens
                    $gezinInfo = collect($gezin)->first();
                @endphp
                @if($gezinInfo)
                    <tr>
                        <td class="fw-semibold">Gezinsnaam:</td>
                        <td>{{ $gezinInfo->Naam }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Omschrijving:</td>
                        <td>{{ $gezinInfo->Omschrijving }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Totaal aantal Personen:</td>
                        <td>{{ $gezinInfo->TotaalPersonen }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="2" class="text-center text-muted">Geen gezinsgegevens beschikbaar</td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{-- Personen tabel --}}
        <table class="table table-bordered fs-6">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Type Persoon</th>
                    <th>Allergie</th>
                    <th class="text-center fw-bold">Wijzig Allergie</th>
                </tr>
            </thead>
            <tbody>
                @forelse($gezin as $persoon)
                    <tr>
                        <td>{{ $persoon->Naam }}</td>
                        <td>{{ $persoon->TypePersoon }}</td>
                        <td>{{ $persoon->Allergie ?? 'Geen' }}</td>
                        <td class="text-center">
                            @if(!empty($persoon->PersoonId))
                                <a href="{{ route('allergie.edit', ['id' => $persoon->PersoonId, 'gezin_id' => $persoon->GezinId]) }}"
                                    class="text-primary fs-5">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center bg-warning bg-opacity-25 text-dark p-3">
                            Geen personen gevonden
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('allergieen.index') }}" class="btn btn-sm btn-secondary">Terug</a>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary">Home</a>
        </div>

    </div>
</body>

</html>
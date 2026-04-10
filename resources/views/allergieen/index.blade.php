<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allergieën Overzicht</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="resources/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-lg mt-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="mb-0 text-success text-decoration-underline fw-semibold fs-3">
                Overzicht gezinnen met allergieën
            </h2>
            <div class="d-flex gap-3 align-items-center">
                <select id="allergie-filter" class="form-select form-select-lg w-auto" name="allergie_id">
                    <option value="" disabled {{ request('allergie_id') ? '' : 'selected' }}>Selecteer Allergie</option>
                    @foreach($allergieenselector as $selector)
                        <option value="{{ $selector->Id }}" {{ request('allergie_id') == $selector->Id ? 'selected' : '' }}>
                            {{ $selector->Naam }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-lg btn-secondary" onclick="filterByAllergie()">Toon Gezinnen</button>
            </div>
        </div>

        <table class="table table-bordered fs-5 table-hover ">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Omschrijving</th>
                    <th>Volwassenen</th>
                    <th>Kinderen</th>
                    <th>Babys</th>
                    <th>Vertegenwoordiger</th>
                    <th class="text-center"><strong>Allergie Details</strong></th>
                </tr>
            </thead>
            <tbody>
                @forelse($gezinnen as $gezin)
                    <tr>
                        <td>{{ $gezin->Naam }}</td>
                        <td>{{ $gezin->Omschrijving }}</td>
                        <td>{{ $gezin->AantalVolwassenen }}</td>
                        <td>{{ $gezin->AantalKinderen }}</td>
                        <td>{{ $gezin->AantalBabys }}</td>
                        <td>{{ $gezin->IsVertegenwoordiger ? 'Ja' : 'Nee' }}</td>
                        <td class="text-center">
                            <a href="{{ route('allergie.show', $gezin->AllergieId) }}" class="text-primary fs-4">
                                <i class="bi bi-file-earmark-text"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                <tr class="my-3">
                    <td colspan="7" class="text-center bg-warning bg-opacity-25 text-dark p-3">Geen gezinnen gevonden</td>                    
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                {{ $gezinnen->links('pagination::bootstrap-4') }}
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-lg btn-primary">Home</a>
        </div>
    </div>
</body>

</html>
<script>
    function filterByAllergie() {
        const allergieId = document.getElementById('allergie-filter').value;
        window.location.href = `{{ route('allergieen.index') }}?allergie_id=${allergieId}`;
    }
</script>
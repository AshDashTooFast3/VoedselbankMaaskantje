<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Overzicht Gezinnen</title>
    <style>
        /* Een beetje styling voor de ruimte boven de tabel */
        .filter-container {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 15px;
            display: inline-block;
        }

        select,
        button {
            padding: 5px;
        }

        table {
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <h1>Overzicht gezinnen met voedselpakketten</h1>

    <div class="filter-container">
        <form action="{{ route('pakketten.index') }}" method="GET">
            <label for="eetwens_id">Filter op eetwens:</label>
            <select name="eetwens_id" id="eetwens_id">
                <option value="0">Toon alle eetwensen</option>
                @foreach ($eetwensen as $wens)
                    <option value="{{ $wens->Id }}" {{ $selectedEetwens == $wens->Id ? 'selected' : '' }}>
                        {{ $wens->Naam }}
                    </option>
                @endforeach
            </select>
            <button type="submit">Toon Gezinnen</button>
        </form>
    </div>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Gezinsnaam</th>
                <th>Omschrijving</th>
                <th>Volwassenen</th>
                <th>Kinderen</th>
                <th>Babys</th>
                <th>Vertegenwoordiger</th>
                <th>Voedselpakket details</th>
            </tr>
        </thead>
        <tbody>
            @if (count($pakketten) === 0)
                <tr>
                    <td colspan="9">
                        <div class="alert alert-warning" role="alert">
                            Geen pakketten gevonden. Probeer een ander filter.
                        </div>
                    </td>
                </tr>
            @else
                @foreach ($pakketten as $pakket)
                    <tr>
                        <td>{{ $pakket->Gezinsnaam }}</td>
                        <td>{{ $pakket->Omschrijving }}</td>
                        <td>{{ $pakket->Volwassenen }}</td>
                        <td>{{ $pakket->Kinderen }}</td>
                        <td>{{ $pakket->Babys }}</td>
                        <td>{{ $pakket->Vertegenwoordiger }}</td>
                        <td>
                            <a href="{{ route('pakketten.show', $pakket->PakketNummer) }}"
                                class="btn btn-sm btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                    height="16" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                                    <path
                                        d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z" />
                                </svg></a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>

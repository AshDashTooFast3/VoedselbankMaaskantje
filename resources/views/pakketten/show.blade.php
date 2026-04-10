<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Overzicht Voedselpakketten</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }

        .header-table {
            width: 400px;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .header-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .header-table td:first-child {
            font-weight: bold;
            background: #f9f9f9;
            width: 150px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .main-table th {
            background-color: #fcfcfc;
        }

        .btn {
            padding: 8px 15px;
            text-decoration: none;
            color: white;
            border-radius: 4px;
        }

        .btn-back {
            background: #444cf7;
        }

        .btn-home {
            background: #444cf7;
            margin-left: 5px;
        }

        h1 {
            color: #228b22;
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <h1>Overzicht Voedselpakketten</h1>

    <table class="header-table">
        <tr>
            <td>Naam:</td>
            <td>{{ $gezinInfo->Naam }}</td>
        </tr>
        <tr>
            <td>Omschrijving:</td>
            <td>{{ $gezinInfo->Omschrijving }}</td>
        </tr>
        <tr>
            <td>Totaal aantal Personen:</td>
            <td>{{ $gezinInfo->TotaalAantalPersonen }}</td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th>Pakketnummer</th>
                <th>Datum samenstelling</th>
                <th>Datum uitgifte</th>
                <th>Status</th>
                <th>Aantal producten</th>
                <th>Wijzig Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $pakket)
                <tr>
                    <td>{{ $pakket->PakketNummer }}</td>
                    <td>{{ $pakket->DatumSamenstelling }}</td>
                    <td>{{ $pakket->DatumUitgifte ?? 'Niet uitgereikt' }}</td>
                    <td>{{ $pakket->Status }}</td>
                    <td>{{ $pakket->AantalProducten }}</td>
                    <td>
                        @if ($pakket->PakketNummer)
                            <a href="{{ route('pakketten.edit', $pakket->PakketNummer) }}" class="btn btn-sm btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue"
                                    class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path
                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd"
                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                </svg>
                            </a>
                        @else
                            <span class="text-muted">Geen pakket</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; text-align: right;">
        <a href="{{ route('pakketten.index') }}" class="btn btn-back">terug</a>
        <a href="/" class="btn btn-home">home</a>
    </div>

</body>

</html>

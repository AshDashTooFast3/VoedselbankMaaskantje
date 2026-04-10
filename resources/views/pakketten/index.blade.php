<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Overzicht Gezinnen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <style>
        /* Aangepaste styling om exact te matchen met je screenshot */
        body {
            background-color: #f8f9fa; /* Lichte achtergrond buiten het witte vlak */
            padding: 2rem;
        }
        .main-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); /* Zorgt voor het "zwevende" effect uit je screenshot */
        }
        .page-title {
            color: #00aa00; /* De specifieke groene kleur */
            text-decoration: underline;
            font-size: 1.75rem;
            margin: 0;
        }
        .table th {
            color: #495057; /* Donkergrijze tekst voor de tabel koppen */
            font-weight: bold;
            border-bottom: 1px solid #dee2e6;
        }
        .table td, .table th {
            padding: 1rem 0.5rem; /* Wat meer ademruimte in de rijen */
        }
        .custom-purple {
            color: #4a3bff; /* Kleur voor het icoontje */
        }
        .btn-purple {
            background-color: #4a3bff;
            color: white;
            border: none;
        }
        .btn-purple:hover {
            background-color: #3b2ecc;
            color: white;
        }
        .btn-grey {
            background-color: #6c757d;
            color: white;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container-fluid main-container">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title">Overzicht gezinnen met voedselpakketten</h1>

            <form action="{{ route('pakketten.index') }}" method="GET" class="d-flex gap-2 align-items-center mb-0">
                <select name="eetwens_id" id="eetwens_id" class="form-select shadow-sm" style="width: auto;">
                    <option value="0">Selecteer Eetwens</option>
                    @foreach ($eetwensen as $wens)
                        <option value="{{ $wens->Id }}" {{ $selectedEetwens == $wens->Id ? 'selected' : '' }}>
                            {{ $wens->Naam }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-grey shadow-sm">Toon Gezinnen</button>
            </form>
        </div>

        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Gezinsnaam</th>
                    <th>Omschrijving</th>
                    <th>Volwassenen</th>
                    <th>Kinderen</th>
                    <th>Babys</th>
                    <th>Vertegenwoordiger</th>
                    <th class="text-center">Voedselpakket Details</th>
                </tr>
            </thead>
            <tbody>
                @if (count($pakketten) === 0)
                    <tr>
                        <td colspan="7">
                            <div class="alert alert-warning mb-0 text-center" role="alert">
                                Er zijn geen gezinnen bekent die de geselecteerde eetwens hebben
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
                            <td class="text-center">
                                <a href="{{ route('pakketten.show', $pakket->PakketNummer) }}" class="custom-purple">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="d-flex justify-content-end mt-4">
            <a href="/" class="btn btn-purple shadow-sm px-4">home</a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
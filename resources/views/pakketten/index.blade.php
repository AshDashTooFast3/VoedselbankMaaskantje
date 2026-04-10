
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Overzicht Gezinnen</title>
    <style>
        /* Een beetje styling voor de ruimte boven de tabel */
        .filter-container { margin-bottom: 20px; border: 1px solid #ccc; padding: 15px; display: inline-block; }
        select, button { padding: 5px; }
    </style>
</head>
<body>
    <h1>Overzicht gezinnen met voedselpakketten</h1>

    <div class="filter-container">
        <form action="{{ route('pakketten.index') }}" method="GET">
            <label for="eetwens_id">Filter op eetwens:</label>
            <select name="eetwens_id" id="eetwens_id">
                <option value="0">Toon alle eetwensen</option>
                @foreach($eetwensen as $wens)
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
                <th>Vertegenwoordiger</th> <th>Eetwens</th> <th>Pakketnummer</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if(count($pakketten) === 0)
                <tr>
                    <td colspan="9">
                        <div class="alert alert-warning" role="alert">
                            Geen pakketten gevonden. Probeer een ander filter.
                        </div>
                    </td>
                </tr>
            @else
                @foreach($pakketten as $pakket)
                    <tr>
                        <td>{{ $pakket->Gezinsnaam }}</td>
                        <td>{{ $pakket->Omschrijving }}</td>
                        <td>{{ $pakket->Volwassenen }}</td>
                        <td>{{ $pakket->Kinderen }}</td>
                        <td>{{ $pakket->Babys }}</td>
                        <td>{{ $pakket->Vertegenwoordiger }}</td>
                        <td>{{ $pakket->Eetwens }}</td>
                        <td>{{ $pakket->PakketNummer }}</td>
                        <td>{{ $pakket->PakketStatus }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wireframe-02: Overzicht Klanten</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .green-title { color: #4CAF50; font-size: 24px; font-weight: bold; }
        .klanten-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .klanten-table th, .klanten-table td { text-align: left; padding: 12px; border-bottom: 1px solid #e0e0e0; }
        .details-btn { text-decoration: none; color: #4285F4; }
        .home-btn { background-color: #4285F4; color: white; padding: 10px 20px; border: none; cursor: pointer; float: right; margin-top: 20px; text-decoration: none;}
    </style>
</head>
<body>

    <div style="width: 80%; margin: 0 auto;">
        <form action="{{ route('klanten.index') }}" method="GET" style="float: right;">
            <select name="postcode">
                <option value="">Selecteer Postcode</option>
                @foreach($postcodes as $pc)
                    <option value="{{ $pc }}" {{ $selectedPostcode == $pc ? 'selected' : '' }}>{{ $pc }}</option>
                @endforeach
            </select>
            <button type="submit" style="background: #6c757d; color: white; border: none; padding: 5px 15px; border-radius: 4px;">Toon Klanten</button>
        </form>

        <div style="clear: both;"></div>

        <span class="green-title">Overzicht Klanten</span>

        @if(count($klanten) > 0)
        <table class="klanten-table">
            <thead>
                <tr>
                    <th>Naam Gezin</th>
                    <th>Vertegenwoordiger</th>
                    <th>E-mailadres</th>
                    <th>Mobiel</th>
                    <th>Adres</th>
                    <th>Woonplaats</th>
                    <th>Klant Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($klanten as $klant)
                <tr>
                    <td>{{ $klant->{'Naam Gezin'} }}</td>
                    <td>{{ $klant->Vertegenwoordiger }}</td>
                    <td>{{ $klant->{'E-mailadres'} }}</td>
                    <td>{{ $klant->Mobiel }}</td>
                    <td>{{ $klant->Adres }}</td>
                    <td>{{ $klant->Woonplaats }}</td>
                    <td>
                        <a href="{{ route('klanten.show', $klant->GezinId) }}" class="details-btn" style="font-size: 20px; text-decoration: none;">📄</a> 
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div style="background-color: #fff3cd; color: #856404; padding: 20px; border: 1px solid #ffeeba; border-radius: 10px; text-align: center; margin-top: 20px;">
            Er zijn geen klanten bekend die de geselecteerde postcode hebben
        </div>
        @endif

        <a href="/" class="home-btn">home</a>
    </div>

</body>
</html>
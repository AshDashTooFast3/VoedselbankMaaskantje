<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wireframe-02: Overzicht Klanten</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .green-title { color: #4CAF50; font-size: 24px; font-weight: bold; }
        .klanten-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .klanten-table th, .klanten-table td { text-align: left; padding: 12px; border-bottom: 1px solid #e0e0e0; }
        .icon-blue { color: #007bff; font-size: 1.2rem; text-decoration: none; }
        .icon-blue:hover { color: #0056b3; }
        .details-btn { text-decoration: none; color: #4285F4; }
        .btn-blue { background-color: #4285F4; color: white; padding: 10px 20px; border: none; text-decoration: none; display: inline-block; }
        .home-btn { background-color: #4285F4; color: white; padding: 10px 20px; border: none; cursor: pointer; float: right; margin-top: 20px; text-decoration: none;}
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border: 1px solid #f5c6cb;
            text-align: center;
            font-weight: bold;
        }
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
                @if(count($klanten) > 0)
                @foreach($klanten as $klant)
                <tr>
                    <td>{{ $klant->{'Naam Gezin'} }}</td>
                    <td>{{ $klant->Vertegenwoordiger }}</td>
                    <td>{{ $klant->{'E-mailadres'} }}</td>
                    <td>{{ $klant->Mobiel }}</td>
                    <td>{{ $klant->Adres }}</td>
                    <td>{{ $klant->Woonplaats }}</td>
                    <td style="text-align: center;">
                        <a href="{{ route('klanten.show', $klant->GezinId) }}" class="icon-blue">
                             <i class="fa-regular fa-file-lines"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

        @if(count($klanten) == 0)
            <div class="alert alert-danger" style="width: 100%; box-sizing: border-box; margin-top: -1px; border-top: none; border-radius: 0 0 5px 5px;">
                Er zijn geen klanten bekend die de geselecteerde postcode hebben
            </div>
        @endif

        <div style="margin-top: 20px;">
            <a href="/" class="btn-blue" style="float: right;">home</a>
        </div>
    </div>

</body>
</html>
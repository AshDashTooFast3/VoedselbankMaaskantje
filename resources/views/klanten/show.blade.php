<style>
    body { font-family: sans-serif; padding: 20px; color: #333; line-height: 1.6; }
    .container { width: 85%; margin: 0 auto; }
    .green-title {
        color: #28a745;
        font-size: 26px;
        font-weight: bold;
        text-decoration: underline;
        display: block;
        margin-bottom: 25px;
    }
    .klanten-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; background: #fff; }
    .klanten-table td { padding: 15px; border-bottom: 1px solid #eee; }
    /* Zebra-striping voor de wireframe look */
    .klanten-table tr:nth-child(even) { background-color: #f9f9f9; }
    .klanten-table td:first-child { font-weight: bold; width: 250px; color: #555; }

    .btn-blue {
        background-color: #007bff;
        color: white;
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 4px;
        display: inline-block;
        border: none;
        font-weight: bold;
        transition: background 0.2s;
    }
    .btn-blue:hover { background-color: #0056b3; }
</style>

<div class="container">
    <span class="green-title">Klant Details {{ $klant->Voornaam }} {{ $klant->Achternaam }}</span>

    <table class="klanten-table">
        <tr><td>Voornaam</td><td>{{ $klant->Voornaam }}</td></tr>
        <tr><td>Tussenvoegsel</td><td>{{ $klant->Tussenvoegsel ?? '-' }}</td></tr>
        <tr><td>Achternaam</td><td>{{ $klant->Achternaam }}</td></tr>
        <tr><td>Geboortedatum</td><td>{{ $klant->Geboortedatum }}</td></tr>
        <tr><td>TypePersoon</td><td>Klant</td></tr>
        <tr><td>Vertegenwoordiger</td><td>{{ $klant->Vertegenwoordiger }}</td></tr>
        <tr><td>Straatnaam</td><td>{{ $klant->Straatnaam }}</td></tr>
        <tr><td>Huisnummer</td><td>{{ $klant->Huisnummer }}</td></tr>
        <tr><td>Toevoeging</td><td>{{ $klant->Toevoeging ?? '-' }}</td></tr>
        <tr><td>Postcode</td><td>{{ $klant->Postcode }}</td></tr>
        <tr><td>Woonplaats</td><td>{{ $klant->Woonplaats }}</td></tr>
        <tr><td>Email</td><td>{{ $klant->Email }}</td></tr>
        <tr><td>Mobiel</td><td>{{ $klant->Mobiel }}</td></tr>
    </table>

    <div style="margin-top: 30px;">
        <a href="{{ route('klanten.edit', $klant->GezinId) }}" class="btn-blue">Wijzig</a>
        <a href="{{ route('klanten.index') }}" class="btn-blue" style="float: right;">terug</a>
        <a href="/" class="btn-blue" style="float: right; margin-right: 15px;">home</a>
    </div>
</div>
<span class="green-title">Klant Details {{ $klant->Voornaam }} {{ $klant->Achternaam }}</span>

<table class="klanten-table">
    <tr><td>Voornaam</td><td>{{ $klant->Voornaam }}</td></tr>
    <tr><td>Tussenvoegsel</td><td>{{ $klant->Tussenvoegsel }}</td></tr>
    <tr><td>Achternaam</td><td>{{ $klant->Achternaam }}</td></tr>
    <tr><td>Mobiel</td><td>{{ $klant->Mobiel }}</td></tr>
</table>

<div style="margin-top: 20px;">
    <a href="{{ route('klanten.edit', $klant->GezinId) }}" class="btn-blue">Wijzig</a>
    <a href="{{ route('klanten.index') }}" class="btn-blue" style="float: right;">terug</a>
    <a href="/" class="btn-blue" style="float: right; margin-right: 10px;">home</a>
</div>
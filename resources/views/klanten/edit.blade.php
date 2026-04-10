<span class="green-title">Wijzig Klant Details {{ $klant->Voornaam }} {{ $klant->Achternaam }}</span>

@if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
    <meta http-equiv="refresh" content="3;url={{ route('klanten.show', $klant->GezinId) }}" />
@endif

@if($errors->any())
    <div style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px;">
        De contactgegevens kunnen niet worden gewijzigd
    </div>
@endif

<form method="POST" action="{{ route('klanten.update', $klant->GezinId) }}">
    @csrf
    @method('PUT')

    <table class="klanten-table">
        <tr><td>Voornaam</td><td><input type="text" value="{{ $klant->Voornaam }}" disabled></td></tr>
        <tr><td>Achternaam</td><td><input type="text" value="{{ $klant->Achternaam }}" disabled></td></tr>
        
        <tr>
            <td>Straatnaam</td>
            <td><input type="text" name="Straatnaam" value="{{ old('Straatnaam', $klant->Straatnaam) }}"></td>
        </tr>
        <tr>
            <td>Postcode</td>
            <td>
                <input type="text" name="Postcode" value="{{ old('Postcode', $klant->Postcode) }}">
                @error('Postcode')
                    <br><span style="color: red; font-size: 12px;">{{ $message }}</span>
                @enderror
            </td>
        </tr>
        <tr>
            <td>Woonplaats</td>
            <td><input type="text" name="Woonplaats" value="{{ old('Woonplaats', $klant->Woonplaats) }}"></td>
        </tr>
        </table>

    <div style="margin-top: 20px;">
        @if(!session('success'))
            <button type="submit" class="btn-blue">Wijzig Klant Details</button>
        @endif
        
        <a href="{{ route('klanten.show', $klant->GezinId) }}" class="btn-blue" style="float: right;">terug</a>
        <a href="/" class="btn-blue" style="float: right; margin-right: 10px;">home</a>
    </div>
</form>
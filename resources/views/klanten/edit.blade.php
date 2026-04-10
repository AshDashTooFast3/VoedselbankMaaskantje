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
    .klanten-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
    .klanten-table td { padding: 12px; border-bottom: 1px solid #eee; }
    .klanten-table tr:nth-child(even) { background-color: #f9f9f9; }

    /* Input styling */
    input[type="text"], input[type="email"] {
        width: 100%;
        max-width: 500px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }
    input:disabled { background-color: #e9ecef; color: #6c757d; cursor: not-allowed; border: 1px solid #ddd; }

    .btn-blue {
        background-color: #007bff;
        color: white;
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 4px;
        display: inline-block;
        border: none;
        font-weight: bold;
        cursor: pointer;
    }
    .alert { padding: 20px; margin-bottom: 25px; border-radius: 8px; text-align: center; font-size: 16px; font-weight: bold; }
    .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .error-text { color: #dc3545; font-size: 13px; font-weight: bold; margin-top: 5px; display: block; }
</style>

<div class="container">
    <span class="green-title">Wijzig Klant Details {{ $klant->Voornaam }} {{ $klant->Achternaam }}</span>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        <meta http-equiv="refresh" content="3;url={{ route('klanten.show', $klant->GezinId) }}" />
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            De contactgegevens kunnen niet worden gewijzigd
        </div>
    @endif

    <form method="POST" action="{{ route('klanten.update', $klant->GezinId) }}">
        @csrf
        @method('PUT')

        <table class="klanten-table">
            <tr><td>Voornaam</td><td><input type="text" value="{{ $klant->Voornaam }}" disabled></td></tr>
            <tr><td>Tussenvoegsel</td><td><input type="text" value="{{ $klant->Tussenvoegsel }}" disabled></td></tr>
            <tr><td>Achternaam</td><td><input type="text" value="{{ $klant->Achternaam }}" disabled></td></tr>
            <tr><td>Geboortedatum</td><td><input type="text" value="{{ $klant->Geboortedatum }}" disabled></td></tr>
            <tr><td>TypePersoon</td><td><input type="text" value="Klant" disabled></td></tr>
            <tr><td>Vertegenwoordiger</td><td><input type="text" value="{{ $klant->Vertegenwoordiger }}" disabled></td></tr>

            <tr>
                <td>Straatnaam</td>
                <td><input type="text" name="Straatnaam" value="{{ old('Straatnaam', $klant->Straatnaam) }}"></td>
            </tr>
            <tr>
                <td>Huisnummer</td>
                <td><input type="text" name="Huisnummer" value="{{ old('Huisnummer', $klant->Huisnummer) }}"></td>
            </tr>
            <tr>
                <td>Toevoeging</td>
                <td><input type="text" name="Toevoeging" value="{{ old('Toevoeging', $klant->Toevoeging) }}"></td>
            </tr>
            <tr>
                <td>Postcode</td>
                <td>
                    <input type="text" name="Postcode" value="{{ old('Postcode', $klant->Postcode) }}">
                    @error('Postcode')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td>Woonplaats</td>
                <td><input type="text" name="Woonplaats" value="{{ old('Woonplaats', $klant->Woonplaats) }}"></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="email" name="Email" value="{{ old('Email', $klant->Email) }}"></td>
            </tr>
            <tr>
                <td>Mobiel</td>
                <td><input type="text" name="Mobiel" value="{{ old('Mobiel', $klant->Mobiel) }}"></td>
            </tr>
        </table>

        <div style="margin-top: 30px;">
            <button type="submit" class="btn-blue">Wijzig Klant Details</button>
            <a href="{{ route('klanten.show', $klant->GezinId) }}" class="btn-blue" style="float: right;">terug</a>
            <a href="/" class="btn-blue" style="float: right; margin-right: 15px;">home</a>
        </div>
    </form>
</div>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wijzig voedselpakket status</title>
    <style>
        /* Basis stijlen voor centering */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fefefe;
            /* Zeer lichte grijze/witte achtergrond */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            /* Volledige hoogte van de viewport */
        }

        /* Container voor het gecentreerde formulier */
        .centered-container {
            background-color: #ffffff;
            width: 100%;
            max-width: 650px;
            /* Breedte van de container zoals op de foto */
            text-align: center;
            /* Centreer de koptekst */
        }

        /* De groene onderstreepte koptekst */
        h1 {
            color: #2e7d32;
            /* Donkergroen */
            text-decoration: underline;
            margin-bottom: 30px;
            font-size: 2.2em;
            font-weight: 600;
        }

        /* Styling voor de dropdown (select) */
        select {
            width: 100%;
            padding: 12px 15px;
            font-size: 1.1em;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: #fff;
            margin-bottom: 25px;
            appearance: none;
            /* Verwijder standaard browser styling */
            -webkit-appearance: none;
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%3E%3Cpath%20fill%3D%22%23666%22%20d%3D%22M7%2010l5%205%205-5z%22%2F%3E%3C%2Fsvg%3E');
            /* Pijltje toevoegen */
            background-repeat: no-repeat;
            background-position: right 10px top 50%;
            background-size: 20px auto;
        }

        /* Flexbox voor de knoppenrij: links de update, rechts de navigatie */
        .action-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Basis styling voor alle knoppen */
        .btn {
            padding: 10px 20px;
            font-size: 1.1em;
            font-weight: bold;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            /* Voor de 'a' tags */
            transition: background-color 0.2s;
        }

        /* Donkergrijze knop voor het formulier */
        .btn-update {
            background-color: #5c636a;
            /* Donkergrijs */
            color: white;
        }

        .btn-update:hover {
            background-color: #4a5056;
        }

        /* Groep voor de rechter blauwe knoppen */
        .right-nav-group {
            display: flex;
            gap: 10px;
            /* Ruimte tussen terug en home */
        }

        /* Helderblauwe navigatie knoppen */
        .btn-blue {
            background-color: #4361ee;
            /* Helderblauw */
            color: white;
        }

        .btn-blue:hover {
            background-color: #364ec4;
        }

        .alert-success {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="centered-container">
        <h1>Wijzig voedselpakket status</h1>

        {{-- Het formulier: Gebruikt de 'update' route met de PUT methode --}}
        <form action="{{ route('pakketten.update', $pakket->PakketNummer) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- De dropdown met statussen --}}
            <select name="status">
                {{-- Loop door de statussen die de controller heeft meegegeven --}}
                @foreach ($statussen as $statusOptie)
                    <option value="{{ $statusOptie }}" {{ $pakket->Status == $statusOptie ? 'selected' : '' }}>
                        {{ $statusOptie }}
                    </option>
                @endforeach
            </select>

            {{-- HTML Melding --}}
            @if (session('success'))
                <div class="alert-success"
                    @if (session('is_inactief_gezin'))
                        style="background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7;"
                    @endif>
                    {{ session('success') }}
                </div>

                @if (session('redirect_to'))
                    <script>
                        setTimeout(function() {
                            window.location.href = @json(session('redirect_to'));
                        }, 3000);
                    </script>
                @endif
            @endif

            {{-- De rij met knoppen --}}
            <div class="action-row">
                {{-- Submit knop links --}}
                <button type="submit" class="btn btn-update">Wijzig status voedselpakket</button>

                {{-- Navigatie knoppen rechts --}}
                <div class="right-nav-group">
                    {{-- Gebruik Laravel route of JavaScript history.back() voor 'terug' --}}
                    <a href="{{ route('pakketten.index') }}" class="btn btn-blue">terug</a>
                    {{-- Link naar de homepagina --}}
                    <a href="{{ url('/') }}" class="btn btn-blue">home</a>
                </div>
            </div>
        </form>
    </div>

</body>

</html>

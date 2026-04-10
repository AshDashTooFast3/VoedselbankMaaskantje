<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wijzig Allergie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5" style="max-width:600px;">

        <h2 class="mb-4 text-success text-decoration-underline fw-semibold">
            Wijzig allergie
        </h2>
        <form action="{{ route('allergie.update', $persoonId) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="persoon_id" value="{{ $persoonId }}">
            <input type="hidden" name="gezin_id" value="{{ $gezinId }}">
            <select class="form-select form-select-lg mb-4" name="allergie_id">
                @foreach($allergies as $allergeen)
                    <option value="{{ $allergeen->Id }}" {{ isset($Persoon) && $Persoon->AllergieId == $allergeen->Id ? 'selected' : '' }}>
                        {{ $allergeen->Naam }}
                    </option>
                @endforeach
            </select>

            @if (session('success'))
                <div class="alert alert-info">
                    {{ session('success') }}
                    <meta http-equiv="refresh" content="3;url={{ route('allergie.show', $gezinId) }}">
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-lg btn-secondary">Wijzig Allergie</button>
                <div class="d-flex gap-2">
                    <a href="{{ route('allergie.show', $gezinId) }}" class="btn btn-lg btn-primary">Terug</a>
                    <a href="{{ route('dashboard') }}" class="btn btn-lg btn-primary">Home</a>
                </div>
            </div>
        </form>

    </div>
</body>

</html>
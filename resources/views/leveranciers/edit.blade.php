<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leverancier Wijzigen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <div class="container py-4">
        <h1 class="h3 mb-3">Leverancier Wijzigen</h1>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('leveranciers.update', $leverancier->LeverancierId) }}" class="row g-3 needs-validation" novalidate>
            @csrf
            @method('PUT')

            <div class="col-md-6">
                <label class="form-label">Naam</label>
                <input type="text" name="Naam" class="form-control" value="{{ old('Naam', $leverancier->Naam) }}" required maxlength="150">
            </div>
            <div class="col-md-6">
                <label class="form-label">Contactpersoon</label>
                <input type="text" name="Contactpersoon" class="form-control" value="{{ old('Contactpersoon', $leverancier->Contactpersoon) }}" required maxlength="150">
            </div>
            <div class="col-md-6">
                <label class="form-label">Leveranciernummer</label>
                <input type="text" name="LeverancierNummer" class="form-control" value="{{ old('LeverancierNummer', $leverancier->LeverancierNummer) }}" required maxlength="50" pattern="^L[0-9]{4}$">
                <div class="invalid-feedback">Gebruik formaat L0001.</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">LeverancierType</label>
                <input type="text" name="LeverancierType" class="form-control" value="{{ old('LeverancierType', $leverancier->LeverancierType) }}" required maxlength="50">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="Email" class="form-control" value="{{ old('Email', $leverancier->Email) }}" maxlength="150">
            </div>
            <div class="col-md-6">
                <label class="form-label">Mobiel</label>
                <input type="text" name="Mobiel" class="form-control" value="{{ old('Mobiel', $leverancier->Mobiel) }}" maxlength="50" pattern="^[+0-9\-\s]+$">
                <div class="invalid-feedback">Gebruik alleen cijfers, +, spaties en -.</div>
            </div>

            <div class="col-12 d-flex justify-content-end gap-2">
                <a href="{{ route('leveranciers.show', $leverancier->LeverancierId) }}" class="btn btn-primary">Annuleren</a>
                <button type="submit" class="btn btn-secondary">Opslaan</button>
            </div>
        </form>
    </div>

    <script>
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach((form) => {
                form.addEventListener('submit', (event) => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>

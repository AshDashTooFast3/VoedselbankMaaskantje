<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wijzig Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid py-4" style="max-width: 860px;">
        {{-- Wireframe-04: paginatitel voor wijziging van product-houdbaarheidsdatum --}}
        <h1 class="text-success text-decoration-underline mb-5">Wijzig Product</h1>

        {{-- Wireframe-05: groene succesmelding na geldige update --}}
        @if (session('success'))
            <div class="alert alert-success" style="background-color: #b8d0c8; border-color: #94b7aa; color: #111;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Wireframe-06: rode melding wanneer update niet uitgevoerd is --}}
        @if (session('error'))
            <div class="alert alert-danger" style="background-color: #e9c9ce; border-color: #dc9aa4; color: #3b0a0a;">
                {{ session('error') }}
            </div>
        @endif

        {{-- Form post naar manager-route die de 7-dagen businessregel afdwingt --}}
        <form method="POST" action="{{ route('leveranciers.producten.update', ['leverancierId' => $leverancierId, 'productId' => $product->ProductId]) }}">
            @csrf
            @method('PUT')

            <div class="row align-items-center mb-3">
                <label class="col-md-6 col-form-label fw-bold fs-2" style="font-size: 2rem;">Houdbaarheidsdatum:</label>
                <div class="col-md-6">
                    <input
                        type="date"
                        name="Houdbaarheidsdatum"
                        class="form-control form-control-lg"
                        value="{{ old('Houdbaarheidsdatum', $product->Houdbaarheidsdatum) }}"
                        required
                    >
                </div>
            </div>

            {{-- Extra fouttekst onder het veld voor gerichte validatiefeedback --}}
            @error('Houdbaarheidsdatum')
                <p class="text-danger fs-3 mb-4" style="font-size: 2rem;">{{ $message }}</p>
            @enderror

            <div class="d-flex justify-content-between align-items-center mt-4">
                <button type="submit" class="btn btn-secondary btn-lg px-4">Wijzig Houdbaarheidsdatum</button>

                <div class="d-flex gap-2">
                    <a href="{{ route('leveranciers.show', $leverancierId) }}" class="btn btn-primary btn-lg">Terug</a>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Home</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

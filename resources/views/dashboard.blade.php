<html lang="nl">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<div class="container mt-5">
    <h1 class="mb-4">Homepagina Voedselbank Maaskantje</h1>
    <div class="list-group">
        <a href="{{ route('allergieen.index') }}">
             Overzicht Allergieën
        </a>
        <a href="{{ route('pakketten.index') }}">
            Overzicht Voedselpakketten
        </a>
        <a href="{{ route('klanten.index') }}">
         Overzicht Klanten
        </a>
        <a href="{{ route('leveranciers.index') }}">
            Overzicht Leveranciers
        </a>
    </div>
</div>
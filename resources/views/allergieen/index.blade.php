<div class="container mt-5">
    <h1>Allergieen</h1>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Beschrijving</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            @forelse($allergieen as $allergie)
                <tr>
                    <td>{{ $allergie->id }}</td>
                    <td>{{ $allergie->naam }}</td>
                    <td>{{ $allergie->beschrijving }}</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary">Bewerk</a>
                        <a href="#" class="btn btn-sm btn-danger">Verwijder</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Geen allergieen gevonden</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
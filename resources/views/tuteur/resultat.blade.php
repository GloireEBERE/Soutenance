<div class="search-results">
    <h2>Résultats de la recherche : "{{ $query }}"</h2>

    <h3>Stagiaires</h3>
    @foreach ($stagiaires as $stagiaire)
        <p>{{ $stagiaire->nom }} {{ $stagiaire->prenom }} ({{ $stagiaire->email }})</p>
    @endforeach

    <h3>Projets</h3>
    @foreach ($projets as $projet)
        <p>{{ $projet->titre_projet }} - {{ $projet->statut }}</p>
    @endforeach

    <h3>Tâches</h3>
    @foreach ($taches as $tache)
        <p>{{ $tache->nom }} : {{ $tache->description }}</p>
    @endforeach

    <h3>Rapports</h3>
    @foreach ($rapports as $rapport)
        <p>{{ $rapport->theme_rapport }} - <a href="{{ asset('storage/' . $rapport->document_rapport) }}">Voir le rapport</a></p>
    @endforeach

    {{ $stagiaires->links() }}
    {{ $projets->links() }}
    {{ $taches->links() }}
    {{ $rapports->links() }}
</div>

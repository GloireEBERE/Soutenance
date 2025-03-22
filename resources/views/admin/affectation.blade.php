<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=7">

        @include('layouts.favicon')

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js"></script>

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{ asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/admin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/admin/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/admin/vendor/quill/quill.snow.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/admin/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/admin/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/admin/vendor/simple-datatables/style.css') }}" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">
    </head>

    <body>

        <!-- ======= Header ======= -->
        @include('layouts.header')
        <!-- End Header -->

        <!-- ======= Sidebar ======= -->
        @include('layouts.sidebar')
        <!-- End Sidebar-->

        <main id="main" class="main">

            <div class="pagetitle">
                <h1>Tableau de bord</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('welcome')}}">Accueil</a>
                        </li>

                        <li class="breadcrumb-item">Admin</li>
                        
                        <li class="breadcrumb-item active">Affectation des stagiaires</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
            

            <div class="container">
                <h2 class="text-center">La liste des affectations des stagiaires</h2>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="table-responsive ">
                <table class="table table-hover">
                    <thead class="table-primary">
                        <th>#</th>

                        <th>Nom</th>

                        <th>Prénom</th>

                        <th>Email</th>

                        <th>Tuteur</th>

                        <th>Action</th>

                    </thead>
                    
                    <tbody>
                        @forelse($stagiaires as $index => $stagiaire)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>{{ $stagiaire->user->nom }}</td>

                                <td>{{ $stagiaire->user->prenom }}</td>

                                <td>{{ $stagiaire->user->email }}</td>

                                <td>
                                    @if(is_null($stagiaire->tuteur_id)) 
                                        <span class="text-danger">Non affecté</span>
                                    @else
                                        <span class="text-success">
                                            {{ $stagiaire->tuteur->user->nom ?? 'Tuteur inconnu' }} {{ $stagiaire->tuteur->user->prenom ?? '' }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if(is_null($stagiaire->tuteur_id))
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assignModal" data-stagiaire-id="{{ $stagiaire->id }}">
                                            Affecter
                                        </button>
                                    @else
                                        <span class="text-secondary">Déjà affecté(e)</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Aucun enregistrement trouvé !</td>
                            </tr>
                        @endforelse
                    </tbody>
                    
                </table>

                <!-- Modale d'Affectation -->
                <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('affectation.assign', ':stagiaire_id') }}" id="assignForm">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="assignModalLabel">Affecter un Tuteur</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                
                                <div class="modal-body">
                                    <label for="tuteur">Choisissez un tuteur :</label>
                                    <select name="tuteur_id" id="tuteur" class="form-select" required>
                                        @foreach($tuteurs as $tuteur)
                                            <option value="{{ $tuteur->id }}">
                                                {{ $tuteur->user->nom }} {{ $tuteur->user->prenom }} : ({{ $tuteur->stagiaires_count ?? 'aucun' }} stagiaire(s))
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Affecter</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Vendor JS Files -->
        @include('layouts.vendorJs')

        <!-- Template Main JS File -->
        <script src="{{ asset('assets/admin/js/main.js') }}"></script>

        <script>
            const assignForm = document.getElementById('assignForm');
            const assignModal = document.getElementById('assignModal');

            assignModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const stagiaireId = button.getAttribute('data-stagiaire-id');
                assignForm.action = assignForm.action.replace(':stagiaire_id', stagiaireId);
            });
        </script>
    </body>
</html>
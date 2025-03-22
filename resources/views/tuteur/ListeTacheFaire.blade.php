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
        @include('layouts.tuteurHeader')
        <!-- End Header -->

        <!-- ======= Sidebar ======= -->
        @include('layouts.tuteurSidebar')
        <!-- End Sidebar-->

        <main id="main" class="main">

            <div class="pagetitle">
                <h1>Tableau de bord</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('welcome')}}">Accueil</a>
                        </li>

                        <li class="breadcrumb-item">Tuteur</li>
                        
                        <li class="breadcrumb-item active">La liste des tâches à accomplir</li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->
            

            <div class="container">
                <h2 class="text-center">La liste des tâches à accomplir</h2>
                @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </div>

            <div class="table-responsive">
                @if($taches->isEmpty())
                    <p class="text-center text-danger">Aucune tâche n'a été trouvée.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Titre</th>
                                <th>Stagiaire</th>
                                <th>Statut</th>
                                
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($taches as $index => $tache)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>{{ $tache->titre_tache }}</td>

                                    <td>
                                        {{ $tache->stagiaire->user->nom }} {{ $tache->stagiaire->user->prenom }}
                                    </td>
                                    
                                    <td>En cours</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </main>

        <!-- Vendor JS Files -->
        @include('layouts.vendorJs')

        <!-- Template Main JS File -->
        <script src="{{ asset('assets/admin/js/main.js') }}"></script>
    </body>
</html>
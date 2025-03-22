<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=7">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        @include('layouts.favicon')
        
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
        @include('layouts.welheade')
        <!-- End Header -->

        <!-- ======= Sidebar ======= -->
        @include('layouts.stagiaireSidebar')
        <!-- End Sidebar-->

        <main id="main" class="main">

            <div class="pagetitle">
                <h1>Tableau de bord</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('welcome')}}">Accueil</a>
                        </li>

                        <li class="breadcrumb-item">Stagiaire</li>
                        
                        <li class="breadcrumb-item active">Liste des projets déjà effectués</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <div class="container">
                <h2 class="text-center">La liste des projets déjà effectués</h2>

                @if(Session::has('message'))
                    <div class="alert alert-info" role="alert">{{Session::get('message')}}</div>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Titre du projet</th>

                            <th>Date de début</th>

                            <th>Date de fin</th>

                            <th>Statut</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @forelse($projets as $projet)
                            @if($projet->status !== 'en cours')
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $projet->titre_projet }}</td>

                                    <td>
                                        {{ $projet->date_debut ? \Carbon\Carbon::parse($projet->date_debut)->format('d/m/Y') : 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $projet->date_fin ? \Carbon\Carbon::parse($projet->date_fin)->format('d/m/Y') : 'N/A' }}
                                    </td>

                                    <td>
                                        <span class="badge bg-{{ $projet->statut === 'terminé' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($projet->statut) }}
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Aucun projet terminé pour le moment.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </main>

        <!-- Vendor JS Files -->
        @include('layouts.vendorJs')

        <!-- Template Main JS File -->
        <script src="{{ asset('assets/admin/js/main.js') }}"></script>
    </body>
</html>
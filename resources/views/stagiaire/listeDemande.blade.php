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
                        
                        <li class="breadcrumb-item active">Mes demandes</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <div class="container">
                <h2 class="text-center">Mes demandes de stage</h2>

                @if(Session::has('message'))
                    <div class="alert alert-info" role="alert">{{Session::get('message')}}</div>
                @endif
            </div>

            <div class="table-responsive ">
                @if($stagiaire->demandes->isEmpty())
                    <p class="text-center">Vous n'avez pas encore de demande de stage !</p>
                @else
                    <table class="table table-hover">
                        <thead class="table-primary">
                            <th>#</th>

                            <th>Date de soumission</th>

                            <th>Statut</th>

                            <th>Action</th>

                        </thead>
                        
                        <tbody>
                            @foreach($demandes as $index => $demande)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>{{ $demande->date_soumission}}</td>

                                    <td>
                                        @if($demande->statut == 'en attente')
                                            <span class="badge bg-warning text-dark">En attente</span>
                                        @elseif($demande->statut == 'acceptée')
                                            <span class="badge bg-success">Accepté</span>
                                        @elseif($demande->statut == 'refusée')
                                            <span class="badge bg-danger">Refusé</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($demande->statut == 'en attente')
                                            <a href="{{ route('demande.affiche', $demande->id) }}" class="btn btn-sm btn-primary">Modifier</a>
                                            
                                            <form action="{{ route('demande.delete', $demande->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette demande ?')">Supprimer</button>
                                            </form>
                                        @else
                                            <!-- Rien à afficher si le statut n'est pas "en attente" -->
                                        @endif
                                    </td>
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
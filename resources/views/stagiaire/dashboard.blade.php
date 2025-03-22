<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        @include('layouts.favicon')

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
                        
                        <li class="breadcrumb-item active">Tableau de bord</li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title --> 

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @php
                $demandeRecente = $demandes->first();
            @endphp

            @if ($demandeRecente)
                @if ($demandeRecente->statut === 'en attente')
                    <!-- Cas en attente -->
                    <div class="text-center">
                        <div class="flex justify-center items-center">
                            <svg class="w-16 h-16 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 2a10 10 0 0110 10 10 10 0 11-20 0 10 10 0 0110-10zm0 18a8 8 0 100-16 8 8 0 000 16zm-1-13a1 1 0 112 0v6a1 1 0 11-2 0V7zm1 10a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-yellow-600 font-medium mt-4">Demande en attente d'approbation.</p>
                    </div>
                @elseif ($demandeRecente->statut === 'acceptée')
                    <!-- Cas acceptée -->
                    <div class="text-center">
                        <div class="flex justify-center items-center">
                            <svg class="w-16 h-16 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 2a10 10 0 0110 10 10 10 0 11-20 0 10 10 0 0110-10zm-1.47 14.17l5.64-5.63-1.41-1.42-4.23 4.22-1.95-1.95-1.42 1.42 3.37 3.36z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-green-600 font-medium mt-4">Votre demande a été acceptée.</p>
                    </div>
                @elseif ($demandeRecente->statut === 'refusée')
                    <!-- Cas refusée -->
                    <div class="text-center">
                        <div class="flex justify-center items-center">
                            <svg class="w-16 h-16 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M12 2a10 10 0 0110 10 10 10 0 11-20 0 10 10 0 0110-10zm-3.54 13.06l2.83-2.83 2.83 2.83 1.41-1.41-2.83-2.83 2.83-2.83-1.41-1.41-2.83 2.83-2.83-2.83-1.41 1.41 2.83 2.83-2.83 2.83z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-red-600 font-medium mt-4">Votre demande a été refusée.</p>
                    </div>
                @endif
            @else
                <!-- Cas aucune demande -->
                <div class="text-center">
                    <div class="flex justify-center items-center">
                        <svg class="w-16 h-16 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M12 2a10 10 0 0110 10 10 10 0 11-20 0 10 10 0 0110-10zm-1 14a1 1 0 100-2h-2a1 1 0 100 2h2zm0-4a1 1 0 100-2h-2a1 1 0 100 2h2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-gray-600 font-medium mt-4">Vous n'avez pas soumis de demande.</p>
                </div>
            @endif

        </main>
        <!-- End #main -->


        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        @include('layouts.vendorJs')

        <!-- Template Main JS File -->
        <script src="{{ asset('assets/admin/js/main.js') }}"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Remplacez cette variable par le statut réel provenant de votre backend
                const statutDemande = "refusée"; // "en attente", "acceptée", ou "refusée"

                // Récupération des éléments
                const enAttenteElement = document.getElementById("en-attente");
                const accepteElement = document.getElementById("accepte");
                const refuseElement = document.getElementById("refuse");

                // Affichage conditionnel
                if (statutDemande === "en attente") {
                    enAttenteElement.classList.remove("hidden");
                } else if (statutDemande === "acceptée") {
                    accepteElement.classList.remove("hidden");
                } else if (statutDemande === "refusée") {
                    refuseElement.classList.remove("hidden");
                }
            });
        </script>

        <script src="https://cdn.tailwindcss.com"></script>

    </body>

</html>
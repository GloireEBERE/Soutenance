<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="description">
        <meta content="" name="keywords">

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

        <!-- =======================================================
        * Template Name: NiceAdmin
        * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
        * Updated: Apr 20 2024 with Bootstrap v5.3.3
        * Author: BootstrapMade.com
        * License: https://bootstrapmade.com/license/
        ======================================================== -->
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
                        
                        <li class="breadcrumb-item active">Projet à faire</li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->

            <div class="container">
                @if(Session::has('message'))
                    <div class="alert alert-info" role="alert">{{Session::get('message')}}</div>
                @endif 
            </div>

            <div class="flex items-center justify-center bg-gray-100">
                <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Attribution de projet</h2>
                    <form action="{{ route('projetAttribuer') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                        @csrf
                        <!-- Champ pour le titre -->
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 font-medium">Titre</label>
                            <input 
                                type="text" 
                                id="titre_projet" 
                                name="titre_projet" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                                placeholder="Entrez le titre du projet" 
                                required 
                            />
                            @error('titre_projet')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Champ pour la description -->
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-medium">Description</label>
                            <textarea 
                                id="description_projet" 
                                name="description_projet" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                                placeholder="Entrez la description du projet" 
                                rows="4" 
                                required
                            ></textarea>
                        </div>

                        <!-- Liste déroulante pour sélectionner le stagiaire -->
                        <div class="mb-4">
                            @if(empty($stagiaires))
                                <p class="text-red-500">Aucun stagiaire disponible pour l'attribution.</p>
                            @else
                                <label for="stagiaire_id" class="block text-gray-700 font-medium">Sélectionnez un stagiaire</label>
                                    <select 
                                        name="stagiaire_id" 
                                        id="stagiaire_id" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        required
                                        {{ empty($stagiaires) ? 'disabled' : '' }}
                                    >
                                    @foreach ($stagiaires as $stagiaire)
                                        <option value="{{ $stagiaire->id }}">{{ $stagiaire->user->nom }} {{ $stagiaire->user->prenom }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <!-- Champ pour la date de début -->
                        <div class="mb-4">
                            <label for="date_debut" class="block text-gray-700 font-medium">Date de début</label>
                            <input 
                                type="date" 
                                id="date_debut" 
                                name="date_debut" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                                readonly 
                                required 
                            />
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="text-center mt-4">
                            <button 
                                type="submit" 
                                class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-400 focus:ring-offset-2"
                            >
                                Envoyer
                            </button>
                        </div>
                    </form>
                </div>
            </div>


        </main><!-- End #main -->

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
            <i class="bi bi-arrow-up-short"></i>
        </a>

        <!-- Vendor JS Files -->
        @include('layouts.vendorJs')

        <!-- Template Main JS File -->
        <script src="{{ asset('assets/admin/js/main.js') }}"></script>

        <script>
            // Script pour définir automatiquement la date actuelle
            window.onload = function () {
                const today = new Date().toISOString().split("T")[0];
                document.getElementById("date_debut").value = today;
            };
        </script>

        <script src="https://cdn.tailwindcss.com"></script>

    </body>

</html>
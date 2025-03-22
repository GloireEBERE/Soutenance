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
                        
                        <li class="breadcrumb-item active">Liste des demandes de stage</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <div class="container">
                <h2 class="text-center">Liste des demandes de stage</h2>
                @if(Session::has('message'))
                    <div class="alert alert-info" role="alert">{{Session::get('message')}}</div>
                @endif
            </div>

            <div class="table-responsive ">
                @if($stagiaires->isEmpty())
                    <p class="text-center">Aucun stagiaire n'a fait de demande de stage</p>
                @else
                    <table class="table table-hover">
                        <thead class="table-primary">
                            <th>#</th>

                            <th>Nom</th>

                            <th>Prénom</th>

                            <th>Email</th>

                            <th>Photo</th>

                            <th>Rôle</th>

                            <th>Action</th>

                        </thead>
                        
                        <tbody>
                            @foreach($stagiaires as $index => $stagiaire)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>{{ $stagiaire->user->nom }}</td>

                                    <td>{{ $stagiaire->user->prenom }}</td>

                                    <td>{{ $stagiaire->user->email }}</td>

                                    <td>
                                        <div class="showPhoto">
                                            <div id="imagePreview" style="background-image: url('{{ $stagiaire->user->photo ? asset('uploads/' . $stagiaire->user->photo) : asset('/img/logo.png') }}');"></div>
                                        </div>
                                    </td>

                                    <td>{{ $stagiaire->user->role }}</td>

                                    <td>
                                        @php
                                            $latestDemande = $stagiaire->demandes->last();
                                        @endphp

                                        @if($latestDemande)
                                            @if($latestDemande->statut === 'acceptée')
                                                <span class="text-success">Acceptée</span>
                                            @elseif($latestDemande->statut === 'refusée')
                                                <span class="text-danger">Refusée</span>
                                            @else
                                                <button class="btn btn-secondary accept-btn" data-id="{{ $latestDemande->id }}">Accepter</button>
                                                <button class="btn btn-danger reject-btn" data-id="{{ $latestDemande->id }}">Refuser</button>
                                            @endif
                                        @else
                                            <span class="text-muted">Aucune demande.</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <style>
                .showPhoto
                {
                    width: 51%;
                    height: 51px;
                    margin: auto;
                }

                .showPhoto>div
                {
                    width: 90%;
                    height: 90%;
                    border-radius: 50%;
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-position: center;
                }
            </style>

            <script>
                $(document).on('click', '.accept-btn', function() {
                    //console.log('Bouton Accepter cliqué');
                    const userId = $(this).data('id');
                    console.log("Accepter l'utilisateur avec ID:", userId);
                    $.ajax({
                        url: `/accept/${userId}`,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.status === 'success') {
                                alert('Utilisateur accepté avec succès.');
                                location.reload();
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            alert('Erreur lors de la validation.');
                        }
                    });
                });

                $(document).on('click', '.reject-btn', function() {
                    //console.log('Bouton Refuser cliqué');
                    const userId = $(this).data('id');
                    console.log("Refuser l'utilisateur avec ID:", userId);
                    $.ajax({
                        url: `/reject/${userId}`,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.status === 'success') {
                                alert('Utilisateur refusé avec succès.');
                                location.reload();
                            }
                        },
                        error: function() {
                            console.error(xhr.responseText);
                            alert('Erreur lors du refus.');
                        }
                    });
                });

            </script>

        </main>

        <!-- Vendor JS Files -->
        @include('layouts.vendorJs')

        <!-- Template Main JS File -->
        <script src="{{ asset('assets/admin/js/main.js') }}"></script>
    </body>
</html>
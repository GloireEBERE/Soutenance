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
                        
                        <li class="breadcrumb-item active">La liste des validations</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <div class="container">
                <h2 class="text-center">La liste des stagiaires acceptés</h2>
                @if(Session::has('message'))
                    <div class="alert alert-info" role="alert">{{Session::get('message')}}</div>
                @endif

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

                        <th>Photo</th>

                        <th>Statut</th>

                    </thead>
                    
                    <tbody>
                        @forelse($stagiaires as $index => $stagiaire)
                            <tr>
                                <td>{{ $index + 1 }}</td> 

                                <td>{{ $stagiaire->user->nom }}</td>

                                <td>{{ $stagiaire->user->prenom }}</td>

                                <td>{{ $stagiaire->user->email }}</td>

                                <td>
                                    <div class="showPhoto">
                                        <div id="imagePreview" style="@if($stagiaire->user->photo != '') background-image:url('{{ asset($stagiaire->user->photo) }}')@else background-image: url('{{ url('/img/logo.png') }}') @endif;"></div>
                                    </div>
                                </td>

                                <td>{{ $stagiaire->demandes->where('statut', 'acceptée')->first()->statut }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">Aucun enregistrement trouvé !</td>
                            </tr>
                        @endforelse
                    </tbody>
                    
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $stagiaires->links() }}
                </div>
            </div>

            <style>
                .showPhoto
                {
                    width: 51%;
                    height: 54px;
                    margin: auto;
                }

                .showPhoto>div
                {
                    width: 80%;
                    height: 80%;
                    border-radius: 50%;
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-position: center;
                }
            </style>
        </main>

        <!-- Vendor JS Files -->
        @include('layouts.vendorJs')

        <!-- Template Main JS File -->
        <script src="{{ asset('assets/admin/js/main.js') }}"></script>
    </body>
</html>
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
                        
                        <li class="breadcrumb-item active">Liste des tuteurs</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="container">
                <h2 class="text-center">Liste des tuteurs</h2>
                <div class="text-end mb-5">
                    <a href="{{ route('ajoutAffiche')}}" class="btn btn-primary">Ajouter</a>
                </div>
                @if(Session::has('message'))
                    <div class="alert alert-info" role="alert">{{Session::get('message')}}</div>
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

                        <th>Rôle</th>

                    </thead>
                    
                    <tbody>
                        @forelse($users as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>{{ $row->nom }}</td>

                                <td>{{ $row->prenom }}</td>

                                <td>{{ $row->email }}</td>

                                <td>
                                    <div class="showPhoto">
                                        <div id="imagePreview" style="@if($row->photo != '') background-image:url('{{ url('/') }}/uploads/{{ $row->photo }}')@else background-image: url('{{ url('/img/logo.png') }}') @endif;"></div>
                                    </div>
                                </td>

                                <td>{{ $row->role }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">Aucun enregistrement trouvé !</td>
                            </tr>
                        @endforelse
                    </tbody>
                    
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $users->links() }}
                </div>
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
                $(document).ready(function() {
                    // Lorsque l'utilisateur clique sur "Accepter"
                    $('.accept-btn').on('click', function() {
                        var index = $(this).data('index');
                        // Remplacer les boutons par "Acceptée"
                        $(this).closest('td').html('<span class="text-success">Acceptée</span>');
                    });

                    // Lorsque l'utilisateur clique sur "Refuser"
                    $('.reject-btn').on('click', function() {
                        var index = $(this).data('index');
                        // Remplacer les boutons par "Refusée"
                        $(this).closest('td').html('<span class="text-danger">Refusée</span>');
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
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
    @include('layouts.tuteurHeader')
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->
    @include('layouts.tuteurSidebar')
    <!-- End Sidebar-->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Profil</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('welcome')}}">Accueil</a>
                    </li>

                    <li class="breadcrumb-item">Tuteur</li>
                    
                    <li class="breadcrumb-item active">Profil tuteur</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            @auth
                                <img src="{{ auth()->user()->photo ? asset(auth()->user()->photo) : asset('img/logo.png') }}" alt="Profile" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">

                                <h2>{{ Auth::user()->nom }}</h2> 
                                <h3>{{ Auth::user()->role }}</h3>
                                <div class="social-links mt-2">
                                    <a href="#" class="twitter">
                                        <i class="bi bi-twitter"></i>
                                    </a>

                                    <a href="#" class="facebook">
                                        <i class="bi bi-facebook"></i>
                                    </a>

                                    <a href="#" class="instagram">
                                        <i class="bi bi-instagram"></i>
                                    </a>

                                    <a href="#" class="linkedin">
                                        <i class="bi bi-linkedin"></i>
                                    </a>
                                </div>
                            @endauth

                            
                            
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Aperçu</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Modifier le profil</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Paramètres</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Changer le mot de passe</button>
                                </li>

                            </ul>

                            <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview"> 

                                <h5 class="card-title">Détails du profil</h5>
                                @auth
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Identifiant</div>
                                        <div class="col-lg-9 col-md-8">{{ Auth::user()->id }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Nom</div>
                                        <div class="col-lg-9 col-md-8">{{ Auth::user()->nom }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Prénom</div>
                                        <div class="col-lg-9 col-md-8">{{ Auth::user()->prenom }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Rôle</div>
                                        <div class="col-lg-9 col-md-8">{{ Auth::user()->role }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Téléphone</div>
                                        <div class="col-lg-9 col-md-8">{{ Auth::user()->contact }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8">{{ Auth::user()->email }}</div>
                                    </div>
                                @endauth



                            </div>

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                    <!-- Profile Edit Form -->
                                    <form action="{{ route('profil.TuteurUpdate') }}" method="POST" enctype="multipart/form-data">

                                        @csrf
                                        @method('PUT')
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                <img src="{{ auth()->user()->photo ? asset(auth()->user()->photo) : asset('img/logo.png') }}"  alt="Profile" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                                                <div class="pt-2">
                                                    <!-- Modifier -->
                                                    <label for="profileImageInput" class="btn btn-primary btn-sm" title="Modifier le profil">
                                                        <i class="bi bi-upload"></i>
                                                    </label>

                                                    <input type="file" name="profileImage" id="profileImageInput" accept=".jpg, .jpeg, .png" class="d-none" onchange="this.form.submit()">

                                                    <!-- Supprimer -->
                                                    <button type="button" class="btn btn-danger btn-sm" title="Supprimer le profil" onclick="confirmDelete()">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nom</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="nom" type="text" class="form-control" id="fullName" value="{{ Auth::user()->nom }}" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Name" class="col-md-4 col-lg-3 col-form-label">Prénom</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="prenom" type="text" class="form-control" id="Name" value="{{ Auth::user()->prenom }}" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="contact" type="text" class="form-control" id="Phone" value="{{ Auth::user()->contact }}" required>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" class="form-control" id="Email" value="{{ Auth::user()->email }}" required>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                        </div>
                                    </form>
                                    <!-- End Profile Edit Form -->

                                    <form id="deleteProfileImageForm" action="{{ route('profil.deleteImages') }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                </div>

                                

                                <div class="tab-pane fade pt-3" id="profile-settings">

                                    <!-- Settings Form -->
                                    <form>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                                            <div class="col-md-8 col-lg-9">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="changesMade" checked>
                                                    <label class="form-check-label" for="changesMade">
                                                        Changes made to your account
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="newProducts" checked>
                                                <label class="form-check-label" for="newProducts">
                                                    Information on new products and services
                                                </label>
                                                </div>
                                                <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="proOffers">
                                                <label class="form-check-label" for="proOffers">
                                                    Marketing and promo offers
                                                </label>
                                                </div>
                                                <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                                                <label class="form-check-label" for="securityNotify">
                                                    Security alerts
                                                </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                    <!-- End settings Form -->

                                </div>

                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form action="{{ route('changementMotDePasse') }}" method="POST">

                                        @csrf
                                        @method('PUT')

                                        <div class="row mb-3">
                                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Ancien mot de passe</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="mot_de_passe" type="password" class="form-control" id="currentPassword">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nouveau mot de passe</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="nouveau_mot_de_passe" type="password" class="form-control" id="newPassword">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirmer le nouveau mot de passe</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="nouveau_mot_de_passe_confirmation" type="password" class="form-control" id="renewPassword">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
                                        </div>
                                    </form>
                                    <!-- End Change Password Form -->

                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
    <!-- End #main -->


        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        @include('layouts.vendorJs')

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/admin/js/main.js') }}"></script>

    <script>
        function confirmDelete()
        {
            if (confirm("Voulez-vous vraiment supprimer cette image ?"))
            {
                document.getElementById('deleteProfileImageForm').submit();
            }
        }
    </script>

    </body>

</html>
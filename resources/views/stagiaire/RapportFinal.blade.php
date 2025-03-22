<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=7">
        <title>Rapport final de stage</title>

        @include('layouts.favicon')
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-jQGJlDyvOszOJ1yTljP29ML6IcYY8bZROF6q8tXcCGS7keN5FV3tT1+lc6R+uj1vxtcNKuBBgN4ssm5Uq+lNCA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

        <!-- Font Icon -->
        <link rel="stylesheet" href="{{ asset('assets/fonts/material-icon/css/material-design-iconic-font.min.css') }}">

        <!-- Main css -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    </head>

    <body>

        <div class="main">

            <section class="signup">
                <div class="container">
                    <div class="signup-content">
                        <form action="{{ route('RapportFinalUpdate') }}" method="POST" id="signup-form" class="signup-form" enctype="multipart/form-data">
                        @if(Session::has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                            <h2 class="form-title">Soumettre son rapport final</h2>
                            @csrf

                            <div class="form-group mb-3">
                                <label for="theme_rapport">Thème du rapport</label>
                                <input type="text" class="form-input" name="theme_rapport" id="theme_rapport" placeholder="Ajoutez le thème" required>
                                @error('theme_rapport')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="document_rapport">Document final (en PDF)</label>
                                <input type="file" class="form-control @error('document_rapport') is-invalid @enderror" name="document_rapport" id="document_rapport" required>
                                @error('document_rapport')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="date_soumission" class="block text-gray-700 font-medium">Date de début</label>
                                <input 
                                    type="date" 
                                    id="date_soumission" 
                                    name="date_soumission" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" 
                                    readonly 
                                    required 
                                />
                                @error('document_rapport')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <br>

                            <div class="form-group">
                                <input type="submit" name="submit" id="submit" class="form-submit" value="Enregistrer"/>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

        </div>

        <!-- JS -->
        <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>

        <script>
            // Script pour définir automatiquement la date actuelle
            window.onload = function () {
                const today = new Date().toISOString().split("T")[0];
                document.getElementById("date_soumission").value = today;
            };
        </script>

    </body>
</html>
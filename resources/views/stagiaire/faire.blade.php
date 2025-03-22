<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=7">
        <title>Soumettre sa demande</title>

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
                <!-- <img src="images/signup-bg.jpg" alt=""> -->
                <div class="container">
                    <div class="signup-content">
                        <form action="{{ route('FaireDemande') }}" method="POST" id="signup-form" class="signup-form" enctype="multipart/form-data">

                            @if(Session::has('message'))
                                <div class="alert alert-info" role="alert">{{Session::get('message')}}</div>
                            @endif

                            <h2 class="form-title">Soumettre sa demande</h2> 
                            
                            @csrf
                            <div class="form-group mb-3">
                                <label for="lettre_de_demande">Lettre de demande (en PDF, DOC, DOCX)</label>
                                <input type="file" class="form-control @error('lettre_de_demande') is-invalid @enderror" name="lettre_de_demande" id="lettre_de_demande" required>
                                @error('lettre_de_demande')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="cv">CV (en PDF)</label>
                                <input type="file" class="form-control @error('cv') is-invalid @enderror" name="cv" id="cv" required>
                                @error('cv')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="date_soumission">Date de soumission</label>
                                <input type="date" class="form-control" name="date_soumission" id="date_soumission" required>
                                @error('date_soumission')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <br>

                            <div class="form-group">
                                <input type="submit" name="submit" id="submit" class="form-submit" value="Soumettre"/>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

        </div>

        <!-- JS -->
        <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
    </body>
</html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Inscription</title>

        @include('layouts.favicon')

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
                        <form action="{{ route('admin.ajout') }}" method="POST" id="signup-form" class="signup-form" enctype="multipart/form-data">
                            @if(Session::has('message'))
                                <div class="alert alert-info" role="alert">{{Session::get('message')}}</div>
                            @endif
                            <h2 class="form-title">Ajouter</h2>
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-input" name="nom" id="nom" value="{{ old('nom') }}" placeholder="Votre nom" required/>
                                @error('nom')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-input" name="prenom" id="prenom" value="{{ old('prenom') }}" placeholder="Votre prénom" required/>
                                @error('prenom')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-input" name="contact" id="contact" value="{{ old('contact') }}" placeholder="Votre contact" required/>
                                @error('contact')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-input" name="email" id="email" value="{{ old('email') }}" placeholder="Votre adresse mail" required/>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-input" name="mot_de_passe" id="mot_de_passe" placeholder="Votre mot de passe" required/>
                                <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                                @error('mot_de_passe')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="submit" name="submit" id="submit" class="form-submit" value="Envoyer"/>
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
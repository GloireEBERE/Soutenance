<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Switch Maker - Plateforme dédiée à la gestion des demandes de stage et à la connexion des étudiants avec les entreprises.">
        <meta name="author" content="Switch Maker Team">
        <meta name="theme-color" content="#007bff">
        <title>Switch Maker</title>

        @include('layouts.favicon')
        
        <!-- Font Awesome -->
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

        <!-- Le css de l'accueil -->
        <link rel="stylesheet" href="{{ asset('assets/css/welcome.css') }}">
    </head>

    <body>
        <!-- Header -->
        <header style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background-color: #f8f9fa;">
            <div style="display: flex; align-items: center;">
                <a href="{{ route('welcome') }}" style="display: flex; align-items: center; text-decoration: none; color: black;">
                    <img src="{{ asset('assets/admin/img/switch-favicon.png') }}" alt="Logo" style="width: 40px; height: 40px; margin-right: 10px;">
                    <span class="d-none d-lg-block" style="font-size: 1.5rem;" translate="no">Switch Maker</span>
                </a>
            </div>

            <nav>
                @auth
                    @if(auth()->user()->role === 'admin')
                        @include('layouts.header')
                    @elseif(auth()->user()->role === 'tuteur')
                        @include('layouts.tuteurHeader')
                    @else
                        @include('layouts.welheade')
                    @endif
                @else
                    <a class="btn btn-primary" href="{{ route('login') }}">Se connecter</a>
                    <a class="btn btn-secondary ms-2" href="{{ route('inscription.form') }}">S'inscrire</a>
                @endauth
            </nav>

        </header>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Vidéo de bienvenue -->
        <section class="video-container">
            <video autoplay muted loop>
                <source src="{{ asset('assets/admin/img/Bienvenue.mp4') }}" type="video/mp4">
            </video>
            
            <div class="video-overlay">
                <h2>Bienvenue</h2>
                @auth
                    @if(auth()->user()->role === 'stagiaire')
                        <div class="action-buttons">
                            <a href="{{ route('AfficherDemande')}}">Soumettre la demande de stage </a>
                            <a href="{{ route('stagiaire.demandes') }}">Mes demandes de stage </a>
                        </div>
                    @endif
                    
                @endauth
            </div>
        </section>

        <!-- Section Qui sommes-nous -->
        <section class="about-us">
            <h2>Qui sommes-nous ?</h2>
            <div style="display: flex; align-items: center; justify-content: center; text-align: left;">
                <img src="{{ asset('assets/admin/img/programer-switch-maker.jpg') }}" alt="Image" style="width: 40%; height: auto; margin-right: 20px;">
                <p style="max-width: 600px; font-size: 1.1rem; line-height: 1.6; color: #666;">
                    Nous sommes une entreprise proposant des services d'Externalisation IT et de développement Offshore sur mesure pour les entreprises.
                    <br>
                    Nous sommes une entreprise de développement technologique et de marketing numérique présente sur sept (7) pays et sur deux (2) continents et avec plus de dix ans d'expérience.
                    <br>
                    Notre mission est d'offrir le stage aux étudiants désireux d'apprendre davantage dans le domaine informatique.
                </p>
            </div>
        </section>

        <!-- FAQ - Processus de dépôt de stage -->
        <section class="faq">
            <h2>FAQ - Processus de dépôt de stage</h2>
            <div class="faq-item">
                <h3>Comment soumettre une demande de stage ?</h3>
                <p>Pour soumettre une demande, vous devez vous inscrire sur notre plateforme, remplir le formulaire de candidature.</p>
            </div>

            <div class="faq-item">
                <h3>Quels documents sont nécessaires pour la candidature ?</h3>
                <p>Vous devez soumettre un CV à jour et une lettre de motivation expliquant votre intérêt pour le stage.</p>
            </div>

            <div class="faq-item">
                <h3>Quel est le délai de traitement des demandes ?</h3>
                <p>
                    Les demandes sont généralement traitées sous 2 semaines. Vous recevrez une notification par email concernant le statut de votre demande.
                    <br>
                    Ou encore, vous pouvez consulter votre profil sur la plateforme pour savoir l'état de votre demande de stage.
                </p>
            </div>

            <div class="faq-item">
                <h3>Comment savoir si ma demande a été acceptée ?</h3>
                <p>
                    Vous recevrez une notification par email.
                    <br>
                    Mieux encore, vous pouvez consulter votre profil.</p>
            </div>
        </section>

        <!-- Section Newsletter -->
        <section class="newsletter" style="background-color: #f8f9fa; padding: 2rem; text-align: center; margin-top: 2rem;">
            <h2 style="margin-bottom: 1rem;">Restez informé avec notre Newsletter</h2>
            <p style="margin-bottom: 1.5rem; font-size: 1.1rem; color: #666;">
                Inscrivez-vous pour recevoir les dernières nouvelles et opportunités de stage chez Switch Maker.
            </p>
            <form action="{{ route('newsletter.subscribe') }}" method="POST" style="max-width: 600px; margin: 0 auto;">
                @csrf
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="Entrez votre adresse e-mail" 
                        required 
                        style="flex: 1; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px;"
                    >
                    <button 
                        type="submit" 
                        style="padding: 0.5rem 1.5rem; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;"
                    >
                        S'inscrire
                    </button>
                </div>
                @if(session('newsletter_success'))
                    <p style="margin-top: 1rem; color: green;">{{ session('newsletter_success') }}</p>
                @endif
                
                @if(session('newsletter_error'))
                    <p style="margin-top: 1rem; color: red;">{{ session('newsletter_error') }}</p>
                @endif
            </form>
        </section>

        <!-- Footer -->
        @include('layouts.footer')


        <!-- Vendor JS Files -->
        @include('layouts.vendorJs')

        <!-- Template Main JS File -->
        <script src="{{ asset('assets/admin/js/main.js') }}"></script>
    </body>
</html>

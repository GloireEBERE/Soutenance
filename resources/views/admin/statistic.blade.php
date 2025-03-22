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
                        
                        <li class="breadcrumb-item active">Les statistiques</li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->

            <div class="table-responsive">
                <!-- Reports -->
                    <div class="col-12">
                        <div class="card">

                            <div class="filter">
                                <a class="icon" href="{{ route('dashboard')}}" data-bs-toggle="dropdown">
                                    <i class="bi bi-bar-chart-line-fill"></i>
                                </a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Nombre de stagiaire dont le stage a été accordé.</span></h5>

                                <!-- Chart.js canvas -->
                                <canvas id="reportsChart"></canvas>
                                <div id="noDataMessage" style="display: none;">Aucune donnée disponible pour le moment.</div>
                                

                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        try {
                                            var chartData = JSON.parse('{!! $chartDataJson !!}');
                                            console.log('Données reçues dans le JavaScript:', chartData);

                                            // Si aucune donnée, afficher un message
                                            if (!chartData || chartData.length === 0) {
                                                document.getElementById('noDataMessage').style.display = 'block';
                                                return;
                                            }

                                            // Récupérer les mois et années pour les labels
                                            var labels = chartData.map(item => item.year + '-' + item.month);

                                            // Récupérer le nombre de stagiaires acceptés
                                            var data = chartData.map(item => item.count);

                                            new Chart(document.getElementById('reportsChart'), {
                                                type: 'line', // Utilisation du type 'line' pour une courbe
                                                data: {
                                                    labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12], // Les mois de l'année numérotés de 1 à 12
                                                    datasets: [{
                                                        label: 'Stagiaires acceptés', // Légende du graphique
                                                        data: (function() {
                                                            // Remplir les données avec les mois manquants
                                                            const monthsData = Array(12).fill(0); // Créer un tableau de 12 éléments avec 0

                                                            chartData.forEach(item => {
                                                                const monthIndex = parseInt(item.month, 10) - 1; // Convertir le mois en index (Janvier = 0, Février = 1, ...)
                                                                monthsData[monthIndex] = item.count; // Remplir le nombre de stagiaires dans le bon mois
                                                            });

                                                            return monthsData;
                                                        })(),
                                                        borderColor: 'rgba(75, 192, 192, 1)', // Couleur de la ligne
                                                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Couleur de fond (transparent sous la ligne)
                                                        fill: false, // Pas de remplissage sous la courbe
                                                        tension: 0.1, // Légèrement lissé
                                                        pointRadius: 5, // Taille des points
                                                        pointBackgroundColor: 'rgba(75, 192, 192, 1)', // Couleur des points
                                                        pointBorderColor: '#fff', // Couleur de la bordure des points
                                                        pointBorderWidth: 2, // Bordure des points
                                                    }]
                                                },
                                                options: {
                                                    responsive: true,
                                                    plugins: {
                                                        tooltip: {
                                                            callbacks: {
                                                                label: function (tooltipItem) {
                                                                    return tooltipItem.raw + ' stagiaires'; // Affiche le nombre de stagiaires dans le tooltip
                                                                }
                                                            }
                                                        }
                                                    },
                                                    scales: {
                                                        x: {
                                                            title: {
                                                                display: true,
                                                                text: 'Mois',  // Titre de l'axe X
                                                                font: {
                                                                    size: 14,
                                                                    weight: 'bold',
                                                                }
                                                            },
                                                            type: 'category', // Utilisation des catégories (mois)
                                                            labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'], // Noms des mois
                                                        },
                                                        y: {
                                                            title: {
                                                                display: true,
                                                                text: 'Nombre de stagiaires',  // Titre de l'axe Y
                                                                font: {
                                                                    size: 14,
                                                                    weight: 'bold',
                                                                }
                                                            },
                                                            beginAtZero: true,  // L'axe Y commence à zéro
                                                            ticks: {
                                                                stepSize: 1, // Assurer que l'axe Y affiche des entiers
                                                                callback: function(value) {
                                                                    return value % 1 === 0 ? value : ''; // Afficher uniquement des valeurs entières
                                                                }
                                                            }
                                                        }
                                                    },
                                                    elements: {
                                                        point: {
                                                            radius: 5,  // Taille des points
                                                            hoverRadius: 7,  // Taille des points lors du survol
                                                            borderWidth: 2  // Largeur des bordures des points
                                                        }
                                                    },
                                                    layout: {
                                                        padding: {
                                                            left: 10,
                                                            right: 10,
                                                            top: 10,
                                                            bottom: 10
                                                        }
                                                    },
                                                    interaction: {
                                                        mode: 'nearest',  // Mode d'interaction pour afficher les tooltips les plus proches
                                                        intersect: false  // Permet d'afficher les tooltips même si on survole une zone sans point
                                                    },
                                                    tension: 0.4  // Pour lissage de la ligne
                                                }
                                            });
                                        } catch (error) {
                                            console.error("Erreur lors du rendu du graphique :", error);
                                            document.getElementById('noDataMessage').style.display = 'block';
                                        }
                                    });

                                </script>

                                <!-- End Line Chart -->

                            </div>

                        </div>
                    </div>
                <!-- End Reports -->
            </div>
        </main>

        <!-- Vendor JS Files -->
        @include('layouts.vendorJs')

        <!-- Template Main JS File -->
        <script src="{{ asset('assets/admin/js/main.js') }}"></script>
    </body>
</html>
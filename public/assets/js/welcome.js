document.getElementById('username').addEventListener('click', function() {
    // Trouve le conteneur du bouton de déconnexion
    var logoutContainer = document.getElementById('logout-container');

    // Alterne l'affichage du conteneur de déconnexion
    if (logoutContainer.style.display === 'none') {
        logoutContainer.style.display = 'block'; // Affiche le bouton
    } else {
        logoutContainer.style.display = 'none'; // Cache le bouton
    }
});
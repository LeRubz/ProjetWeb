const searchSection = document.querySelector('.search-section');
const header = document.querySelector('header');

window.addEventListener('scroll', () => {
    const searchBottom = searchSection.getBoundingClientRect().bottom;

    if (searchBottom <= 0) {
        header.classList.add('show-search-icon');
    } else {
        header.classList.remove('show-search-icon');
    }
});



document.addEventListener("DOMContentLoaded", () => {
    const loupe = document.querySelector('.search-icon-navbar');
    const floatingSearch = document.getElementById('floatingSearchBar');
    const searchSection = document.querySelector('.search-section');
    const header = document.querySelector('header');

    // Clic sur la loupe
    loupe.addEventListener('click', () => {
        floatingSearch.style.display = 'flex';
    });

    // Fermeture auto si on remonte au niveau de la search-section
    window.addEventListener('scroll', () => {
        const searchTop = searchSection.getBoundingClientRect().top;

        // Si search bar visible à nouveau → cacher celle du haut
        if (searchTop >= 0) {
            floatingSearch.style.display = 'none';
        }
    });
});



document.addEventListener("DOMContentLoaded", () => {
    const btnPresentation = document.getElementById("tab-presentation");
    const btnOffres = document.getElementById("tab-offres");

    const sectionPresentation = document.getElementById("onglet-presentation");
    const sectionOffres = document.getElementById("onglet-offres");

    btnPresentation.addEventListener("click", () => {
        sectionPresentation.classList.replace("onglet-cache", "onglet-actif");
        sectionOffres.classList.replace("onglet-actif", "onglet-cache");
        btnPresentation.classList.add("actif");
        btnOffres.classList.remove("actif");
    });

    btnOffres.addEventListener("click", () => {
        sectionOffres.classList.replace("onglet-cache", "onglet-actif");
        sectionPresentation.classList.replace("onglet-actif", "onglet-cache");
        btnOffres.classList.add("actif");
        btnPresentation.classList.remove("actif");
    });
});



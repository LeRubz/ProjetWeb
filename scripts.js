function openModal(modalId) {
    document.getElementById(modalId).style.display = "flex";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

window.onclick = function(event) {
    if (event.target.className === "modal") {
        event.target.style.display = "none";
    }
}




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
    const loupes = document.querySelectorAll('.search-icon-navbar');
    const floatingSearch = document.getElementById('floatingSearchBar');
    const searchSection = document.querySelector('.search-section');

    // Clic sur n’importe quelle loupe (desktop ou mobile)
    loupes.forEach(loupe => {
        loupe.addEventListener('click', () => {
            floatingSearch.style.display = 'flex';
        });
    });

    // Fermer la barre flottante si on remonte
    window.addEventListener('scroll', () => {
        const searchTop = searchSection.getBoundingClientRect().top;
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

document.addEventListener("DOMContentLoaded", () => {
    const faqItems = document.querySelectorAll(".faq-item");
  
    faqItems.forEach(item => {
      const question = item.querySelector(".faq-question");
  
      question.addEventListener("click", () => {
        item.classList.toggle("active");
      });
    });
  });
  
 const underline = document.getElementById("nav-underline");
        const links = document.querySelectorAll("#nav-links a");

        function moveUnderline(el) {
            const rect = el.getBoundingClientRect();
            const headerRect = document.getElementById("header").getBoundingClientRect();
            underline.style.width = `${rect.width}px`;
            underline.style.left = `${rect.left + window.scrollX}px`;
            underline.style.top = `${headerRect.bottom + window.scrollY}px`;
        }

        links.forEach(link => {
            link.addEventListener("click", e => {
                e.preventDefault();
                links.forEach(l => l.classList.remove("active"));
                link.classList.add("active");
                moveUnderline(link);
            });
        });

        window.addEventListener("load", () => {
            const activeLink = document.querySelector("#nav-links a.active");
            if (activeLink) moveUnderline(activeLink);
        });

        window.addEventListener("resize", () => {
            const activeLink = document.querySelector("#nav-links a.active");
            if (activeLink) moveUnderline(activeLink);
        });

        document.addEventListener("DOMContentLoaded", function () {
            const burger = document.getElementById("burgerMenu");
            const mobileNav = document.getElementById("mobileNav");
        
            burger.addEventListener("click", () => {
                mobileNav.classList.toggle("open");
            });
        
            // Fermer le menu si on clique sur un lien
            mobileNav.querySelectorAll("a").forEach(link => {
                link.addEventListener("click", () => {
                    mobileNav.classList.remove("open");
                });
            });
        });
        

document.addEventListener('DOMContentLoaded', function () {
    const section = document.getElementById('realisations');
    const fadeText = section.querySelector('.fade-text');
    const fadeBg = section.querySelector('.fade-bg');

    // Vérification de l'existence des éléments
    console.log('fadeText:', fadeText);
    console.log('fadeBg:', fadeBg);
    
    // Si fadeBg est null, ne pas continuer l'animation
    if (!fadeBg) {
        console.error("L'élément .fade-bg n'a pas été trouvé !");
        return; // Stoppe l'exécution si fadeBg n'existe pas
    }

    // Intersection Observer pour déclencher l'animation au scroll
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // L'élément est dans la vue, ajout des classes pour l'animation
                console.log('Section dans la vue:', entry);
                
                fadeBg.classList.add('show-bg');
                console.log('Image de fond visible');
                
                // Ajoute un délai avant de faire apparaître le texte
                setTimeout(() => {
                    fadeText.classList.add('delayed');
                    console.log('Texte visible après délai');
                }, 2000); // Change le délai ici si nécessaire
            } else {
                // L'élément est sorti de la vue, retirer les classes d'animation
                fadeBg.classList.remove('show-bg');
                fadeText.classList.remove('delayed');
                console.log('Section hors de la vue, animations réinitialisées');
            }
        });
    }, { threshold: 0.5 }); // Le seuil à 50% pour être dans la vue

    // Observer l'élément de la section
    observer.observe(section);
});
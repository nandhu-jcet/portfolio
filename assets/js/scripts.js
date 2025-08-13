// Initialize tsParticles
particlesJS.load('particles-js', 'assets/js/particles-config.json');

// GSAP Animations
gsap.from("#hero h1", { duration: 1, y: -50, opacity: 0 });
gsap.from("#hero p", { duration: 1.2, y: 50, opacity: 0 });


// Filter Projects
const filterButtons = document.querySelectorAll('.filter-btn');
const projectCards = document.querySelectorAll('.project-card');

filterButtons.forEach((button) => {
    button.addEventListener('click', () => {
        const filter = button.dataset.filter;
        projectCards.forEach((card) => {
            if (filter === 'all' || card.dataset.category === filter) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});


// Skill Tabs
const skillTabs = document.querySelectorAll('.skill-tab');
const skillCards = document.querySelectorAll('.skill-card');

skillTabs.forEach((tab) => {
    tab.addEventListener('click', () => {
        const activeTab = tab.dataset.tab;
        skillCards.forEach((card) => {
            if (card.dataset.tab === activeTab) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});



// Mobile menu toggle
const menuToggle = document.getElementById('menu-toggle');
const mobileMenu = document.getElementById('mobile-menu');

menuToggle.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
});

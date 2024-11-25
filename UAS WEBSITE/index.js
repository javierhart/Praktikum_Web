
const dropdown = document.querySelector('.dropdown');

const card = document.querySelector('.harry .card img');

const menuToggle = document.getElementById('mobile-menu');
const navLinks = document.querySelector('.nav-links');

menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');
});

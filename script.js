// console.log("globale javascript bestand is goed gekoppeld!");

// De navbar toggle
const toggleBtn = document.getElementById('navToggle');
const navContent = document.getElementById('navContent');

toggleBtn.addEventListener('click', () => {
    navContent.classList.toggle('active');
});

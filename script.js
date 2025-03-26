// console.log("globale javascript bestand is goed gekoppeld!");
function toggle_menu(id, style, arrow_id) {
    // console.log(id);
    const e = document.getElementById(id);
    const displayValue = window.getComputedStyle(e).display;

    e.style.display = (displayValue === "none") ? style : "none";

    if (arrow_id !== undefined) {toggle_arrow_icon(arrow_id)}
}

function toggle_arrow_icon(id) {
    const e = document.getElementById(id);
    e.classList.toggle("bi-arrow-down-short");
    e.classList.toggle("bi-arrow-up-short");
}


// Selecteer het formulier met de class 'kaarten_filter'
const form = document.querySelector('.kaarten_filter');
const selectElements = form.querySelectorAll('select');

// Voeg een event listener toe voor elke select element
selectElements.forEach(select => {
    select.addEventListener('change', function() {
        console.log(select.value);
        
        const url = window.location.href;

        // window.open(url + ``, '_self');
    });
});
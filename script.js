// console.log("globale javascript bestand is goed gekoppeld!");

// Globale functie
function toggle_menu(id, style, arrow_id) {
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

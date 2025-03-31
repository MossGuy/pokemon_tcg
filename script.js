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

// De afbeeldingen naar tabel toggle
const img_to_table = document.getElementById("view_as");
img_to_table.addEventListener("change", () => {
    const img = document.getElementsByClassName("image_section")[0];
    const table = document.getElementsByClassName("table_section")[0];
    
    const viewAsValue = img_to_table.value;
    if (viewAsValue === "list") {
        img.style.display = "none";
        table.style.display = "block";
    } else {
        img.style.display = "flex";
        table.style.display = "none";
    }
});


// De oplopend / aflopend toggle
const order_by = document.getElementById("order");
order_by.addEventListener("change", () => {
    updateURL();
});

// WORK IN PROGRESS
function updateURL() {
    // Verkrijg de geselecteerde waarden
    const sortBy = document.getElementById('sort_by').value ?? '';  // De waarde van sort_by, leeg als niet beschikbaar
    const order = document.getElementById('order').value ?? '';  // De waarde van order, leeg als niet beschikbaar

    // Maak een nieuw URLSearchParams-object met de huidige zoekparameters
    const urlParams = new URLSearchParams(window.location.search);

    // Haal de huidige waarden op uit de URL
    const currentSortBy = urlParams.get('sort_by') ?? '';
    const currentOrder = urlParams.get('order') ?? '';

    // Voeg de waarden toe, maar alleen als ze veranderd zijn ten opzichte van de huidige waarden
    if (sortBy && sortBy !== currentSortBy) {
        urlParams.set('sort_by', sortBy);
    } else if (!sortBy) {
        urlParams.delete('sort_by');  // Verwijder de parameter als deze leeg is
    }

    if (order && order !== currentOrder) {
        urlParams.set('order', order);
    } else if (!order) {
        urlParams.delete('order');  // Verwijder de parameter als deze leeg is
    }

    // Werk de URL bij zonder de pagina opnieuw te laden
    const updatedURL = '?' + urlParams.toString();

    // Werk de browser-geschiedenis bij met de nieuwe URL
    window.history.replaceState(null, '', updatedURL);

    // Optioneel: log de nieuwe URL naar de console voor debugging
    console.log("Updated URL: " + window.location.origin + updatedURL);
}
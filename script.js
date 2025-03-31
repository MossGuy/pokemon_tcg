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


const img_to_table = document.getElementById("view_as");

img_to_table.addEventListener("change", () => {
    const img = document.getElementsByClassName("image_section")[0];
    const table = document.getElementsByClassName("card_table")[0];
    
    // Verkrijg de waarde van het geselecteerde item in img_to_table
    const viewAsValue = img_to_table.value;
    
    if (viewAsValue === "list") {
        img.style.display = "none";
        table.style.display = "table";
        console.log(table);
    } else {
        img.style.display = "flex";
        table.style.display = "none";
    }
});




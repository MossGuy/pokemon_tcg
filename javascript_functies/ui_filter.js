// console.log("De ui_filter is goed gekoppeld!");

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


const order = document.getElementById("orderBy");
order.addEventListener("change", () => {
    updateURL(order.id, order.value);
});

const sort_by = document.getElementById("sortBy");
sort_by.addEventListener("change", () => {
    updateURL(sort_by.id, sort_by.value);
});


function updateURL(paramName, value) {
    const urlParams = new URLSearchParams(window.location.search);
    const currentParamValue = urlParams.get(paramName) ?? '';

    if (value && value !== currentParamValue) {
        urlParams.set(paramName, value);
    } else if (!value) {
        urlParams.delete(paramName);
    }

    const updatedURL = '?' + urlParams.toString();
    window.history.replaceState(null, '', updatedURL);
}

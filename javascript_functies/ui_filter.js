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

// De parameters updaten
const order = document.getElementById("orderBy");
order.addEventListener("change", () => {
    updateURL(order.id, order.value);
});

const sort = document.getElementById("sortBy");
sort.addEventListener("change", () => {
    updateURL(sort.id, sort.value);
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
    window.location.reload();
}

// select elementen updaten met de actieve url parameters
function update_selects() {
    const urlParams = new URLSearchParams(window.location.search);
    const orderBy = urlParams.get("orderBy");
    const sortBy = urlParams.get("sortBy");

    if (orderBy !== null) {
        order.value = orderBy;
    }
    
    if (sortBy !== null) {
        sort.value = sortBy;
    }
}
window.onload = update_selects();

// De pagina switch buttons
function page_switch(page, action, query) {
    const orderBy = document.getElementById("orderBy").value;
    const sortBy = document.getElementById("sortBy").value;

    if (action === 'next') {
        page++;  // Volgende pagina
    } else if (action === 'prev') {
        page--;  // Vorige pagina
    } else if (typeof action === 'number') {
        page = action;  // Specifieke pagina
    }

    const url = `kaarten_zoeken.php?query=${query}&page=${page}&orderBy=${orderBy}&sortBy=${sortBy}`;

    window.location.href = url;
}

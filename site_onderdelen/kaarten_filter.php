<div class="kaarten_filter flex_row i_center">
    <label for="view_as">Bekijk als: </label>
    <select name="view_as" id="view_as">
        <option value="images">Afbeeldingen</option>
        <option value="list">Lijst</option>
    </select>

    <label for="sort_by">Gesorteerd op: </label>
    <select name="sort_by" id="sort_by">
        <option value="number">Set/Nummer</option>
        <option value="name">Naam</option>
        <option value="rarity">Zeldzaamheid</option>
        <option value="releaseDate">Releasedatum</option>
    </select>
    <select name="order" id="order">
        <option value="asc">Oplopend</option>
        <option value="desc">Aflopend</option>
    </select>
</div>
<script src="./javascript_functies/ui_filter.js" defer></script>
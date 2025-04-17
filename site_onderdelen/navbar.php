<?php
if (isset($_POST['card_query'])) {
    $q = $_POST['card_query'];
    header("Location: ./kaarten_zoeken.php?query=$q");
}
define("value", $_GET['query'] ?? "");
?>

<nav>
    <div class="container flex_row">
        <div class="nav_head flex_row i_between">
            <!-- Logo -->
            <a class="flex_row i_center logo" href="./index.php">
                <img class="nav_icon" src="./images/icons/icon_1.png" alt="">
                <strong>Pokemon TCG bibliotheek</strong>
            </a>

            <!-- Toggle button (verborgen tot media query) -->
            <button class="nav_toggle" id="navToggle" aria-label="Toon menu">
                ☰
            </button>
        </div>

        <!-- Nieuwe wrapper: zoekbalk + navigatielinks -->
        <div class="nav_content w_100" id="navContent">
            <form action="" method="POST" class="<?=$navbar_include ?? ""?>">
                <input id="card_query" name="card_query" type="text" placeholder="Zoek een kaart" value="<?=value?>">
            </form>

            <div class="links flex_row">
                <a href="./sets.php">Sets</a>
                <a href="./api_debug.php">API Debug</a>
            </div>
        </div>
    </div>
</nav>

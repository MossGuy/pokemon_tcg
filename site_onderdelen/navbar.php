<?php
if (isset($_POST['card_query'])) {
    $q = $_POST['card_query'];
    header("Location: ./kaarten_zoeken.php?query=$q");
}
define("value", $_GET['query'] ?? "");
?>

<nav>
    <div class="container flex_row">
        <a class="flex_row i_center" href="./index.php">
            <img class="nav_icon" src="./images/icons/icon_1.png" alt="">
            <strong>Pokemon TCG bibliotheek</strong>
        </a>
        <form action="" method="POST" class="<?=$navbar_include ??""?>">
            <input id="card_query" name="card_query" type="text" placeholder="Zoek een kaart" value="<?=value?>">
        </form>
        <div class="links flex_row">
            <a href="./zoek_formulier.php">Geavanceerd zoeken</a>
            <a href="./syntax.php">Syntax</a>
            <a href="./sets.php">Sets</a>
            <a href="./api_debug.php">API Debug</a>
        </div>
    </div>
</nav>
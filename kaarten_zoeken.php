<?php
include "./api_key.php";
include "./php_functies/array_to_images.php";

$query = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_STRING);
$query = trim($query);

if (empty($query) || strlen($query) > 100) {
    die("Ongeldige zoekopdracht.");
}

$query = urlencode($query);
$current_page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?? 0;
$page_size = 24;
$validSortOptions = ['number', 'name', 'rarity', 'releaseDate'];
$sort = filter_input(INPUT_GET, 'sortBy', FILTER_SANITIZE_STRING) ?? 'number';

if (!in_array($sort, $validSortOptions)) {
    $sort = 'number';
}

$order = $_GET['orderBy']??'asc';

if ($sort == "releaseDate") {
    $sort = "set.releaseDate";
}

if ($order == "desc") {
    $sort = "-" . $sort;
}

$orderBy = filter_input(INPUT_GET, 'orderBy', FILTER_SANITIZE_STRING) ?? 'asc';
$orderBy = ($orderBy === 'desc') ? "-{$sort}" : $sort;

define("API_BASE_URL", "https://api.pokemontcg.io/v2/cards");

$url = API_BASE_URL . "?q=name:$query&orderBy=$sort" . KEY . "&pageSize=$page_size&page=$current_page";
$response = @file_get_contents($url);

if ($response === FALSE) {
    die('Fout: Kan geen gegevens ophalen van de API.');
}

$data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die('Fout: Kan JSON niet decoderen.');
}

$total_cards = $data['totalCount'] ?? 0;
$total_pages = ceil($total_cards / $page_size);
$has_prev_page = $current_page > 1;
$has_next_page = $current_page < $total_pages;

$dataCount = count($data['data'] ?? []);
$not_found_div = ($dataCount == 0) ? "" : "unavailable";
$found_div = ($dataCount > 0) ? "" : "unavailable";

echo '<pre>'; 
// print_r($_GET);
echo '</pre>';

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./stylesheets/style.css">
    <link rel="stylesheet" href="./stylesheets/kaarten.css">
    <script src="./script.js" defer></script>
    
    <title>Pokémon tcg api</title>
</head>
<body>
    <?php include "./site_onderdelen/navbar.php"?>
    <main class="container w_100">
        <section>
            <?php include "./site_onderdelen/kaarten_filter.php"; ?>
        </section>

        <section class="image_section <?=$found_div?>">
            <?php
            for ($i = 0; $i < $dataCount; $i++) {
                $id = $data['data'][$i]['id'];
                $name = $data['data'][$i]['name'];
                $image = $data['data'][$i]['images']['small'];

                echo "
                <a class='kaart' href='./kaart.php?id=$id'>
                    <img src='$image' alt='$name'>
                </a>
                " . PHP_EOL;
            }
            ?>
        </section>

        <!-- tabel -->
        <section class="table_section">
            <table class="card_table w_100">
                <thead>
                    <tr>
                        <th>Set</th>
                        <th class="number">Nummer</th>
                        <th>Naam</th>
                        <th>Zeldzaamheid</th>
                        <th>Types</th>
                        <th>Supertype</th>
                        <th>Subtypes</th>
                        <th>Prijs</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < $dataCount; $i++) {
                        $id = $data['data'][$i]['id'];
                        $rarity = $data['data'][$i]['rarity']??'-';
                        $types = implode(PHP_EOL, array_to_images($data['data'][$i]['types']??[]));
                        $supertypes = $data['data'][$i]['supertype']??'-';
                        $subtypes = implode(", ", $data['data'][$i]['subtypes']??[]);
                        $sellPrice = $data['data'][$i]['cardmarket']['prices']['averageSellPrice']??'';
                        $item_onclick = 'javascript:location.href="./kaart.php?id=' . $id . '";';
                        echo "
                        <tr class='tr_hover' onclick='{$item_onclick}'>
                            <td>{$data['data'][$i]['set']['name']}</td>
                            <td>{$data['data'][$i]['number']}</td>
                            <td>{$data['data'][$i]['name']}</td>
                            <td>$rarity</td>
                            <td>$types</td>
                            <td>$supertypes</td>
                            <td>$subtypes</td>
                            <td>$sellPrice</td>
                        </tr>
                        ";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <!-- button sectie -->
        <section>
        <div class="w_100 flex_row gap5 j_center wrap">
                <!-- Vorige knop -->
                <button 
                <?= !$has_prev_page ? 'disabled' : '' ?>
                onclick="page_switch(<?=$current_page?>, 'prev', '<?=$query?>')">
                Vorige
                </button>

                <!-- Numerieke Pagina-knoppen - door chatgpt :D -->
                <?php

                // Definieer het bereik van pagina's dat zichtbaar moet zijn
                $range = 6; // Hoeveel pagina's rondom de huidige pagina je wilt tonen
                $start = max(1, $current_page - $range); // Begin van het bereik
                $end = min($total_pages, $current_page + $range); // Eind van het bereik

                // Maak de pagina-nummers dynamisch
                if ($has_next_page || $has_prev_page) {
                    for ($i = $start; $i <= $end; $i++) {
                        echo "<button " . ($i == $current_page ? "class='active hover-style'" : "class='hover-style'") . " onclick=\"page_switch($current_page, $i, '$query')\">$i</button>";
                    }
                }
                ?>

                <!-- Volgende knop -->
                <button 
                <?= !$has_next_page ? 'disabled' : '' ?>
                onclick="page_switch(<?=$current_page?>, 'next', '<?=$query?>')">
                Volgende
                </button>
            </div>
        </section>

        <section class="t_center <?=$not_found_div?>">
            <img src="./images/confused.png" alt="">
            <h1>Hmmmmm... wij konden niks vinden met uw zoekcriteria</h1>
        </section>
    </main>
    <?php include "./site_onderdelen/footer.php"?>
</body>
</html>
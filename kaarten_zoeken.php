<?php
require_once "./api_key.php";
require_once "./php_functies/array_to_images.php";

// De gebruikers input ophalen en valideren
$query = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_STRING);
if (empty($query) || strlen($query) > 60) {
    die("Ongeldige zoekopdracht.");
}

$query = htmlspecialchars($query, ENT_QUOTES, 'UTF-8');
$query = trim($query);
$query = urlencode($query);

// Sorteer en pagina nummer variabelen aanroepen en bewerken
$current_page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?? 1;
$page_size = 24;
$validSortOptions = ['number', 'name', 'rarity', 'releaseDate'];
$sort = filter_input(INPUT_GET, 'sortBy', FILTER_SANITIZE_STRING) ?? 'number';
$order = $_GET['orderBy']??'asc';

if (!in_array($sort, $validSortOptions)) {
    $sort = 'number';
}
if ($sort == "releaseDate") {
    $sort = "set.releaseDate";
}
if ($order == "desc") {
    $sort = "-" . $sort;
}

// De api url maken, aanroepen en valideren
$api_base_url = "https://api.pokemontcg.io/v2/cards";
$url ="$api_base_url?q=name:$query&orderBy=$sort" . KEY . "&pageSize=$page_size&page=$current_page";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
if (curl_errno($ch)) {
    die('Fout: Kan geen gegevens ophalen van de API, probeer het nog een keer.');
}
curl_close($ch);

$data = json_decode($response, true);
$totalCount = count($data['data']??[]);

$total_cards = $data['totalCount'] ?? 0;
$total_pages = ceil($total_cards / $page_size);
$has_prev_page = $current_page > 1;
$has_next_page = $current_page < $total_pages;

$dataCount = count($data['data'] ?? []);
$not_found_div = ($dataCount == 0) ? "" : "unavailable";
$found_div = ($dataCount > 0) ? "" : "unavailable";

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./stylesheets/style.css">
    <link rel="stylesheet" href="./stylesheets/kaarten.css">
    <script src="./script.js" defer></script>
    
    <title>Pokémon TCG - Zoekresultaten</title>
</head>
<body>
    <?php include "./site_onderdelen/navbar.php"?>
    <main class="container w_100">
        <section>
            <?php include "./site_onderdelen/sorteer_ui.php"; ?>
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
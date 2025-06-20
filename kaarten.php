<?php
if (!file_exists('api_key.php')) { copy('api_key.example.php', 'api_key.php');}
require_once "./api_key.php";
require_once "./php_functies/array_to_images.php";
require_once "./php_functies/api_check.php";

// Set id validatie
if (isset($_GET['id'])) {
    define("SET_ID", $_GET['id']);
} else {
    die("Geen id meegegeven");
}

// Sorteer variabelen aanroepen en bewerken
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
$url = "$api_base_url?q=set.id:" . SET_ID . "&orderBy=$sort" . KEY;
// define("URL", "./test_json_bestanden/pokemon_cardset.json");

$result = fetch_from_api($url);
if (!$result['success']) {
    die("Fout bij ophalen van API-data: " . $result['error'] . PHP_EOL . "Ververs de pagina om het nog een keer te proberen.");
}

$data = $result['data'];
$totalCount = count($data['data'] ?? []);

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon links -->
    <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
    <link rel="manifest" href="./favicon/site.webmanifest">

    <link rel="stylesheet" href="./stylesheets/style.css">
    <link rel="stylesheet" href="./stylesheets/kaarten.css">
    <script src="./script.js" defer></script>
    
    <title>Pokémon tcg api</title>
</head>
<body>
    <?php include "./site_onderdelen/navbar.php"?>
    <main class="container w_100">
        <section>
            <h1 class="set_title"><?=SET_ID?></h1>
            <?php include "./site_onderdelen/sorteer_ui.php"; ?>
        </section>

        <!-- afbeeldingen -->
        <section class="image_section">
            <?php
            for ($i = 0; $i < $totalCount; $i++) {
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
            <table class="card_table center">
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
                    for ($i = 0; $i < $totalCount; $i++) {
                        $id = $data['data'][$i]['id'];
                        $rarity = $data['data'][$i]['rarity']??'-';
                        $types = implode(PHP_EOL, array_to_images($data['data'][$i]['types']??[]));
                        $supertypes = $data['data'][$i]['supertype']??'-';
                        $subtypes = implode(", ", $data['data'][$i]['subtypes']??['-']);
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
            </table>
        </section>
    </main>
    <?php include "./site_onderdelen/footer.php"?>
</body>
</html>
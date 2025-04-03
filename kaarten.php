<?php
include "./api_key.php";
include "./php_functies/array_to_images.php";

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

$response = file_get_contents($url);
if ($response === FALSE) {
    die('Fout: Kan geen gegevens ophalen van de API, probeer het nog een keer.');
}
$data = json_decode($response, true);
$totalCount = count($data['data']);

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
            <h1 class="set_title"><?=SET_ID?></h1>
            <?php include "./site_onderdelen/kaarten_filter.php"; ?>
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
        <section class="table_section w_100">
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
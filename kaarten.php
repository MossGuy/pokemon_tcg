<?php
include "./api_key.php";
include "./php_functies/array_to_images.php";

if (isset($_GET['id'])) {
    define("SET_ID", $_GET['id']);
}

// define("URL", "https://api.pokemontcg.io/v2/cards?q=set.id:" . SET_ID . KEY);
define("URL", "./test_json_bestanden/pokemon_cardset.json");

$response = file_get_contents(URL);
$data = json_decode($response, true);
$totalCount = count($data['data']);

function extract_numeric_id($card) {
    $id = $card['id'];

    // Zoek een combinatie van letters en cijfers (bijv. "TG11", "sv8-75a", "75a")
    preg_match('/([a-zA-Z]*)(\d+)([a-zA-Z]*)$/', $id, $matches);

    // Haal de delen op
    $prefix   = $matches[1] ?? '';  // Voorloopletters (bijv. "TG" in "TG11")
    $numeric  = (int)($matches[2] ?? 0);  // Het numerieke deel (bijv. "11" in "TG11")
    $suffix   = $matches[3] ?? '';  // Achtervoegsel (bijv. "a" in "75a")

    return [$prefix, $numeric, $suffix];
}

// Sorteer de kaarten correct
try {
    usort($data['data'], function($a, $b) {
        [$prefix_a, $num_a, $suffix_a] = extract_numeric_id($a);
        [$prefix_b, $num_b, $suffix_b] = extract_numeric_id($b);

        // Vergelijk eerst op prefix (bijv. "TG" < "sv8")
        if ($prefix_a !== $prefix_b) {
            return strcmp($prefix_a, $prefix_b);
        }

        // Vergelijk dan op het numerieke gedeelte
        if ($num_a !== $num_b) {
            return $num_a - $num_b;
        }

        // Vergelijk als laatste op het achtervoegsel (bijv. "75a" < "75b")
        return strcmp($suffix_a, $suffix_b);
    });
} catch (Exception $e) {}




echo '<pre>'; 
// print_r($data['data'][1]);
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
                        $rarity = $data['data'][$i]['rarity']??'-';
                        $types = implode(PHP_EOL, array_to_images($data['data'][$i]['types']??[]));
                        $supertypes = $data['data'][$i]['supertype']??'-';
                        $subtypes = implode(", ", $data['data'][$i]['subtypes']??[]);
                        $sellPrice = $data['data'][$i]['cardmarket']['prices']['averageSellPrice']??'';
                        echo "
                        <tr>
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
    </main>
    <?php include "./site_onderdelen/footer.php"?>
</body>
</html>
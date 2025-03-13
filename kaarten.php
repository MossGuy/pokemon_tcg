<?php
include "./api_key.php";

if (isset($_GET['id'])) {
    define("SET_ID", $_GET['id']);
}

define("URL", "https://api.pokemontcg.io/v2/cards?q=set.id:" . SET_ID . KEY);
// define("URL", "./test_json_bestanden/pokemon_cardset.json");

$response = file_get_contents(URL);
$data = json_decode($response, true);
$totalCount = count($data['data']);

function extract_numeric_id($card) {
    // Gebruik regex om zowel het numerieke als het optionele letterdeel op te vangen
    preg_match('/-(\d+)([a-zA-Z]*)$/', $card['id'], $matches);

    // Haal het numerieke gedeelte op en zet het om naar een integer
    $numeric_part = (int)$matches[1];

    // Haal het optionele letterdeel op (kan leeg zijn)
    $letter_part = $matches[2] ?? '';

    return [$numeric_part, $letter_part];
}

// Sorteer de kaarten op numeriek ID en daarna op het letterdeel
try {
    usort($data['data'], function($a, $b) {
        [$id_a, $letter_a] = extract_numeric_id($a);
        [$id_b, $letter_b] = extract_numeric_id($b);

        // Vergelijk eerst op numeriek ID
        if ($id_a !== $id_b) {
            return $id_a - $id_b;
        }

        // Als de nummers gelijk zijn, sorteer op het lettergedeelte
        return strcmp($letter_a, $letter_b);
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
    <main class="container">
        <section class="card_container">
            <h1 class="set_title"><?=SET_ID?></h1>
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
    </main>


</body>
</html>
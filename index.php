<?php
include "./api_key.php";

//https://api.pokemontcg.io/v2/sets?q=series:Scarlet%20&%20Violet

define("SERIES", [
    "Scarlet & Violet", "Sword & Shield", "Other", "Sun & Moon", "XY", "Black & White",
    "HeartGold & SoulSilver", "Platinum", "POP", "Diamond & Pearl", "EX", "NP", "E-Card", "NEO", "Gym", "Base"
]);

$sets = [];

echo '<pre>'; 

// define("URL", "https://api.pokemontcg.io/v2/sets?" . KEY);
define("URL", "./test_json_bestanden/pokemon_sets.json");
$response = file_get_contents(URL);
$data = json_decode($response, true);


foreach ($data['data'] as $serie) {
    // Haal de serie naam en de bijbehorende sets op

    echo $serie['name'] . PHP_EOL;

    // $serieName = $serie['series']; // De naam van de serie
    // $serieSets = $serie['sets']; // De sets van deze serie
    
    // // Controleer of de serie al bestaat in de $sets array
    // if (isset($sets[$serieName])) {
    //     // Als de serie al bestaat, voeg de sets toe aan de bestaande array
    //     $sets[$serieName] = array_merge($sets[$serieName], $serieSets);
    // } else {
    //     // Als de serie nog niet bestaat, voeg deze serie toe met de sets
    //     $sets[$serieName] = $serieSets;
    // }
}

// print_r($data['data']);
print_r($sets);
// echo $data['data'][0]['series'];
echo '</pre>';

//https://pokemontcg.guru/sets --referentie website
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./stylesheets/style.css">
    <link rel="stylesheet" href="./stylesheets/index.css">
    <script src="./script.js" defer></script>
    <title>Pokémon kaarten</title>
</head>
<body>
    <header>
         <div>
            <h1>Pokémon TCG</h1>
            <p>Kaarten bibliotheek</p>
         </div>
    </header>

    <main class="set_container">
    <?php

    $totalItems = count($data['data']);
    $series_stored = "";
    for ($i = $totalItems - 1; $i >= 0; $i--) {
        $id = $data['data'][$i]['id'];
        $name = $data['data'][$i]['name'];
        $logo = $data['data'][$i]['images']['logo'];
        $symbol = $data['data'][$i]['images']['symbol'];
        $date = $data['data'][$i]['releaseDate'];
        $series_json = $data['data'][$i]['series'];

        $standard_legal = isset($data['data'][$i]['legalities']['standard']) ? "<li>Standard {$data['data'][$i]['legalities']['standard']}</li>" : '';
        $expanded_legal = isset($data['data'][$i]['legalities']['expanded']) ? "<li>Expanded {$data['data'][$i]['legalities']['expanded']}</li>" : '';

        if ($series_json != $series_stored) {
            $series_stored = $series_json;
            echo "<h2 class='set_title'>$series_json</h2>";
        }
        echo "
        <a class='card' href='./kaarten.php?id=$id'>
            <figure class='card_image'>
                <img src='$logo' alt='$name'>
            </figure>
            <div class='card_content'>
                <div class='media'>
                    <div class='media_left'>
                        <figure class='symbol'>
                            <img src='$symbol' alt='$name'>
                        </figure>
                    </div>
                    <div class='media_content'>
                        <h2>$name</h2>
                        <p>Uitkomstdatum: $date</p>
                    </div>
                </div>
                <div class='content'>
                    <ul>
                        $standard_legal
                        $expanded_legal
                    </ul>
                </div>
            </div>
        </a>
        " . PHP_EOL;
    }

    ?>
    </main>
</body>
</html>
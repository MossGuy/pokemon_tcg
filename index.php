<?php
include "./api_key.php";

   // referentie websites
  //  https://api.pokemontcg.io/v2/series_list?q=series:Scarlet%20&%20Violet
 //   https://pokemontcg.guru/sets

define("SERIES", [
    "Scarlet & Violet", "Sword & Shield", "Other", "Sun & Moon", "XY", "Black & White",
    "HeartGold & SoulSilver", "Platinum", "POP", "Diamond & Pearl", "EX", "NP", "E-Card", "NEO", "Gym", "Base"
]);

// define("URL", "https://api.pokemontcg.io/v2/series_list?" . KEY);
define("URL", "./test_json_bestanden/pokemon_sets.json");

$response = file_get_contents(URL);
$data = json_decode($response, true);

// sorteer alle sets per serie in een nieuwe array
$series_list = [];
foreach ($data['data'] as $serie) {
    $serieName = $serie['series'];
    if (isset($series_list[$serieName])) {
        array_push($series_list[$serieName], $serie);
    } else {
        $series_list[$serieName][] = $serie;
    }
}
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
        <!-- <div class=""> -->
    <?php
    
    $count = 0;
    foreach (array_reverse($series_list) as $name => $series) {
        echo "<h2 class='set_title'>$name</h2>";

        foreach (array_reverse($series) as $set) {
            $id = $set['id'];
            $name = $set['name'];
            $logo = $set['images']['logo'];
            $symbol = $set['images']['symbol'];
            $date = $set['releaseDate'];
            $series_json = $set['series'];

            $standard_legal = isset($set['legalities']['standard']) ? "<li>Standard {$set['legalities']['standard']}</li>" : '';
            $expanded_legal = isset($set['legalities']['expanded']) ? "<li>Expanded {$set['legalities']['expanded']}</li>" : '';

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
            ";
        }
    }
    ?>
        <!-- </div> -->
    </main>
</body>
</html>
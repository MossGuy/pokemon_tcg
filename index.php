<?php
include "./api_key.php";
// define("URL", "https://api.pokemontcg.io/v2/sets?" . KEY);
define("URL", "./test_json_bestanden/pokemon_sets.json");
$response = file_get_contents(URL);
$data = json_decode($response, true);

echo '<pre>'; 
// print_r($data['data']);
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
    for ($i = $totalItems - 1; $i >= 0; $i--) {
        $id = $data['data'][$i]['id'];
        $name = $data['data'][$i]['name'];
        $logo = $data['data'][$i]['images']['logo'];
        $symbol = $data['data'][$i]['images']['symbol'];
        $date = $data['data'][$i]['releaseDate'];

        $standard_legal = isset($data['data'][$i]['legalities']['standard']) ? "<li>Standard {$data['data'][$i]['legalities']['standard']}</li>" : '';
        $expanded_legal = isset($data['data'][$i]['legalities']['expanded']) ? "<li>Expanded {$data['data'][$i]['legalities']['expanded']}</li>" : '';


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
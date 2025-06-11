<?php
if (!file_exists('api_key.php')) { copy('api_key.example.php', 'api_key.php');}
require_once "./api_key.php";
require_once "./php_functies/api_check.php";

define("SERIES", [
    "Scarlet & Violet", "Sword & Shield", "Other", "Sun & Moon", "XY", "Black & White",
    "HeartGold & SoulSilver", "Platinum", "POP", "Diamond & Pearl", "EX", "NP", "E-Card", "NEO", "Gym", "Base"
]);

$url = "https://api.pokemontcg.io/v2/sets?" . KEY;

$result = fetch_from_api($url);
if (!$result['success']) {
    die("Fout bij ophalen van API-data: " . $result['error'] . PHP_EOL . "Ververs de pagina om het nog een keer te proberen.");
}
$data = $result['data'];

// Groepeer de sets op basis van series zoals in SERIES gedefinieerd
$series_list = [];

// Initialiseer lege arrays voor elke serie in SERIES
foreach (SERIES as $serie) {
    $series_list[$serie] = [];
}

// Voeg de sets toe aan de juiste serie
foreach ($data['data'] as $set) {
    $serieName = $set['series'];

    // Zorg ervoor dat de serie in de SERIES array staat
    if (in_array($serieName, SERIES)) {
        $series_list[$serieName][] = $set;
    } else {
        // Zet sets die geen serie hebben in de 'Other' categorie
        $series_list['Other'][] = $set;
    }
}
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
    <link rel="stylesheet" href="./stylesheets/sets.css">
    <script src="./script.js" defer></script>
    <title>Pokémon kaarten</title>
</head>
<body>
    <?php include "./site_onderdelen/navbar.php"?>
    <main class="container">
        <div class="set_container">
        <?php
        foreach (SERIES as $name) {
            // Controleer of er sets zijn voor deze serie
            if (count($series_list[$name]) > 0) {
                echo "<h2 class='set_title w_100'>$name</h2>";

                $reversed_sets = array_reverse($series_list[$name]);
                
                foreach ($reversed_sets as $set) {
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
                    <div class='card_content optional'>
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
        }
        ?>
        </div>
    </main>
    <?php include "./site_onderdelen/footer.php"?>
</body>
</html>

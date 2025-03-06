<?php
include "./api_key.php";
if (isset($_GET['id'])) {
    define("CARD_ID", $_GET['id']);
}

 // referentie website
// https://api.pokemontcg.io/v2/cards?q=id:sv7-111

// define("URL", "https://api.pokemontcg.io/v2/cards?q=id:" . CARD_ID . KEY);
define("URL", "./test_json_bestanden/pokemon_card.json");
$response = file_get_contents(URL);
$data = json_decode($response, true);

echo "<pre>";
// echo CARD_ID;
echo "</pre>";


?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./stylesheets/style.css">
    <link rel="stylesheet" href="./stylesheets/kaart.css">
    <title></title>
</head>
<body>
    <main class="container">
        <div class="kaart_container">
            <div class="foto_container">
                <img class="kaart_img" src="<?=$data['data'][0]['images']['large']?>" alt="kaart_foto">
            </div>
            <div class="info_container">
                <div class="title">
                    <h1><?= $data['data'][0]['name']?></h1>
                    <div>
                        <p><?= $data['data'][0]['supertype']?> - <?= implode(", ",$data['data'][0]['subtypes'])?></p>
                    </div>
                </div>
                <div class="divider"></div>

            </div>
        </div>
    </main>
</body>
</html>
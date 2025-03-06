<?php
include "./api_key.php";
if (isset($_GET['id'])) {
    define("CARD_ID", $_GET['id']);
}

// define("URL", "https://api.pokemontcg.io/v2/cards?q=id:" . CARD_ID . KEY);
define("URL", "./test_json_bestanden/pokemon_card.json");
$response = file_get_contents(URL);
$data = json_decode($response, true);

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    
</body>
</html>
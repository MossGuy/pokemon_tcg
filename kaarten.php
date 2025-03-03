<?php
include "./api_key.php";

if (isset($_GET['id'])) {
    define("SET_ID", $_GET['id']);
}

// define("URL", "https://api.pokemontcg.io/v2/cards?q=set.id:" . SET_ID ."&orderBy=id&appid=" . KEY);
define("URL", "./test_json_bestanden/pokemon_cardset.json");

$response = file_get_contents(URL);
$data = json_decode($response, true);
$totalCount = count($data['data']);

// Functie om het numerieke gedeelte van het ID te extraheren
function extract_numeric_id($card) {
    // Gebruik reguliere expressie om het nummer na het streepje te halen (bijv. sv8-1 -> 1)
    preg_match('/-(\d+)$/', $card['id'], $matches);
    return (int)$matches[1];  // Return het numerieke gedeelte van het ID als een integer
}
// Sorteer de kaarten op het numerieke ID
usort($data['data'], function($a, $b) {
    $id_a = extract_numeric_id($a);
    $id_b = extract_numeric_id($b);
    return $id_a - $id_b;  // Numerieke sortering
});


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
    <header>
        <h1><?=SET_ID?></h1>
    </header>
    <main>
        <section class="card_container">
            <?php
            for ($i = 0; $i < $totalCount; $i++) {
                // echo "
                // <tr>
                //     <td>{$data['data'][$i]['id']}</td>
                //     <td>{$data['data'][$i]['name']}</td>
                // </tr>
                // ";
                
                $name = $data['data'][$i]['name'];
                $image = $data['data'][$i]['images']['small'];

                echo "
                <a href='./kaart.php'>
                    <img src='$image' alt='$name'>
                </a>
                " . PHP_EOL;
            }
            ?>
        </section>
    </main>


</body>
</html>
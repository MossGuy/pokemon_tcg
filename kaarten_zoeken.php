<?php
include "./api_key.php";


$query = isset($_GET['query']) ? trim($_GET['query']) : '';
// $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Basisvalidatie: beperk lengte en filter gevaarlijke tekens
if (empty($query) || strlen($query) > 100) {
    die("Ongeldige zoekopdracht.");
}

$query = urlencode($query); // Veilig voor URL

define("URL", "https://api.pokemontcg.io/v2/cards?q=name:" . $query . KEY);

$response = file_get_contents(URL);
$data = json_decode($response, true);
$totalCount = count($data['data']??0);
$not_found_div = ($totalCount == 0) ? "" : "unavailable";
$found_div = ($totalCount > 0) ? "" : "unavailable";

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
    <main class="container">
        <section class="card_container <?=$found_div?>">
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
            <!-- <div class="w_100 flex_row gap5 j_center">
                <button onclick="window.location.href='./kaarten_zoeken.php?query=<?=$query?>&page=1'">Vorige</button>
                <button onclick="window.location.href='./kaarten_zoeken.php?query=<?=$query?>&page=2'">Volgende</button>
            </div> -->
        </section>
        <section class="t_center <?=$not_found_div?>">
            <img src="./images/confused.png" alt="">
            <h1>Hmmmmm... wij konden niks vinden met uw zoekcriteria</h1>
        </section>
    </main>
    <?php include "./site_onderdelen/footer.php"?>
</body>
</html>
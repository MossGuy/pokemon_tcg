<?php
include "./api_key.php";
if (isset($_GET['id'])) {
    define("CARD_ID", $_GET['id']);
}

 // referentie website
// https://api.pokemontcg.io/v2/cards?q=id:sv7-111

// TODO: schrijf een functie die een type als string krijgt en een image returned

// define("URL", "https://api.pokemontcg.io/v2/cards?q=id:" . CARD_ID . KEY);
define("URL", "./test_json_bestanden/pokemon_card.json");
$response = file_get_contents(URL);
$data = json_decode($response, true);

echo "<pre>";
// print_r($data);
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
                <nav class="title">
                    <div>
                        <h1><?= $data['data'][0]['name']?></h1>
                        <div>
                            <h2><?= $data['data'][0]['supertype']?> - <?= implode(", ",$data['data'][0]['subtypes'])?></h2>
                        </div>
                    </div>
                    <div class="title_right">
                        <h2>HP <?=$data['data'][0]['hp']?></h2>
                        <div class="energy_type">
                            
                        </div>
                    </div>
                </nav>

                <div class="divider"></div>

                <section>
                    <div class="flex_row">
                        <h2 class="padding_h">Prices</h2>
                        <div class="padding_h">
                            <input id="TCGPlayer" type="checkbox" checked>
                            <label for="TCGPlayer">TCGPlayer</label>
                        </div>
                        <div class="padding_h">
                            <input id="Cardmarket" type="checkbox" checked>
                            <label for="Cardmarket">Cardmarket</label>
                        </div>
                    </div>

                    <div id="TCGPlayer_div">

                    </div>
                    <div id="Cardmarket_div">

                    </div>
                </section>

                <div class="divider"></div>

                <section>
                    <p class="p_heading">attacks</p>
                    <table class="attacks">
                       <?php
                        foreach($data['data'][0]['attacks'] as $a) {
                            $cost = implode(", ", $a['cost']);
                            echo "
                            <tbody>
                            <tr>
                                <td>$cost</td>
                                <td>{$a['name']}</td>
                                <td>{$a['damage']}</td>
                            </tr>
                            <tr>
                                <td colspan='3'>{$a['text']}</td>
                            </tr>
                       </tbody>
                            ";
                        }
                       ?>
                    </table>
                </section>

                <section class="info_list">
                    <div>
                        <p class="p_heading">weakness</p>
                        <p></p>
                    </div>
                    <div>
                        <p class="p_heading">resistance</p>
                        <p></p>
                    </div>
                    <div>
                        <p class="p_heading">retreat cost</p>
                        <p></p>
                    </div>
                    <div>
                        <p class="p_heading">artist</p>
                        <p></p>
                    </div>
                    <div>
                        <p class="p_heading">rarity</p>
                        <p></p>
                    </div>
                    <div>
                        <p class="p_heading">set</p>
                        <p></p>
                    </div class="p_heading">
                    <div>
                        <p>number</p>
                        <p></p>
                    </div>
                    <div>
                        <p class="p_heading">regulation mark</p>
                        <p></p>
                    </div>
                </section>

                <section></section>

            </div>
        </div>
    </main>
</body>
</html>
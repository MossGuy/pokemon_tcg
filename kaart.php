<?php
include "./api_key.php";
if (isset($_GET['id'])) {
    define("CARD_ID", $_GET['id']);
}

 // referentie website
// https://api.pokemontcg.io/v2/cards?q=id:sv7-111

// TODO: schrijf een functie die een type als string krijgt en een image returned

define("URL", "https://api.pokemontcg.io/v2/cards?q=id:" . CARD_ID . KEY);
// define("URL", "./test_json_bestanden/pokemon_card.json");
$response = file_get_contents(URL);
$data = json_decode($response, true);
$data_parsed = $data['data'][0];

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
                <img class="kaart_img" src="<?=$data_parsed['images']['large']?>" alt="kaart_foto">
            </div>

            <div class="info_container">
                <nav class="flex_row j_between">
                    <div>
                        <h1><?=$data_parsed['name']?></h1>
                        <div>
                            <h2><?=$data_parsed['supertype']?> - <?= implode(", ",$data_parsed['subtypes'])?></h2>
                        </div>
                    </div>
                    <div class="flex_row gap5">
                        <h2>HP <?=$data_parsed['hp']?></h2>
                        <div class="energy_type">
                            <?=implode(", ", $data_parsed['types'])?>
                        </div>
                    </div>
                </nav>

                <div class="divider"></div>

                <section>
                    <div class="flex_row">
                        <h2>Prices</h2>
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
                        foreach($data_parsed['attacks'] as $a) {
                            $cost = implode(", ", $a['cost']);
                            $damage = $a['damage'] ?? "";
                            echo "
                            <tbody>
                            <tr>
                                <th>$cost</th>
                                <th class='attack_name'>{$a['name']}</th>
                                <th class='damage'>$damage</th>
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
                        <p>
                            <?=$data_parsed['weaknesses'][0]['type'] ?? "N/A"?> 
                            <strong><?=$data_parsed['weaknesses'][0]['value'] ?? ""?></strong>
                        </p>
                    </div>
                    <div>
                        <p class="p_heading">resistance</p>
                        <p>
                        <?=$data_parsed['resistances'][0]['type'] ?? "N/A"?> 
                        <strong><?=$data_parsed['resistances'][0]['value'] ?? ""?></strong>
                        </p>
                    </div>
                    <div>
                        <p class="p_heading">retreat cost</p>
                        <p><?=implode(", ", $data_parsed['retreatCost'] ?? ["N/A"])?></p>
                    </div>
                    <div>
                        <p class="p_heading">artist</p>
                        <p><strong><?=$data_parsed['artist'] ?? "N/A"?></strong></p>
                    </div>
                    <div>
                        <p class="p_heading">rarity</p>
                        <p><strong><?=$data_parsed['rarity'] ?? "N/A"?></strong></p>
                    </div>
                    <div>
                        <p class="p_heading">set</p>
                        <p><strong>
                            <a class='flex_row j_between' href='./kaarten.php?id=<?=$data_parsed['set']['id']?>'>
                            <span class="set_name"><?=$data_parsed['set']['name']?></span>
                            <img class="set_symbol" src="<?=$data_parsed['set']['images']['symbol']?>" alt="<?=$data_parsed['set']['name']?>">
                            </a>
                        </strong></p>
                    </div class="p_heading">
                    <div>
                        <p class="p_heading">number</p>
                        <p><strong><?=$data_parsed['number'] ?? "N/A"?></strong></p>
                    </div>
                    <div>
                        <p class="p_heading">regulation mark</p>
                        <p><strong><?=$data_parsed['resistances'][0]['regulationMark'] ?? "N/A"?></strong></p>
                    </div>
                </section>

                <section class="flex_row legalities">
                    <div>
                        <p>Standard</p>
                        <?= "<p class='" . ($data_parsed['legalities']['standard'] ?? 'Not_legal') . "'>" . ($data_parsed['legalities']['standard'] ?? 'Not legal') . "</p>"; ?>
                    </div>
                    <div>
                        <p>Expanded</p>
                        <?= "<p class='" . ($data_parsed['legalities']['expanded'] ?? 'Not_legal') . "'>" . ($data_parsed['legalities']['expanded'] ?? 'Not legal') . "</p>"; ?>
                    </div>
                    <div>
                        <p>Unlimited</p>
                        <?= "<p class='" . ($data_parsed['legalities']['unlimited'] ?? 'Not_legal') . "'>" . ($data_parsed['legalities']['unlimited'] ?? 'Not legal') . "</p>"; ?>
                    </div>
                </section>

            </div>
        </div>
    </main>
</body>
</html>
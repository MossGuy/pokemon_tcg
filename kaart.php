<?php
include "./api_key.php";
include "./php_functies/array_to_images.php";
if (isset($_GET['id'])) {
    define("CARD_ID", $_GET['id']);
}

define("URL", "https://api.pokemontcg.io/v2/cards?q=id:" . CARD_ID . KEY);
// define("URL", "./test_json_bestanden/pokemon_card.json");
$response = file_get_contents(URL);
$data = json_decode($response, true);
$data_parsed = $data['data'][0];

// definieer welke div de unavailable class krijgt (display: none !important;)
$hasHP = $data_parsed['hp']??'unavailable';
$tcgplayer_main = $data_parsed['tcgplayer']['updatedAt']??'unavailable';
$tcgplayer_normal = $data_parsed['tcgplayer']['prices']['normal']['market']??'unavailable';
$tcgplayer_holo = $data_parsed['tcgplayer']['prices']['holofoil']['market']??'unavailable';
$tcgplayer_reverseholo = $data_parsed['tcgplayer']['prices']['reverseHolofoil']['market']??'unavailable';
$cardmarket_main = $data_parsed['cardmarket']['updatedAt']??'unavailable';
$ability = $data_parsed['abilities'][0]['name']??'unavailable';
$attacks = $data_parsed['attacks'][0]['name']??'unavailable';
$rules = 'unavailable';
if (isset($data_parsed['rules'])) {
 $rules = '';
}


echo "<pre>";
// print_r($data_parsed);
echo "</pre>";
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./stylesheets/style.css">
    <link rel="stylesheet" href="./stylesheets/kaart.css">
    <script src="./script.js" defer></script>
    <title></title>
</head>
<body>
    <?php include "./site_onderdelen/navbar.php"?>
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
                    <div class="flex_row gap5 <?=$hasHP?>">
                        <h2>HP <?=$data_parsed['hp']??''?></h2>
                        <div>
                            <?= implode(PHP_EOL, array_to_images($data_parsed['types']??[]));?>
                        </div>
                    </div>
                </nav>

                <div class="divider"></div>

                <section>
                    <div class="flex_row">
                        <h2>Prices</h2>
                        <div class="padding_h">
                            <input id="TCGPlayer" type="checkbox" checked onclick="toggle_menu('TCGPlayer_div', 'block')">
                            <label for="TCGPlayer">TCGPlayer</label>
                        </div>
                        <div class="padding_h">
                            <input id="Cardmarket" type="checkbox" checked onclick="toggle_menu('Cardmarket_div', 'block')">
                            <label for="Cardmarket">Cardmarket</label>
                        </div>
                    </div>

                    <div id="TCGPlayer_div" class="<?=$tcgplayer_main?>">
                        <p><a class="site_link" href="<?=$data_parsed['tcgplayer']['url']??''?>">Buy Now From TCGplayer</a></p>
                        <p class="p_heading">Last Updated <?=$data_parsed['tcgplayer']['updatedAt']??''?></p>
                        <div class="flex_row j_between price_list <?=$tcgplayer_normal?>">
                            <div>
                                <p>normal market</p>
                                <p><strong><?=$data_parsed['tcgplayer']['prices']['normal']['market']??''?></strong></p>
                            </div>
                            <div>
                                <p>normal low</p>
                                <p><strong><?=$data_parsed['tcgplayer']['prices']['normal']['low']??''?></strong></p>
                            </div>
                            <div>
                                <p>normal mid</p>
                                <p><strong><?=$data_parsed['tcgplayer']['prices']['normal']['mid']??''?></strong></p>
                            </div>
                            <div>
                                <p>normal high</p>
                                <p><strong><?=$data_parsed['tcgplayer']['prices']['normal']['high']??''?></strong></p>
                            </div>
                        </div>

                        <div class="flex_row j_between price_list <?=$tcgplayer_holo?>">
                            <div>
                                <p>holofoil market</p>
                                <p><strong><?=$data_parsed['tcgplayer']['prices']['holofoil']['market']??''?></strong></p>
                            </div>
                            <div>
                                <p>holofoil low</p>
                                <p><strong><?=$data_parsed['tcgplayer']['prices']['holofoil']['low']??''?></strong></p>
                            </div>
                            <div>
                                <p>holofoil mid</p>
                                <p><strong><?=$data_parsed['tcgplayer']['prices']['holofoil']['mid']??''?></strong></p>
                            </div>
                            <div>
                                <p>holofoil high</p>
                                <p><strong><?=$data_parsed['tcgplayer']['prices']['holofoil']['high']??''?></strong></p>
                            </div>
                        </div>
                    </div>
                        
                    <div class="flex_row j_between price_list <?=$tcgplayer_reverseholo?>">
                        <div>
                            <p>reverse holofoil market</p>
                            <p><strong><?=$data_parsed['tcgplayer']['prices']['reverseHolofoil']['market']??''?></strong></p>
                        </div>
                        <div>
                            <p>reverse holofoil low</p>
                            <p><strong><?=$data_parsed['tcgplayer']['prices']['reverseHolofoil']['low']??''?></strong></p>
                        </div>
                        <div>
                            <p>reverse holofoil mid</p>
                            <p><strong><?=$data_parsed['tcgplayer']['prices']['reverseHolofoil']['mid']??''?></strong></p>
                        </div>
                        <div>
                            <p>reverse holofoil high</p>
                            <p><strong><?=$data_parsed['tcgplayer']['prices']['reverseHolofoil']['high']??''?></strong></p>
                        </div>
                    </div>

                    <div id="Cardmarket_div" class="<?=$cardmarket_main?>">
                        <p><a class="site_link" href="<?=$data_parsed['cardmarket']['url']??''?>">Buy Now From Cardmarket</a></p>
                        <p class="p_heading">Last Updated <?=$data_parsed['cardmarket']['updatedAt']??''?></p>
                        <div class="flex_row j_between price_list">
                            <div>
                                <p>price trend</p>
                                <p><strong><?=$data_parsed['cardmarket']['prices']['trendPrice']??''?></strong></p>
                            </div>
                            <div>
                                <p>1 day average</p>
                                <p><strong><?=$data_parsed['cardmarket']['prices']['avg1']??''?></strong></p>
                            </div>
                            <div>
                                <p>7 day average</p>
                                <p><strong><?=$data_parsed['cardmarket']['prices']['avg7']??''?></strong></p>
                            </div>
                            <div>
                                <p>30 day average</p>
                                <p><strong><?=$data_parsed['cardmarket']['prices']['avg30']??''?></strong></p>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="divider"></div>

                <section class="<?=$ability?>">
                    <p class="p_heading">abilities</p>
                    <?php
                    isset($data_parsed['abilities']) && array_map(function($a) {
                        echo "
                        <h2><span class='accent'>{$a['type']}:</span> {$a['name']}</h2>
                        <p>{$a['text']}</p>
                        ";
                    }, $data_parsed['abilities']);                    
                    ?>
                </section>

                <section class="<?=$rules?>">
                    <p class="p_heading">rules</p>
                    <p><?=$data_parsed['rules'][0]??''?></p><br>
                    <p><?=$data_parsed['rules'][1]??''?></p>
                </section>

                <section class="<?=$attacks?>">
                    <p class="p_heading">attacks</p>
                    <table class="attacks">
                       <?php
                        isset($data_parsed['attacks']) && array_map(function($a) {
                            $cost = implode(PHP_EOL, array_to_images($a['cost']));
                            $damage = $a['damage'] ?? "";
                            echo "
                            <tbody>
                                <tr>
                                    <th colspan=2>$cost {$a['name']}</th>
                                    <th class='damage'>$damage</th>
                                </tr>
                                <tr>
                                    <td colspan='3'>{$a['text']}</td>
                                </tr>
                            </tbody>
                            ";
                        }, $data_parsed['attacks']);                        
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
                        <p><?=implode(PHP_EOL, array_to_images($data_parsed['retreatCost'] ?? []))?></p>
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
    <?php include "./site_onderdelen/footer.php"?>
</body>
</html>
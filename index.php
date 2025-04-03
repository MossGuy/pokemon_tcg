<?php $navbar_include = "unavailable";?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO tags, bedacht door chatGPT :D -->
    <meta name="description" content="Zoek en bekijk Pokémon kaarten uit verschillende sets">
    <meta name="keywords" content="Pokémon, kaarten, tcg, set, nummer, naam, zeldzaamheid">

    <link rel="stylesheet" href="./stylesheets/style.css">
    <link rel="stylesheet" href="./stylesheets/index.css">
    <script src="./script.js" defer></script>
    <title>Pokémon TCG</title>
</head>
<body>
    <?php include "./site_onderdelen/navbar.php"?>

    <header>
        <div>
            <h1>Pokémon TCG</h1>
            <p>Kaarten bibliotheek</p>
        </div>
    </header>

    <main>
        <section class="container zoekbalk t_center">
            <h2>Zoek een kaart</h2>
            <form action="" method="POST">
                <input id="card_query" name="card_query" type="text" placeholder="" value="<?=value?>">
                <p>Probeer <a href="./kaarten_zoeken.php?query=mudkip">"mudkip"</a> of blader door de <a href="./sets.php">verschillende sets</a>.</p>
            </form>
        </section>
    </main>

    <?php include "./site_onderdelen/footer.php"?>
</body>
</html>
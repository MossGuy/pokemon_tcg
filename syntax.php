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
    <link rel="stylesheet" href="./stylesheets/syntax.css">
    <script src="./script.js" defer></script>
    <title>Pokémon TCG</title>
</head>
<body>
    <?php include "./site_onderdelen/navbar.php"?>

    <main>
        <section class="container">
            <h1>Syntax handleiding</h1>
            <p>
                De pokemon kaarten bibliotheek heeft verschillende manieren om data op te vragen.
                Om complexe queries (zoek opdrachten) te maken, heb je twee opties:
            </p>
        </section>

        <section class="container">
            <h1>Optie 1: Het geavanceerde zoek formulier</h1>
            <p>
                Een makkelijke manier om te zoeken naar kaarten is het <a class="accent_hover" href=""><strong>Geavanceerde zoek formulier</strong></a>.
                Dit maakt het mogelijk om snel en makkelijk kaarten te zoeken gebaseerd op verschillende criteria zoals naam, set, zwakte en meer.
            </p>
        </section>

        <section class="container">
            <h1>Optie 2: De geavanceerde query syntax</h1>
            <p>
                De Pokémon kaarten bibliotheek maakt gebruik van een query syntax mogelijk gemaakt door de <a class="accent_hover" href="https://pokemontcg.io/"><strong>Pokémon TCG API</strong></a>.
                Deze syntax is gebaseerd op <a class="accent_hover" href="https://www.lucenetutorial.com/lucene-query-syntax.html"><strong>Lucene</strong></a> dat complexe queries kan uitvoeren en ondersteund operators als AND, OR, NOT en meer.
            </p>
            <br>
            <p>
                Je kan deze complexe queries overal gebruiken op de Pokémon kaarten bibliotheek. Bijvoorbeeld de query <span class="accent"><strong>subtypes:tera</strong></span> zoekt alle kaarten die als subtype 'Tera' hebben.
                De zoekbalken hebben als standaard output <span class="accent"><strong>name:"jouw query"</strong></span> tenzei er leestekens worden gebruikt.
            </p>
            <br>
            <p>
                Bekijk de <a class="accent_hover" href="https://docs.pokemontcg.io/"><strong>API documentatie</strong></a> voor meer details en voorbeelden.
            </p>
        </section>
    </main>

    <?php include "./site_onderdelen/footer.php"?>
</body>
</html>
<?php
require_once "./php_functies/api_check.php";

$url = "https://api.pokemontcg.io/v2/cards?q=name:sceptile&pageSize=1";
$result = fetch_from_api($url);
?>

<?php $navbar_include = "unavailable"; ?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <style>
        .debug_output {
            background-color: #f4f4f4;
            border: 1px solid var(--lightest);
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 8px;
            width: 90%;
            max-width: 1000px;
            font-family: monospace;
            white-space: pre-wrap;
            overflow-x: auto;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon links -->
    <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
    <link rel="manifest" href="./favicon/site.webmanifest">

    <!-- Styles -->
    <link rel="stylesheet" href="./stylesheets/style.css">
    <link rel="stylesheet" href="./stylesheets/index.css">

    <!-- Scripts -->
    <script src="./script.js" defer></script>

    <title>Pokémon TCG Debug</title>
</head>
<body>
    <?php include "./site_onderdelen/navbar.php"; ?>

    <main class="flex_row j_center">
        <section class="debug_output">
            <?php if (!$result['success']): ?>
                <p><strong>FOUT:</strong> <?= htmlspecialchars($result['error']) ?></p>
            <?php else: ?>
                <p><strong>SUCCES:</strong> Er zijn <?= count($result['data']['data']) ?> kaarten opgehaald.</p>
                <pre><?= print_r($result['data'], true) ?></pre>
            <?php endif; ?>
        </section>
    </main>

    <?php include "./site_onderdelen/footer.php"; ?>
</body>
</html>

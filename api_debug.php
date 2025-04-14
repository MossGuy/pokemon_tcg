<?php
require_once "./php_functies/api_check.php";

// Test met een geldige API URL
$url = "https://api.pokemontcg.io/v2/cards?q=name:sceptile&pageSize=1";

$result = fetch_from_api($url);

if (!$result['success']) {
    echo "<strong>FOUT:</strong> " . $result['error'];
} else {
    echo "<strong>SUCCES:</strong> Er zijn " . count($result['data']['data']) . " kaarten opgehaald.<br>";
    echo "<pre>";
    print_r($result['data']);
    echo "</pre>";
}
?>
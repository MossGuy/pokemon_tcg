<?php
function fetch_from_api($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // timeout in seconden
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return [
            'success' => false,
            'error' => "cURL-fout: $error_msg"
        ];
    }

    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_status !== 200) {
        return [
            'success' => false,
            'error' => "HTTP-fout: status $http_status"
        ];
    }

    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return [
            'success' => false,
            'error' => "JSON decode fout: " . json_last_error_msg()
        ];
    }

    return [
        'success' => true,
        'data' => $data
    ];
}
?>
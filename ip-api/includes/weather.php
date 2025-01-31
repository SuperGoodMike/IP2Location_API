<?php
function get_weather($lat, $lon) {
    $url = OPEN_METEO_URL . "&latitude=$lat&longitude=$lon";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    return [
        'temperature' => $data['current_weather']['temperature'] ?? null,
        'humidity' => $data['hourly']['relativehumidity_2m'][0] ?? null
    ];
}
?>
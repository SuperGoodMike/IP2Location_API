<?php
function get_weather($lat, $lon) {
    $url = OPEN_METEO_URL . "&latitude=$lat&longitude=$lon";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    return [
        'temperature' => $data['current_weather']['temperature'] ?? null,
        'humidity' => $data['current_weather']['relativehumidity'] ?? null,
        'cloudcover' => $data['current_weather']['cloudcover'] ?? null,
        'windspeed' => $data['current_weather']['windspeed'] ?? null,
        'pressure' => $data['current_weather']['pressure_msl'] ?? null,
        'precipitation' => $data['current_weather']['precipitation'] ?? null
    ];
}
?>

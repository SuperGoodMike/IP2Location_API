<?php
function get_weather($lat, $lon) {
    $url = OPEN_METEO_URL . "&latitude=$lat&longitude=$lon";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    // Debugging: Print the API response
    #var_dump($data);

    return [
        'temperature' => $data['current_weather']['temperature'] ?? null,
        'humidity' => $data['hourly']['relativehumidity_2m'][0] ?? null,
        'cloudcover' => $data['hourly']['cloudcover'][0] ?? null,
        'windspeed' => $data['current_weather']['windspeed'] ?? null,
        'pressure' => $data['hourly']['pressure_msl'][0] ?? null,
        'precipitation' => $data['hourly']['precipitation'][0] ?? null
    ];
}
?>

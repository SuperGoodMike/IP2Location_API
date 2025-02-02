<?php
function get_weather($lat, $lon) {
    $url = OPEN_METEO_URL . "&latitude=$lat&longitude=$lon";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    // Debugging: Print the API response
    #var_dump($data);

    return [
        'temperature' => $data['current_weather']['temperature'] ?? null,
        'temperature_unit' => $data['current_weather_units']['temperature'] ?? null,
        'humidity' => $data['hourly']['relativehumidity_2m'][0] ?? null,
        'cloudcover' => $data['hourly']['cloudcover'][0] ?? null,
        'windspeed' => $data['current_weather']['windspeed'] ?? null,
        'windspeed_unit' => $data['current_weather_units']['windspeed'] ?? null,
        'winddirection' => $data['current_weather']['winddirection'] ?? null,
        'winddirection_unit' => $data['current_weather_units']['winddirection'] ?? null,
        'is_day' => $data['current_weather']['is_day'] ?? null,
        'weathercode' => $data['current_weather']['weathercode'] ?? null,
        'pressure' => $data['hourly']['pressure_msl'][0] ?? null,
        'pressure_unit' => $data['current_weather_units']['pressure_msl'] ?? null,
        'precipitation' => $data['hourly']['precipitation'][0] ?? null,
        'precipitation_unit' => $data['current_weather_units']['precipitation'] ?? null
    ];
}
?>

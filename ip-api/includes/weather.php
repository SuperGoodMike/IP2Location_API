<?php
class WeatherService {
    public function get_weather($lat, $lon) {
        // Validate latitude and longitude
        if (!is_numeric($lat) || !is_numeric($lon) || $lat < -90 || $lat > 90 || $lon < -180 || $lon > 180) {
            throw new Exception("Invalid latitude or longitude");
        }

        $url = OPEN_METEO_URL . "&latitude=$lat&longitude=$lon";
        $response = @file_get_contents($url);

        if ($response === FALSE) {
            throw new Exception("Error fetching weather data");
        }

        $data = json_decode($response, true);

        if (!$data) {
            throw new Exception("Invalid weather data");
        }

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
            'pressure_unit' => $data['hourly_units']['pressure_msl'] ?? null,
            'precipitation' => $data['hourly']['precipitation'][0] ?? null,
            'precipitation_unit' => $data['hourly_units']['precipitation'] ?? null
        ];
    }
}
?>

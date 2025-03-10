<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/geoip.php';
require_once __DIR__ . '/../includes/weather.php';
require_once __DIR__ . '/../includes/ratelimit.php';

header('Content-Type: application/json');

try {
    // Validate API Key
    $api_key = $_GET['key'] ?? '';
    if (empty($api_key)) {
        http_response_code(401);
        die(json_encode(['error' => 'API key is missing']));
    }

    $stmt = $pdo->prepare("SELECT * FROM apikeys WHERE `key` = ?");
    $stmt->execute([$api_key]);
    $result = $stmt->fetch();

    // Debugging output
    error_log("API Key from GET: " . $api_key);
    error_log("API Key Result: " . print_r($result, true));

    if (!$result) {
        http_response_code(401);
        die(json_encode(['error' => 'Invalid API key']));
    }

    // Rate Limit Check
    check_rate_limit($pdo, $api_key, $_SERVER['REMOTE_ADDR']);

    // Get IP
    $ip = $_GET['ip'] ?? $_SERVER['REMOTE_ADDR'];
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        http_response_code(400);
        die(json_encode(['error' => 'Invalid IP']));
    }

    // Geolocation
    $geo = get_geolocation($ip);
    if (!$geo) {
        http_response_code(404);
        die(json_encode(['error' => 'Location not found']));
    }

    // Weather
    $weatherService = new WeatherService();
    $weather = $weatherService->get_weather($geo['latitude'], $geo['longitude']);

    // Debugging output
    error_log("Weather Data: " . print_r($weather, true));

    // Local Time
    $date = new DateTime('now', new DateTimeZone($geo['timezone']));

    // Response
    echo json_encode([
        'ip' => $ip,
        'city' => $geo['city'],
        'region' => $geo['region'],
        'country' => $geo['country'],
        'latitude' => $geo['latitude'],
        'longitude' => $geo['longitude'],
        'timezone' => $geo['timezone'],
        'local_time' => $date->format('Y-m-d H:i:s'),
        'temperature' => $weather['temperature'],
        'temperature_unit' => $weather['temperature_unit'],
        'humidity' => $weather['humidity'],
        'cloudcover' => $weather['cloudcover'],
        'windspeed' => $weather['windspeed'],
        'windspeed_unit' => $weather['windspeed_unit'],
        'winddirection' => $weather['winddirection'],
        'winddirection_unit' => $weather['winddirection_unit'],
        'is_day' => $weather['is_day'],
        'weathercode' => $weather['weathercode'],
        'pressure' => $weather['pressure'],
        'pressure_unit' => $weather['pressure_unit'],
        'precipitation' => $weather['precipitation'],
        'precipitation_unit' => $weather['precipitation_unit']
    ]);

} catch (Exception $e) {
    http_response_code(500);
    error_log("Exception: " . $e->getMessage());
    die(json_encode(['error' => $e->getMessage()]));
}
?>

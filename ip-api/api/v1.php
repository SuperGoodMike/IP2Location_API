<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/geoip.php';
require_once __DIR__ . '/../includes/weather.php';
require_once __DIR__ . '/../includes/ratelimit.php';

header('Content-Type: application/json');

try {
    // Validate API Key
    $api_key = $_GET['key'] ?? '';
    $stmt = $pdo->prepare("SELECT * FROM apikeys WHERE `key` = ?");
    $stmt->execute([$api_key]);
    if (!$stmt->fetch()) {
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
    $weather = get_weather($geo['latitude'], $geo['longitude']);

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
        'humidity' => $weather['humidity'],
        'cloudcover' => $weather['cloudcover'],
        'windspeed' => $weather['windspeed'],
        'winddirection' => $weather['winddirection'],
        'is_day' => $weather['is_day'],
        'weathercode' => $weather['weathercode'],
        'pressure' => $weather['pressure'],
        'precipitation' => $weather['precipitation']
    ]);

} catch (Exception $e) {
    http_response_code(500);
    die(json_encode(['error' => $e->getMessage()]));
}
?>

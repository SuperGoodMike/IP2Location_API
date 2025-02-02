<?php
require_once 'ip-api/includes/geoip.php';
require_once 'ip-api/includes/weather.php';

$geoService = new GeoIPService();
$weatherService = new WeatherService();

$ip = $_GET['ip'] ?? $_SERVER['REMOTE_ADDR'];

try {
    $geo = $geoService->get_geolocation($ip);
    $weather = $weatherService->get_weather($geo['latitude'], $geo['longitude']);

    echo json_encode(['geo' => $geo, 'weather' => $weather]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>

<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/../vendor/autoload.php'; // If using Composer for MaxMind

use MaxMind\Db\Reader;

function get_geolocation($ip, $api_key) {
    // Validate the API key
    if ($api_key !== API_KEY) {
        throw new Exception("Invalid API key");
    }

    // Validate IP address
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        throw new Exception("Invalid IP address");
    }

    if (!file_exists(MAXMIND_DB_PATH)) {
        throw new Exception("GeoLite2 database not found");
    }

    $reader = new Reader(MAXMIND_DB_PATH);
    $data = $reader->get($ip);
    $reader->close();

    if (!$data) {
        return null;
    }

    return [
        'city' => $data['city']['names']['en'] ?? 'Unknown',
        'region' => $data['subdivisions'][0]['names']['en'] ?? 'Unknown',
        'country' => $data['country']['names']['en'] ?? 'Unknown',
        'latitude' => $data['location']['latitude'] ?? 0,
        'longitude' => $data['location']['longitude'] ?? 0,
        'timezone' => $data['location']['time_zone'] ?? 'UTC'
    ];
}
?>

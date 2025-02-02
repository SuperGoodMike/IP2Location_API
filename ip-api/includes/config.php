<?php
// Enforce HTTPS
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    exit();
}

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'Your DB Name');
define('DB_USER', 'Your User');
define('DB_PASS', 'Your Password');

// Admin Credentials (Username and Hashed Password)
define('ADMIN_USER', 'YourAdmin');

// Read the hashed password from the .htpasswd file
$htpasswdFile = '/etc/secure/ip-api/.htpasswd';
if (file_exists($htpasswdFile)) {
    $htpasswdContent = file_get_contents($htpasswdFile);
    if ($htpasswdContent !== false) {
        $lines = explode("\n", trim($htpasswdContent));
        foreach ($lines as $line) {
            list($user, $hash) = explode(':', $line, 2);
            if ($user === 'admin') {
                define('ADMIN_PASS_HASH', $hash);
                break;
            }
        }
    }
}

// MaxMind GeoLite2 Database Path
define('MAXMIND_DB_PATH', __DIR__ . '/../data/GeoLite2-City.mmdb');

// Rate Limiting (100 requests/minute)
define('RATE_LIMIT', 100);
define('RATE_LIMIT_WINDOW', 60); // Seconds

// Open-Meteo API URL
#define('OPEN_METEO_URL', 'https://api.open-meteo.com/v1/forecast?current_weather=true&hourly=relativehumidity_2m');
#define('OPEN_METEO_URL', 'https://api.open-meteo.com/v1/forecast?current_weather=true&hourly=temperature_2m,relativehumidity_2m,cloudcover,windspeed_10m,pressure_msl,precipitation');
define('OPEN_METEO_URL', 'https://api.open-meteo.com/v1/forecast?current_weather=true');
// Create PDO instance for MySQL
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

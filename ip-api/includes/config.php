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
define('ADMIN_PASS_HASH', password_hash('YourSecretPassword', PASSWORD_BCRYPT));

// MaxMind GeoLite2 Database Path
define('MAXMIND_DB_PATH', __DIR__ . '/../data/GeoLite2-City.mmdb');

// Rate Limiting (100 requests/minute)
define('RATE_LIMIT', 100);
define('RATE_LIMIT_WINDOW', 60); // Seconds

// Open-Meteo API URL
define('OPEN_METEO_URL', 'https://api.open-meteo.com/v1/forecast?current_weather=true&hourly=relativehumidity_2m');

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

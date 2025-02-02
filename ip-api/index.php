<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/geoip.php';
require_once __DIR__ . '/includes/weather.php';

// Fetch user data
$ip = $_SERVER['REMOTE_ADDR'];
$geo = get_geolocation($ip);
$weather = get_weather($geo['latitude'], $geo['longitude']);
$date = new DateTime('now', new DateTimeZone($geo['timezone']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Geolocation API Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 100px 0;
        }
        .feature-icon {
            font-size: 2.5rem;
            color: #1e3c72;
        }
        .endpoint-example {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            position: relative;
        }
        .copy-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/ip-api/">IP Geo API</a>
            <div class="navbar-nav">
                <a class="nav-link" href="docs/"><i class="fas fa-book me-1"></i>Documentation</a>
                <a class="nav-link" href="admin/login.php"><i class="fas fa-lock me-1"></i>Admin</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 mb-4">IP Geolocation API Service</h1>
            <p class="lead mb-4">Instant IP to location lookup with weather data</p>
            <div class="endpoint-example text-start">
                <code id="endpoint">https://helpdesk.ca/ip-api/api/v1.php?key=YOUR_API_KEY</code>
                <button class="btn btn-sm btn-outline-secondary copy-btn" onclick="copyEndpoint()">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- User Data Section (Commented Out) -->
    <!--
    <section class="py-5">
        <div class="container">
            <h2 class="mb-4">Your Geolocation and Weather Data</h2>
            <table class="table table-bordered">
                <tr><th>IP</th><td><?= htmlspecialchars($ip) ?></td></tr>
                <tr><th>City</th><td><?= htmlspecialchars($geo['city']) ?></td></tr>
                <tr><th>Region</th><td><?= htmlspecialchars($geo['region']) ?></td></tr>
                <tr><th>Country</th><td><?= htmlspecialchars($geo['country']) ?></td></tr>
                <tr><th>Latitude</th><td><?= htmlspecialchars($geo['latitude']) ?></td></tr>
                <tr><th>Longitude</th><td><?= htmlspecialchars($geo['longitude']) ?></td></tr>
                <tr><th>Timezone</th><td><?= htmlspecialchars($geo['timezone']) ?></td></tr>
                <tr><th>Local Time</th><td><?= htmlspecialchars($date->format('Y-m-d H:i:s')) ?></td></tr>
                <tr><th>Temperature</th><td><?= htmlspecialchars($weather['temperature'] . ' ' . $weather['temperature_unit']) ?></td></tr>
                <tr><th>Humidity</th><td><?= htmlspecialchars($weather['humidity']) ?>%</td></tr>
                <tr><th>Cloudcover</th><td><?= htmlspecialchars($weather['cloudcover']) ?>%</td></tr>
                <tr><th>Windspeed</th><td><?= htmlspecialchars($weather['windspeed'] . ' ' . $weather['windspeed_unit']) ?></td></tr>
                <tr><th>Wind Direction</th><td><?= htmlspecialchars($weather['winddirection'] . ' ' . $weather['winddirection_unit']) ?></td></tr>
                <tr><th>Is Day</th><td><?= htmlspecialchars($weather['is_day'] ? 'Yes' : 'No') ?></td></tr>
                <tr><th>Weather Code</th><td><?= htmlspecialchars($weather['weathercode']) ?></td></tr>
                <tr><th>Pressure</th><td><?= htmlspecialchars($weather['pressure'] . ' ' . $weather['pressure_unit']) ?></td></tr>
                <tr><th>Precipitation</th><td><?= htmlspecialchars($weather['precipitation'] . ' ' . $weather['precipitation_unit']) ?></td></tr>
            </table>
        </div>
    </section>
    -->

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; <?= date('Y') ?> IP Geolocation API. All rights reserved.</p>
            <p class="mb-0">MaxMind GeoLite2 Data</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function copyEndpoint() {
            const el = document.createElement('textarea');
            el.value = document.getElementById('endpoint').textContent;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            
            const btn = document.querySelector('.copy-btn');
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
            setTimeout(() => {
                btn.innerHTML = originalHtml;
            }, 2000);
        }
    </script>
</body>
</html>

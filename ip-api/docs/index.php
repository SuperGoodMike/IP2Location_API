<?php
// /srv/www/wordpress/ip-api/docs/index.php
require_once __DIR__ . '/../includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Geolocation API Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/ip-api/docs/">IP Geolocation API</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-body">
                <h1 class="mb-4">IP Geolocation API Documentation</h1>
                
                <div class="mb-5">
                    <h2>API Endpoint</h2>
                    <code>GET /ip-api/api/v1.php?key=API_KEY&ip=IP_ADDRESS</code>
                </div>

                <div class="mb-5">
                    <h3>Authentication</h3>
                    <p>Include your API key in the request:</p>
                    <pre>https://helpdesk.ca/ip-api/api/v1.php?key=YOUR_API_KEY</pre>
                </div>

                <div class="mb-5">
                    <h3>Parameters</h3>
                    <table class="table table-bordered">
                        <tr><th>Parameter</th><th>Required</th><th>Description</th></tr>
                        <tr><td><code>key</code></td><td>Yes</td><td>Your API key</td></tr>
                        <tr><td><code>ip</code></td><td>No</td><td>IP address to lookup (default: client IP)</td></tr>
                    </table>
                </div>

                <div class="mb-5">
                    <h3>Example Request</h3>
                    <pre>GET /ip-api/api/v1.php?key=abc123&ip=8.8.8.8</pre>
                </div>

                <div class="mb-5">
                    <h3>Example Response</h3>
                    <pre>{
  "ip": "8.8.8.8",
  "city": "Mountain View",
  "region": "California",
  "country": "United States",
  "latitude": 37.4056,
  "longitude": -122.0775,
  "timezone": "America/Los_Angeles",
  "local_time": "2023-10-05 14:30:00",
  "temperature": 22.5,
  "humidity": 65
}</pre>
                </div>

                <div class="mb-5">
                    <h3>Rate Limits</h3>
                    <p>100 requests/minute per API key or IP address.</p>
                </div>

                <div class="mb-5">
                    <h3>Admin Panel</h3>
                    <a href="/ip-api/admin/login.php" class="btn btn-primary">Manage API Keys</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

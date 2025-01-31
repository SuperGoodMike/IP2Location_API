<?php
// /srv/www/wordpress/ip-api/index.php
require_once __DIR__ . '/includes/config.php';
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

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 text-center">
                    <i class="fas fa-map-marker-alt feature-icon mb-3"></i>
                    <h4>Geolocation</h4>
                    <p>City, region, country, and GPS coordinates</p>
                </div>
                <div class="col-md-3 text-center">
                    <i class="fas fa-cloud-sun feature-icon mb-3"></i>
                    <h4>Weather Data</h4>
                    <p>Real-time temperature and humidity</p>
                </div>
                <div class="col-md-3 text-center">
                    <i class="fas fa-key feature-icon mb-3"></i>
                    <h4>API Keys</h4>
                    <p>Secure key management system</p>
                </div>
                <div class="col-md-3 text-center">
                    <i class="fas fa-tachometer-alt feature-icon mb-3"></i>
                    <h4>Rate Limiting</h4>
                    <p>100 requests/minute threshold</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Start Section -->
    <section class="bg-light py-5">
        <div class="container text-center">
            <h2 class="mb-4">Get Started in Minutes</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-book me-2"></i>Documentation</h5>
                            <p class="card-text">Full API reference and code examples</p>
                            <a href="docs/" class="btn btn-primary">View Docs</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-user-shield me-2"></i>Admin Panel</h5>
                            <p class="card-text">Manage API keys and access</p>
                            <a href="admin/login.php" class="btn btn-warning">Admin Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

<?php
require_once __DIR__ . '/config.php';
function check_rate_limit($pdo, $api_key, $ip) {
    // Clean up old entries
    $stmt = $pdo->prepare("DELETE FROM rate_limits WHERE timestamp < NOW() - INTERVAL ? SECOND");
    $stmt->execute([RATE_LIMIT_WINDOW]);

    // Get custom rate limit (if set)
    $stmt = $pdo->prepare("SELECT rate_limit FROM apikeys WHERE `key` = ?");
    $stmt->execute([$api_key]);
    $custom_limit = $stmt->fetchColumn();
    $limit = $custom_limit ?: RATE_LIMIT;

    // Count requests for THIS KEY ONLY
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM rate_limits WHERE api_key = ?");
    $stmt->execute([$api_key]);
    $count = $stmt->fetchColumn();

    // Enforce limit
    if ($count >= $limit) {
        http_response_code(429);
        die(json_encode(['error' => "Rate limit exceeded ($limit requests/minute)"]));
    }

    // Log the request
    $stmt = $pdo->prepare("INSERT INTO rate_limits (api_key, ip) VALUES (?, ?)");
    $stmt->execute([$api_key, $ip]);
}
?>

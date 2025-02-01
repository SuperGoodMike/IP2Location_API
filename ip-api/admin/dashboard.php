<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/config.php';

// Add new API key with notes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate'])) {
    $key = bin2hex(random_bytes(16));
    $notes = $_POST['notes'] ?? '';
    $rate_limit = isset($_POST['rate_limit']) ? (int)$_POST['rate_limit'] : null;
    
    $stmt = $pdo->prepare("INSERT INTO apikeys (`key`, notes, rate_limit) VALUES (?, ?, ?)");
    $stmt->execute([$key, $notes, $rate_limit]);
}

// Update existing key
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $key = $_POST['key'];
    $notes = $_POST['notes'] ?? '';
    $rate_limit = isset($_POST['rate_limit']) ? (int)$_POST['rate_limit'] : null;
    
    $stmt = $pdo->prepare("UPDATE apikeys SET notes = ?, rate_limit = ? WHERE `key` = ?");
    $stmt->execute([$notes, $rate_limit, $key]);
}

// Delete API key
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM apikeys WHERE `key` = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: dashboard.php");
    exit();
}

// Fetch all keys with usage data
$stmt = $pdo->query("
    SELECT a.*, COUNT(r.id) as total_requests 
    FROM apikeys a
    LEFT JOIN rate_limits r ON a.key = r.api_key
    GROUP BY a.id
    ORDER BY a.created_at DESC
");
$keys = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get default rate limit from config
$default_rate_limit = RATE_LIMIT;
?>
<!DOCTYPE html>
<html>
<head>
    <title>API Key Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .usage-progress {
            height: 20px;
            width: 200px;
        }
        .navbar-brand {
            margin: 0 auto; /* Center the logo */
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="path/to/logo.png" alt="Logo" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="path/to/docs.html">Docs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="path/to/homepage.html">App Homepage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-body">
                <h1 class="mb-4">API Key Management</h1>
                
                <!-- Key Generation Form -->
                <form method="post" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="notes" class="form-control" 
                                   placeholder="Key description/notes">
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="rate_limit" class="form-control"
                                   placeholder="Custom rate limit (default: <?= $default_rate_limit ?>)">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" name="generate" class="btn btn-success w-100">
                                Generate Key
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Keys Table -->
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>API Key</th>
                                <th>Notes</th>
                                <th>Rate Limit</th>
                                <th>Usage</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($keys as $key): ?>
                            <tr>
                                <td>
                                    <code><?= htmlspecialchars($key['key']) ?></code>
                                </td>
                                <td>
                                    <form method="post" class="d-flex">
                                        <input type="hidden" name="key" value="<?= $key['key'] ?>">
                                        <input type="text" name="notes" class="form-control form-control-sm" 
                                               value="<?= htmlspecialchars($key['notes']) ?>">
                                </td>
                                <td>
                                        <input type="number" name="rate_limit" class="form-control form-control-sm" 
                                               value="<?= $key['rate_limit'] ?>" 
                                               placeholder="<?= $default_rate_limit ?>">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="usage-progress me-2">
                                            <div class="progress h-100">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width: <?= min(($key['total_requests'] / $default_rate_limit) * 100, 100) ?>%">
                                                </div>
                                            </div>
                                        </div>
                                        <?= $key['total_requests'] ?> requests
                                    </div>
                                </td>
                                <td><?= $key['created_at'] ?></td>
                                <td class="d-flex gap-1">
                                        <button type="submit" name="update" 
                                                class="btn btn-sm btn-primary">Update</button>
                                    </form>
                                    <a href="?delete=<?= urlencode($key['key']) ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Delete this key?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

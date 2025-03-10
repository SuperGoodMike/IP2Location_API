<?php
require_once __DIR__ . '/../includes/config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === ADMIN_USER && password_verify($password, ADMIN_PASS_HASH)) {
        session_start();
        $_SESSION['authenticated'] = true;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }
        .login-logo {
            max-width: 300px;
            margin: 0 auto 2rem;
            display: block;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .login-btn {
            background-color: #1a2b57; /* Navy blue from your logo */
            color: white;
            width: 100%;
        }
        .login-btn:hover {
            background-color: #0f1a3b;
            color: white;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <!-- Company Logo -->
                    <img src="https://www.jsdelivr.com/assets/5c68306d8099d6e5688364b5a9d7470ed6735f1d/img/icons/jsdelivr_icon.svg" 
                         alt="Company Logo" 
                         class="login-logo img-fluid">

                    <!-- Login Card -->
                    <div class="card login-card-center">
                        <div class="card-body p-5-center">
                            <h2 class="text-center mb-4">Admin Login</h2>
                            
                            <?php if ($error): ?>
                                <div class="alert alert-danger"><?= $error ?></div>
                            <?php endif; ?>

                            <form method="post">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" 
                                           name="username" 
                                           class="form-control form-control-lg"
                                           required>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label">Password</label>
                                    <input type="password" 
                                           name="password" 
                                           class="form-control form-control-lg"
                                           required>
                                </div>
                                
                                <button type="submit" 
                                        class="btn btn-lg login-btn">
                                    Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
session_start();
require_once 'includes/database.php';
require_once 'includes/auth.php';

$debug_info = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Collect debug info
    $debug_info['login_attempt'] = "Login attempt - Email: " . $email;

    $stmt = $conn->prepare("SELECT password FROM Users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $debug_info['user_found'] = "User found in database";
        $debug_info['stored_hash'] = "Stored hash: " . $user['password'];
        $debug_info['verify_result'] = "Password verification result: " . (password_verify($password, $user['password']) ? 'true' : 'false');
    } else {
        $debug_info['user_found'] = "No user found with email: " . $email;
    }

    if (loginUser($email, $password)) {
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dolphin CRM - Login</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <h3>Welcome to Dolphin CRM</h3>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>

    <?php if (!empty($debug_info)): ?>
    <script>
        console.group('Login Debug Information');
        <?php foreach($debug_info as $key => $value): ?>
        console.log(<?php echo json_encode($value); ?>);
        <?php endforeach; ?>
        console.groupEnd();
    </script>
    <?php endif; ?>
</body>
</html>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'includes/db_connect.php';

$error_message ='';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error_message = "Email and password are required."; 
    } else {
        try {
            $sqlUser = "SELECT * FROM users WHERE email = ?";
            $stmtUser = $pdo->prepare($sqlUser);
            $stmtUser->execute([$email]);
            $user = $stmtUser->fetch();

            if (!$user) {
                $error_message = "No user found with email: " . htmlspecialchars($email);
            } else {

                if (password_verify($password, $user['password'])) {

                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['role']; 

                    error_log(ucfirst($user['role']) . " Login successful: ID {$user['id']}");

                    if ($user['role'] === 'staff') {
                        header("Location: staff/staff_dash.php");
                    } elseif ($user['role'] === 'manager') {
                        header("Location: staff/manager_dash.php");
                    } else {
                        header("Location: index.php");
                    }
                    exit;
                } else {
                    $error_message = "Password is incorrect for user: " . htmlspecialchars($email);
                }
            }
        } catch (PDOException $e) {
            $error_message = "Database error: " . $e->getMessage();
        }
    }
}

require_once 'includes/header.php';
?>

<link href="assets/css/main.css" rel="stylesheet">
<div class="form-container">
    <h2 class="text-center mb-4">Login</h2>

    <?php if ($error_message): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['signup']) && $_GET['signup'] == 'success'): ?>
        <div class="alert alert-success" role="alert">
            Sign up successful Please Login.
        </div>
    <?php endif; ?>
        
    <form action="login.php" method="POST" autocomplete="off">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" value="" autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" value="" autocomplete="new-password" required>
        </div>
        <button type="submit" class="btn w-100">Login</button>
    </form>
    <p class="text-center mt-3">
        Don't have an account? <a href="signup.php">sign up here</a>
    </p>
</div>

<?php
require_once 'includes/footer.php';
?>
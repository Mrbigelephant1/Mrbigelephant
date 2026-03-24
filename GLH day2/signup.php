<?php 
require_once 'includes/db_connect.php';


$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $loyalty_member = isset($_POST['loyalty_member']) ? 1 : 0;

    if (empty($email) || empty($password)) {
        $error_message = "Email and password required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->fetch()) {
                $error_message = "This email address is already registered.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (email, password, loyalty_member) VALUES (?, ?, ?)";
                $stmt = $pdo->prepare($sql);

                if ($stmt->execute([$email, $hashed_password, $loyalty_member])) {
                    header("Location: login.php?signup=success");
                    exit;
                } else {
                    $error_message = "Error: Could not register. Please try again.";
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
    <h2 class="text-center mb-4">Create an Account</h2>

    <?php if ($error_message): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <form action="signup.php" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label>
                <input type="checkbox" name="loyalty_member">
                join Loyalty Program (10% discount on orders)
            </label>
        </div>
        <button type="submit" class="btn w-100">Sign up</button>
    </form>
    <p class="text-center mt-3">
        Already have an account? <a href="login.php">Login here</a>
    </p>
</div> 

<?php
require_once 'includes/footer.php';
?>

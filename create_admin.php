<?php
/*
  Run this script after importing create_thematworks.sql.
  It will create a manager account with a hashed password.
  Access it from the browser (http://localhost/TheMatWorks/database/create_admin.php)
  or run: php database/create_admin.php
*/

require_once __DIR__ . '/../includes/dbconn.php';

$email = 'admin@thematworks.local';
$passwordPlain = 'AdminPass123!';
$hash = password_hash($passwordPlain, PASSWORD_DEFAULT);
$role = 'manager';

try {
  $stmt = $pdo->prepare("INSERT INTO users (email, password, role, loyalty_member) VALUES (?, ?, ?, ?)");
  $stmt->execute([$email, $hash, $role, 0]);
  echo "Admin user created: $email with password $passwordPlain";
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

?>

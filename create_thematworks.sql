-- SQL script to create the `thematworks` database, the `usermgmt` user,
-- and the minimum `users` table expected by the PHP app.

-- 1) Create database
CREATE DATABASE IF NOT EXISTS thematworks
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- 2) Create the DB user used in includes/dbconn.php (adjust password if needed)
CREATE USER IF NOT EXISTS 'usermgmt'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON thematworks.* TO 'usermgmt'@'localhost';
FLUSH PRIVILEGES;

-- 3) Switch to the database
USE thematworks;

-- 4) Create users table required by login.php / signup.php
CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  loyalty_member TINYINT(1) NOT NULL DEFAULT 0,
  role ENUM('customer','staff','manager') NOT NULL DEFAULT 'customer',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Optional: add other tables later (events, tickets) as needed by your site.

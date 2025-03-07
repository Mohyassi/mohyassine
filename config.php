<?php
session_start();

// Database connection
define('DB_SERVER', '127.0.0.1'); // Corrected to use the correct host
define('DB_USERNAME', 'u414268532_brizzstore12');
define('DB_PASSWORD', 'Sami12@sami12');
define('DB_DATABASE', 'u414268532_onlinestore12');

// Create MySQLi connection
$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Initialize variables
$username = "";
$email = "";
$errors = [];

// REGISTER USER
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reg_user'])) {
    $username = $db->real_escape_string($_POST['username']);
    $email = $db->real_escape_string($_POST['email']);
    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];

    // Form validation
    if (empty($username)) $errors[] = "Username is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($password_1)) $errors[] = "Password is required";
    if ($password_1 !== $password_2) $errors[] = "The two passwords do not match";

    // Check if user exists
    $stmt = $db->prepare("SELECT * FROM register WHERE Name = ? OR email = ? LIMIT 1");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if ($user) {
        if ($user['Name'] === $username) $errors[] = "Username already exists";
        if ($user['email'] === $email) $errors[] = "Email already exists";
    }
    
    // If no errors, proceed with registration
    if (empty($errors)) {
        $password = password_hash($password_1, PASSWORD_BCRYPT); // Secure password hashing
        $stmt = $db->prepare("INSERT INTO register (Name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        $stmt->execute();
        
        $_SESSION['Name'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
        exit();
    }
}

// LOGIN USER
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_user'])) {
    $email = $db->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    if (empty($email)) $errors[] = "Email is required";
    if (empty($password)) $errors[] = "Password is required";
    
    // If no errors, proceed with login
    if (empty($errors)) {
        $stmt = $db->prepare("SELECT * FROM register WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['email'] = $email;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
            exit();
        } else {
            $errors[] = "Wrong email/password combination";
        }
    }
}
?>

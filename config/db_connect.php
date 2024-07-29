<?php
// Function to load .env file into $_ENV
if (!function_exists('loadEnv')) {
    function loadEnv($file) {
        $vars = parse_ini_file($file, true);
        foreach ($vars as $key => $value) {
            $_ENV[$key] = $value;
        }
    }
}
loadEnv(__DIR__ . '/yandere.env');
// Initialize connection to db using environment variables
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$conn = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Your existing code to handle remember me logic and update IDs

// Check for the "Remember Me" cookie and update expiration date if present
if (isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];

    // Query to validate the token and check its expiration
    $query = "SELECT user, id, login_token_expiration FROM bnb WHERE login_token = ? AND login_token_expiration > NOW()";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Restore the session if the token is valid and not already set
        if (!isset($_SESSION['user'])) {
            $_SESSION['user'] = $row['user'];
            $_SESSION['id'] = $row['id'];
        }

        // Extend the expiration date by another 7 days if more than 1 day has passed since last update
        $last_expiry = strtotime($row['login_token_expiration']);
        if (time() > $last_expiry - (86400 * 6)) { // Check if more than 1 day has passed
            $new_expiry = date('Y-m-d H:i:s', time() + (86400 * 7));

            // Update the token expiration in the database
            $update_query = "UPDATE bnb SET login_token_expiration = ? WHERE login_token = ?";
            $update_stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($update_stmt, 'ss', $new_expiry, $token);
            mysqli_stmt_execute($update_stmt);
            mysqli_stmt_close($update_stmt);

            // Update the cookie with the new expiration date
            setcookie('remember_me', $token, time() + (86400 * 7), "/", "", true, true);
        }
    } else {
        // Invalidate the cookie if the token is invalid
        setcookie('remember_me', '', time() - 3600, "/");
    }
    mysqli_stmt_close($stmt);
}

// Existing logic to update IDs in the bnb table
$result = mysqli_query($conn, "SELECT id FROM bnb ORDER BY id");
if ($result) {
    $newId = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $currentId = $row['id'];
        if ($currentId != $newId) {
            mysqli_query($conn, "UPDATE bnb SET id = $newId WHERE id = $currentId");
        }
        $newId++;
    }
}
mysqli_free_result($result);

$result = mysqli_query($conn, "SELECT ItemId FROM items ORDER BY ItemId");
if ($result) {
    $newId = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $currentId = $row['ItemId'];
        if ($currentId != $newId) {
            mysqli_query($conn, "UPDATE items SET ItemId = $newId WHERE ItemId = $currentId");
        }
        $newId++;
    }
}
mysqli_free_result($result);
?>

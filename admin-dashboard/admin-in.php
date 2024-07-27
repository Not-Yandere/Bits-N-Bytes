<?php include 'valide-admin-in.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <link rel="stylesheet" href="/CSS/log--in.css">
    <link rel="shortcut icon" href="Images/icon.png">
    <title>Admin Login</title>
</head>  
<body>
    <br><br><br><br><br>
    <div class="container">
        <h2>Admin Login</h2>
        <form class="Log-in-form buyer" id="buyer" action="admin-in" method="POST" style="display: block;">
            <label for="mail">Email / Username:</label>
            <input type="text" id="mail" name="mail" placeholder="Email / Username" value="<?php echo htmlspecialchars($email_or_username); ?>">
            <div style="color: red;" id="error-mail">
                <?php echo $errors['mail']; ?>
            </div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Password">
            <div style="color: red;" id="error-password">
                <?php echo $errors['password']; ?>
            </div>
            <br>
            <button type="submit" name="submit">Log In</button>
        </form>
    </div>
</body>
</html>

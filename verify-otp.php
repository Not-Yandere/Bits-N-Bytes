<?php
session_start();

// Check if the required session variables are set
if (!isset($_SESSION['user1']) || !isset($_SESSION['email1']) || !isset($_SESSION['password1']) || !isset($_SESSION['otp'])) {
    // Redirect to the signup page if session variables are not set
    header('Location: /sign-up');
    exit();
}

$otp = '';
$errors = array('otp' => '');
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Combine OTP input fields into a single OTP string
    $otp_input = '';
    foreach ($_POST['otp'] as $otp_part) {
        $otp_input .= $otp_part;
    }

    // Server-side honeypot check
    if (!empty($_POST['honeypot'])) {
        exit('No bots allowed!');
    } else {
        if (empty(trim(htmlspecialchars($otp_input)))) {
            $errors['otp'] = "OTP is required";
        } else {
            $otp = trim(htmlspecialchars($otp_input));
            if ($otp != $_SESSION['otp']) {
                $errors['otp'] = "Invalid OTP";
            } else {
                include('config/db_connect.php');
                $user = mysqli_real_escape_string($conn, $_SESSION['user1']);
                $email = mysqli_real_escape_string($conn, $_SESSION['email1']);
                $password = password_hash(mysqli_real_escape_string($conn, $_SESSION['password1']), PASSWORD_DEFAULT);

                if (mysqli_query($conn, "INSERT INTO bnb(user, mail, password) VALUES('$user', '$email', '$password')")) {
                    $successMessage = 'Account created successfully!';
                    session_destroy();
                    echo '<script>
                    setTimeout(function() {
                        window.location.href = "/log-in";
                    }, 2500);
                    </script>';
                } else {
                    $errors['otp'] = 'Failed to create account. Please try again.';
                }
                mysqli_close($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <link rel="stylesheet" href="CSS/log--in.css">
    <link rel="shortcut icon" href="Images/icon.png">
    <title>Verify OTP</title>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const inputs = document.querySelectorAll('.otp-input');

            function validateForm() {
                var honeypot = document.getElementById("honeypot").value;
                if (honeypot) {
                    // Bot detected, do not submit form
                    return false;
                }
                return true;
            }

            inputs.forEach((input, index) => {
                input.addEventListener('input', () => {
                    if (input.value.length === 1) {
                        if (index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        } else {
                            checkAndSubmit();
                        }
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && input.value === '') {
                        if (index > 0) {
                            inputs[index - 1].focus();
                        }
                    }
                });

                input.addEventListener('paste', (e) => {
                    const pasteData = e.clipboardData.getData('text').split('');
                    inputs.forEach((input, idx) => {
                        input.value = pasteData[idx] ? pasteData[idx] : '';
                    });
                    e.preventDefault();
                    checkAndSubmit();
                });
            });

            function checkAndSubmit() {
                const allFilled = [...inputs].every(input => input.value.length === 1);
                if (allFilled) {
                    document.getElementById('otp-form').submit();
                }
            }
        });
    </script>
</head>
<body>
    <h1><a href="/">Bits N Bytes</a></h1>
    <div class="container">
        <h2>OTP Verification</h2>
        <?php if ($successMessage): ?>
        <!-- box to echo success message in emerald colored box -->
        <div class="successMessage" >
        &#10003; <?php echo $successMessage; ?>
        </div>
        <?php endif; ?>
        <p>One Time Password (OTP) has been sent via Email to <b><?php echo htmlspecialchars($_SESSION['email1']); ?></b>.</p>
        <p>Enter the OTP below to verify it.</p>
        <form id="otp-form" action="/verify-otp" method="POST" onsubmit="return validateForm();">
            <div class="otp-container">
                <input type="text" name="otp[]" maxlength="1" class="otp-input" style="text-align: center;">
                <input type="text" name="otp[]" maxlength="1" class="otp-input" style="text-align: center;">
                <input type="text" name="otp[]" maxlength="1" class="otp-input" style="text-align: center;">
                <input type="text" name="otp[]" maxlength="1" class="otp-input" style="text-align: center;">
                <input type="text" name="otp[]" maxlength="1" class="otp-input" style="text-align: center;">
                <input type="text" name="otp[]" maxlength="1" class="otp-input" style="text-align: center;">
            </div>
            <div style="color: red;">
                <?php echo $errors['otp']; ?>
            </div>
            <!-- Client-side honeypot field (hidden from users) -->
            <input type="text" id="honeypot" name="honeypot" style="display:none;">
            <br>
            <button type="submit" style="display:none;">Verify</button>
        </form>
    </div>
</body>
</html>

<?php
include('config/db_connect.php');

// Fetch user details
$user_id = $_SESSION['id'];
$query = "SELECT * FROM bnb WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$query = "SELECT * FROM user_details WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_details = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <title>Profile</title>
    <link rel="stylesheet" href="CSS/amazon.css">
    <link rel="stylesheet" href="CSS/profile.css">
    <script src="profile.js" defer></script>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Profile</h1>
        <br>
        <!-- Email Update Section -->
        <div class="profile-section">
            <form id="email-form-unique" onsubmit="event.preventDefault(); validateAndSendOTPUnique();">
                <h3>Update Email</h3>
                <label for="email">Email:</label>
                <input type="email" id="email-unique" name="email" value="<?php echo htmlspecialchars(isset($user['mail']) ? $user['mail'] : ''); ?>" data-current-email="<?php echo htmlspecialchars(isset($user['mail']) ? $user['mail'] : ''); ?>" required>
                <button type="submit" id="update-email-button-unique">Update Email</button>
            </form>
        </div>

        <!-- Password Update Section -->
        <div class="profile-section">
            <h3>Update Password</h3>
            <button onclick="openPasswordPopupUnique()">Change Password</button>
        </div>

        <!-- User Details Section -->
        <div class="profile-section">
            <form id="user-details-form-unique" onsubmit="return validateProfileFormUnique()">
                <h3>User Details</h3>
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name_unique" name="full_name" value="<?php echo htmlspecialchars(isset($user_details['full_name']) ? $user_details['full_name'] : ''); ?>" required>
                <div id="error-full_name-unique" class="unique-error-message" style="display: none;"></div>

                <label for="country">Country:</label>
                <select id="country_unique" name="country">
                    <option value="">Select Country</option>
                    <option value="Egypt" <?php echo isset($user_details['country']) && $user_details['country'] == 'Egypt' ? 'selected' : ''; ?>>Egypt</option>
                    <!-- Add more countries here if needed -->
                </select>
                <div id="error-country-unique" class="unique-error-message" style="display: none;"></div>

                <label for="city">City:</label>
                <select id="city_unique" name="city">
                    <option value="">Select City</option>
                    <!-- Cities will be populated here based on selected country -->
                </select>
                <div id="error-city-unique" class="unique-error-message" style="display: none;"></div>

                <label for="address">Address:</label>
                <input type="text" id="address_unique" name="address" value="<?php echo htmlspecialchars(isset($user_details['address']) ? $user_details['address'] : ''); ?>" required>
                <div id="error-address-unique" class="unique-error-message" style="display: none;"></div>

                <label for="zip_code">ZIP Code:</label>
                <input type="text" id="zip_code_unique" name="zip_code" value="<?php echo htmlspecialchars(isset($user_details['zip_code']) ? $user_details['zip_code'] : ''); ?>" required>
                <div id="error-zip_code-unique" class="unique-error-message" style="display: none;"></div>

                <label for="phone">Phone:</label>
                <input type="text" id="phone_unique" name="phone" value="<?php echo htmlspecialchars(isset($user_details['phone']) ? $user_details['phone'] : ''); ?>" required>
                <div id="error-phone-unique" class="unique-error-message" style="display: none;"></div>

                <button type="submit" id="update-details-button-unique">Update Details</button>
            </form>
        </div>

        <!-- Order History Section -->
        <div class="profile-section">
            <h3>Order History</h3>
            <button onclick="window.location.href='/orders'">View Order History</button>
        </div>

        <!-- Password Change Popup -->
        <div id="changePasswordPopupUnique" class="modal">
            <div class="popup-content">
                <span class="close-button" onclick="closePasswordPopupUnique()">&times;</span>
                <h2>Change Password</h2>
                <form id="changePasswordFormUnique" method="POST" onsubmit="return validatePasswordChangeUnique()">
                    <label for="current-password-popup-unique">Current Password:</label>
                    <input type="password" id="current-password-popup-unique" name="currentPassword" required>
                    <label for="new-password-popup-unique">New Password:</label>
                    <input type="password" id="new-password-popup-unique" name="newPassword" required>
                    <label for="confirm-password-popup-unique">Confirm Password:</label>
                    <input type="password" id="confirm-password-popup-unique" name="confirmPassword" required>
                    <span id="password-error-unique" style="color: red;"></span>
                    <button type="submit">Update Password</button>
                </form>
            </div>
        </div>

        <!-- OTP Verification Popup -->
        <div id="otpPopupUnique" class="modal">
            <div class="popup-content">
                <span class="close-button" onclick="closeOTPPopupUnique()">&times;</span>
                <h2>Verify OTP</h2>
                <p>Enter the OTP sent to your email</p>
                <br>
                <div class="otp-container">
                    <input type="tel" class="otp-input-unique" maxlength="1" pattern="\d*" required>
                    <input type="tel" class="otp-input-unique" maxlength="1" pattern="\d*" required>
                    <input type="tel" class="otp-input-unique" maxlength="1" pattern="\d*" required>
                    <input type="tel" class="otp-input-unique" maxlength="1" pattern="\d*" required>
                    <input type="tel" class="otp-input-unique" maxlength="1" pattern="\d*" required>
                    <input type="tel" class="otp-input-unique" maxlength="1" pattern="\d*" required>
                </div>
                <button onclick="validateOTPUnique()">Verify OTP</button>
            </div>
        </div>

        <!-- Success and Failure Messages -->
        <div id="successMessageUnique" class="success-message" style="display: none;">
            <div class="checkmark-wrapper">
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
            </div>
            <p>Profile Updated Successfully!</p>
        </div>

        <div id="failureMessageUnique" class="failure-message" style="display: none;">
            <div class="cross-wrapper">
                <svg class="cross" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="cross-circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="cross-check" fill="none" d="M16 16 36 36 M36 16 16 36"/>
                </svg>
            </div>
            <p id="failureTextUnique">An error occurred!</p>
            <button id="failureOkButtonUnique" onclick="window.closeFailureMessageUnique()">OK</button>
        </div>
    </div>
</body>
</html>

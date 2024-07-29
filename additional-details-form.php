<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Start the session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $errors = array('full_name' => '', 'country' => '', 'address' => '', 'city' => '', 'zip_code' => '', 'phone' => '');

    $user_id = $_SESSION['id'];
    $full_name = htmlspecialchars(trim($_POST["full_name"]));
    $country = htmlspecialchars($_POST["country"]);
    $city = htmlspecialchars($_POST["city"]);
    $address = htmlspecialchars(trim($_POST["address"]));
    $zip_code = htmlspecialchars(trim($_POST["zip_code"]));
    $phone = htmlspecialchars(trim($_POST["phone"]));

    // Validation
    if (empty($full_name) || !preg_match("/^[a-zA-Z\s]{2,50}$/", $full_name)) {
        $errors['full_name'] = "Please enter a valid full name.";
    }
    if (empty($country)) {
        $errors['country'] = "Please select a country.";
    }
    if (empty($city)) {
        $errors['city'] = "Please select a city.";
    }
    if (empty($address) || !preg_match("/^[a-zA-Z0-9\s,'.-]+$/", $address)) {
        $errors['address'] = "Please enter a valid address.";
    }
    if (empty($zip_code) || !preg_match("/^[0-9]{5}$/", $zip_code)) {
        $errors['zip_code'] = "Please enter a valid zip code.";
    }
    if (empty($phone) || !preg_match("/^01[0-2]\d{8}$/", $phone)) {
        $errors['phone'] = "Please enter a valid phone number.";
    }

    if (!array_filter($errors)) {
        include 'config/db_connect.php'; // Ensure db_connect.php is included here

        $stmt = $conn->prepare("INSERT INTO user_details (user_id, full_name, country, address, city, zip_code, phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $user_id, $full_name, $country, $address, $city, $zip_code, $phone);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save details.']);
            exit();
        }
    } else {
        echo json_encode(['status' => 'error', 'errors' => $errors]);
        exit();
    }
}
?>

<div id="profilePopup" style="display: none;">
    <div class="popup-content">
        <h2>Complete Your Profile</h2>
        <form id="profileForm" onsubmit="return validateProfileForm()">
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name">
            <div id="error-full_name" class="error-message"></div>

            <label for="country">Country:</label>
            <select id="country" name="country" onchange="populateCities()">
                <option value="" disabled selected>Sorry, we only ship inside Egypt right now</option>
                <option value="Egypt">Egypt</option>
            </select>
            <div id="error-country" class="error-message"></div>

            <label for="city">City:</label>
            <select id="city" name="city">
                <option value="">Select City</option>
                <!-- Cities will be populated here based on selected country -->
            </select>
            <div id="error-city" class="error-message"></div>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address">
            <div id="error-address" class="error-message"></div>

            <label for="zip_code">Zip Code:</label>
            <input type="text" id="zip_code" name="zip_code">
            <div id="error-zip_code" class="error-message"></div>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone">
            <div id="error-phone" class="error-message"></div>

            <button type="submit">Save Details</button>
        </form>
    </div>
</div>

<div id="successMessage" class="success-message" style="display: none;">
    <div class="checkmark-wrapper">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
            <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
        </svg>
    </div>
    <p>Profile Updated Successfully!</p>
</div>

<script>
let data = {
    "Egypt": {
        "cities": ["Cairo", "Alexandria", "Giza", "Damietta", "Port Said"],
        "zipRegex": "^[0-9]{5}$"
    }
};

document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        checkUserDetails();
    }, 10000);
});

function populateCities() {
    const citySelect = document.getElementById('city');
    const countrySelect = document.getElementById('country');
    const selectedCountry = countrySelect.value;

    citySelect.innerHTML = '<option value="">Select City</option>'; // Reset cities

    if (selectedCountry && data[selectedCountry]) {
        data[selectedCountry].cities.forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            option.textContent = city;
            citySelect.appendChild(option);
        });
    }
}

function validateProfileForm() {
    let isValid = true;
    const fullName = document.getElementById("full_name").value.trim();
    const country = document.getElementById("country").value;
    const city = document.getElementById("city").value;
    const address = document.getElementById("address").value.trim();
    const zipCode = document.getElementById("zip_code").value.trim();
    const phone = document.getElementById("phone").value.trim();

    const fullNameError = document.getElementById("error-full_name");
    const countryError = document.getElementById("error-country");
    const cityError = document.getElementById("error-city");
    const addressError = document.getElementById("error-address");
    const zipCodeError = document.getElementById("error-zip_code");
    const phoneError = document.getElementById("error-phone");

    fullNameError.style.display = "none";
    countryError.style.display = "none";
    cityError.style.display = "none";
    addressError.style.display = "none";
    zipCodeError.style.display = "none";
    phoneError.style.display = "none";

    if (fullName === "" || !/^[a-zA-Z\s]{2,50}$/.test(fullName)) {
        fullNameError.textContent = "Please enter a valid full name.";
        fullNameError.style.display = "block";
        isValid = false;
    }

    if (country === "") {
        countryError.textContent = "Please select a country.";
        countryError.style.display = "block";
        isValid = false;
    }

    if (city === "") {
        cityError.textContent = "Please select a city.";
        cityError.style.display = "block";
        isValid = false;
    }

    if (address === "" || !/^[a-zA-Z0-9\s,'.-]+$/.test(address)) {
        addressError.textContent = "Please enter a valid address.";
        addressError.style.display = "block";
        isValid = false;
    }

    const selectedCountryData = data[country];
    if (selectedCountryData && !new RegExp(selectedCountryData.zipRegex).test(zipCode)) {
        zipCodeError.textContent = "Please enter a valid zip code.";
        zipCodeError.style.display = "block";
        isValid = false;
    }

    if (!/^01[0-2]\d{8}$/.test(phone)) {
        phoneError.textContent = "Please enter a valid phone number.";
        phoneError.style.display = "block";
        isValid = false;
    }

    if (isValid) {
        const formData = new FormData(document.getElementById('profileForm'));
        fetch('/additional-details-form.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('profilePopup').style.display = 'none';
                showSuccessMessage();
            } else {
                if (data.errors) {
                    for (const key in data.errors) {
                        const errorElement = document.getElementById(`error-${key}`);
                        errorElement.textContent = data.errors[key];
                        errorElement.style.display = "block";
                    }
                } else {
                    alert(data.message);
                }
            }
        })
    }

    return false; // Prevent form submission
}

function checkUserDetails() {
    fetch('/check-user-details.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'incomplete') {
                document.getElementById('profilePopup').style.display = 'flex';
            }
        })
}

function showSuccessMessage() {
    const successMessage = document.getElementById('successMessage');
    successMessage.style.display = 'flex';
    setTimeout(() => {
        successMessage.style.display = 'none';
    }, 3000);
}
</script>

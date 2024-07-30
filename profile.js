document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email-unique');
    const updateEmailButton = document.getElementById('update-email-button-unique');
    const otpInputs = document.querySelectorAll('.otp-input-unique');
    const countrySelect = document.getElementById('country_unique');
    const citySelect = document.getElementById('city_unique');

    const data = {
        "Egypt": {
            "cities": ["Cairo", "Alexandria", "Giza", "Damietta", "Port Said"],
            "zipRegex": "^[0-9]{5}$"
        }
        // Add more countries and cities here if needed
    };

    function populateCities() {
        const selectedCountry = countrySelect.value;
        citySelect.innerHTML = '<option value="">Select City</option>'; // Reset cities

        if (selectedCountry && data[selectedCountry]) {
            const cities = data[selectedCountry].cities;
            cities.forEach(function(city) {
                const option = document.createElement('option');
                option.value = city;
                option.textContent = city;
                citySelect.appendChild(option);
            });
        }
    }

    // Event listener for country change
    countrySelect.addEventListener('change', populateCities);

    // Call populateCities on page load if a country is already selected
    if (countrySelect.value) {
        populateCities();
    }

    // Open the OTP popup
    window.openOTPPopupUnique = function() {
        document.getElementById('otpPopupUnique').style.display = 'flex';
    }

    // Close the OTP popup and unset session values
    window.closeOTPPopupUnique = function() {
        document.getElementById('otpPopupUnique').style.display = 'none';
        fetch('unset-otp-session.php', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'success') {
                console.error('Failed to unset OTP session values.');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Validate and Send OTP Request
    window.validateAndSendOTPUnique = function() {
        const email = emailInput.value;
        const currentEmail = emailInput.dataset.currentEmail;

        if (email === currentEmail) {
            showFailureMessageUnique('New email cannot be the same as the old email.');
            return false;
        }

        // Send OTP request
        fetch('send-otp.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                openOTPPopupUnique();
            } else {
                showFailureMessageUnique(data.message);
            }
        })
        .catch(error => showFailureMessageUnique('An error occurred while sending OTP. Please try again.'));

        return false;
    }

    // Validate OTP
    window.validateOTPUnique = function() {
        const otp = Array.from(document.getElementsByClassName('otp-input-unique'))
            .map(input => input.value)
            .join('');

        fetch('verify-otp-change.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ otp: otp })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showSuccessMessageUnique('Email updated successfully.');
                closeOTPPopupUnique();
                setTimeout(() => location.reload(), 3000);
            } else {
                showFailureMessageUnique('Invalid OTP. Please try again.');
            }
        })
        .catch(error => showFailureMessageUnique('An error occurred while verifying OTP. Please try again.'));
    }

    // Open Password Change Popup
    window.openPasswordPopupUnique = function() {
        document.getElementById('changePasswordPopupUnique').style.display = 'flex';
    }

    // Close Password Change Popup
    window.closePasswordPopupUnique = function() {
        document.getElementById('changePasswordPopupUnique').style.display = 'none';
    }

    // Validate Password Change
    window.validatePasswordChangeUnique = function() {
        const currentPassword = document.getElementById('current-password-popup-unique').value;
        const newPassword = document.getElementById('new-password-popup-unique').value;
        const confirmPassword = document.getElementById('confirm-password-popup-unique').value;
        const passwordPattern = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/;

        if (!newPassword.match(passwordPattern)) {
            const passwordError = document.getElementById('password-error-unique');
            passwordError.innerHTML = "Password must meet the requirements.";
            passwordError.style.display = "block";
            return false;
        }

        if (newPassword !== confirmPassword) {
            const passwordError = document.getElementById('password-error-unique');
            passwordError.innerHTML = "Passwords do not match.";
            passwordError.style.display = "block";
            return false;
        }

        // Send AJAX request to update the password
        fetch('update-password.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                current_password: currentPassword,
                new_password: newPassword
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showSuccessMessageUnique('Password updated successfully.');
                closePasswordPopupUnique();
            } else {
                showFailureMessageUnique(data.message);
            }
        })
        .catch(error => showFailureMessageUnique('An error occurred while updating password. Please try again.'));

        return false;
    }

    // Disable the update button if the new email is the same as the current email
    emailInput.addEventListener('input', () => {
        if (emailInput.value === emailInput.dataset.currentEmail) {
            updateEmailButton.disabled = true;
            updateEmailButton.style.cursor = 'not-allowed';
        } else {
            updateEmailButton.disabled = false;
            updateEmailButton.style.cursor = 'pointer';
        }
    });

    // Initial check to disable the button if the input is already the same as the current email
    if (emailInput.value === emailInput.dataset.currentEmail) {
        updateEmailButton.disabled = true;
        updateEmailButton.style.cursor = 'not-allowed';
    }

    // OTP Input handling
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            input.value = input.value.replace(/[^0-9]/g, ''); // Allow only numbers
            if (input.value.length === 1) {
                if (index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                } else {
                    checkAndSubmitUnique();
                }
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && input.value === '') {
                if (index > 0) {
                    otpInputs[index - 1].focus();
                }
            }
        });

        input.addEventListener('paste', (e) => {
            const pasteData = e.clipboardData.getData('text').split('');
            otpInputs.forEach((input, idx) => {
                input.value = pasteData[idx] ? pasteData[idx].replace(/[^0-9]/g, '') : '';
            });
            e.preventDefault();
            checkAndSubmitUnique();
        });
    });

    function checkAndSubmitUnique() {
        const allFilled = [...otpInputs].every(input => input.value.length === 1);
        if (allFilled) {
            validateOTPUnique();
        }
    }

    // Validate Profile Form
    window.validateProfileFormUnique = function() {
        let isValid = true;
        const fullName = document.getElementById("full_name_unique").value.trim();
        const country = document.getElementById("country_unique").value;
        const city = document.getElementById("city_unique").value;
        const address = document.getElementById("address_unique").value.trim();
        const zipCode = document.getElementById("zip_code_unique").value.trim();
        const phone = document.getElementById("phone_unique").value.trim();

        const fullNameError = document.getElementById("error-full_name-unique");
        const countryError = document.getElementById("error-country-unique");
        const cityError = document.getElementById("error-city-unique");
        const addressError = document.getElementById("error-address-unique");
        const zipCodeError = document.getElementById("error-zip_code-unique");
        const phoneError = document.getElementById("error-phone-unique");

        // Reset error messages
        fullNameError.style.display = "none";
        countryError.style.display = "none";
        cityError.style.display = "none";
        addressError.style.display = "none";
        zipCodeError.style.display = "none";
        phoneError.style.display = "none";

        if (fullName === "" || !/^[a-zA-Z\s]{2,50}$/.test(fullName)) {
            fullNameError.innerHTML = "Please enter a valid full name.";
            fullNameError.style.display = "block";
            isValid = false;
        }

        if (country === "") {
            countryError.innerHTML = "Please select a country.";
            countryError.style.display = "block";
            isValid = false;
        }

        if (city === "") {
            cityError.innerHTML = "Please select a city.";
            cityError.style.display = "block";
            isValid = false;
        }

        if (address === "" || !/^[a-zA-Z0-9\s,'.-]+$/.test(address)) {
            addressError.innerHTML = "Please enter a valid address.";
            addressError.style.display = "block";
            isValid = false;
        }

        const selectedCountryData = data[country];
        if (selectedCountryData && !new RegExp(selectedCountryData.zipRegex).test(zipCode)) {
            zipCodeError.innerHTML = "Please enter a valid zip code.";
            zipCodeError.style.display = "block";
            isValid = false;
        }

        if (!/^01[0-2]\d{8}$/.test(phone)) {
            phoneError.innerHTML = "Please enter a valid phone number.";
            phoneError.style.display = "block";
            isValid = false;
        }

        if (!isValid) {
            return false; // Prevent form submission
        }

        const formData = new FormData(document.getElementById('user-details-form-unique'));
        fetch('update-user-details.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showSuccessMessageUnique('Details updated successfully.');
            } else {
                showFailureMessageUnique(data.message);
            }
        })
        .catch(error => showFailureMessageUnique('An error occurred while updating details. Please try again.'));

        return false; // Prevent form submission
    }

    // Success Message Display
    function showSuccessMessageUnique(message) {
        const successMessage = document.getElementById('successMessageUnique');
        successMessage.querySelector('p').textContent = message;
        successMessage.style.display = 'flex';
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 3000);
    }

    // Failure Message Display
    function showFailureMessageUnique(message) {
        const failureMessage = document.getElementById('failureMessageUnique');
        failureMessage.querySelector('p').textContent = message;
        failureMessage.style.display = 'flex';
    }

    // Close Failure Message
    window.closeFailureMessageUnique = function() {
        const failureMessage = document.getElementById('failureMessageUnique');
        failureMessage.style.display = 'none';
    }
});

<?php
include('../config/db_connect.php');

// Redirect to 404 if not logged in
if (!isset($_SESSION['admin-name']) || !isset($_SESSION['admin-id'])) {
    header('Location: /404');
    exit;
}

$message = '';

// Handle form submission for adding new items
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-item'])) {
    // Validate and sanitize inputs
    $productName = mysqli_real_escape_string($conn, trim($_POST['ProductName']));
    $description = mysqli_real_escape_string($conn, trim($_POST['Description']));
    $price = mysqli_real_escape_string($conn, str_replace(',', '', trim($_POST['Price'])));
    $category = mysqli_real_escape_string($conn, trim($_POST['Category']));
    $quantity = (int)$_POST['Quantity'];

    // Validate that none of the fields are empty and price is a valid number
    if (empty($productName) || empty($description) || empty($price) || empty($category) || $quantity <= 0 || !is_numeric($price)) {
        $message = 'All fields are required and must be valid.';
    } else {
        // Format price with 'EGP' and commas
        $price = 'EGP' . number_format($price);

        // Handle file upload
        if (isset($_FILES['Pic']) && $_FILES['Pic']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['Pic']['tmp_name'];
            $fileName = $_FILES['Pic']['name'];
            $fileSize = $_FILES['Pic']['size'];
            $fileType = $_FILES['Pic']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $allowedfileExtensions = ['jpg', 'jpeg', 'gif', 'png', 'webp'];
            if (in_array($fileExtension, $allowedfileExtensions) && $fileSize <= 5242880) {
                // Create a unique name for the file
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $uploadFileDir = '/products/' . $category . '/';
                $dest_path = $_SERVER['DOCUMENT_ROOT'] . $uploadFileDir . $newFileName;

                // Check if the upload directory exists, create if not, and set permissions
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $uploadFileDir)) {
                    mkdir($_SERVER['DOCUMENT_ROOT'] . $uploadFileDir, 0777, true);
                }

                // Check if the directory is writable
                if (is_writable($_SERVER['DOCUMENT_ROOT'] . $uploadFileDir)) {
                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $pic = $uploadFileDir . $newFileName;
                    } else {
                        $pic = '';
                        $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                    }
                } else {
                    $message = 'Upload directory is not writable.';
                }
            } else {
                $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions) . '. Maximum size: 5MB.';
            }
        }

        // SQL query to insert new item
        if ($message === '') {
            $insertQuery = "INSERT INTO items (ProductName, Description, Price, Pic, Category, Quantity) 
                            VALUES ('$productName', '$description', '$price', '$pic', '$category', '$quantity')";
            if (mysqli_query($conn, $insertQuery)) {
                // Redirect to dashboard after adding the item
                header("Location: /dashboard");
                exit;
            } else {
                $message = 'Error inserting the item into the database.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Item</title>
    <link rel="stylesheet" href="/CSS/dashboard.css"> <!-- Include your dashboard CSS file here -->
    <script>
        // Client-side validation to ensure all fields are filled out
        function validateForm() {
            const productName = document.getElementById('ProductName').value.trim();
            const description = document.getElementById('Description').value.trim();
            const price = document.getElementById('Price').value.trim();
            const category = document.getElementById('Category').value.trim();
            const quantity = document.getElementById('Quantity').value;

            if (!productName || !description || !price || !category || quantity <= 0) {
                alert('All fields are required and must be valid.');
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <h1>Add New Item</h1>
    <form action="/add-item" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label for="ProductName">Product Name:</label>
        <input type="text" id="ProductName" name="ProductName" required>
        <label for="Description">Description:</label>
        <textarea id="Description" name="Description" required></textarea>
        <label for="Price">Price:</label>
        <input type="number" id="Price" name="Price" step="0.01" required>
        <label for="Pic">Picture (Max size: 5MB):</label>
        <input type="file" id="Pic" name="Pic" required>
        <?php if ($message !== '') { echo '<div class="error-message">' . htmlspecialchars($message) . '</div>'; } ?>
        <label for="Category">Category:</label>
        <select id="Category" name="Category" required>
            <option value="Accessories">Accessories</option>
            <option value="Consoles">Consoles</option>
            <option value="Hardware">Hardware</option>
            <option value="Laptops">Laptops</option>
            <option value="Mobile_Phones">Mobile Phones</option>
            <option value="Monitors">Monitors</option>
            <option value="Video_Games">Video Games</option>
        </select>
        <label for="Quantity">Quantity:</label>
        <input type="number" id="Quantity" name="Quantity" required>
        <button type="submit" name="add-item">Add Item</button>
        <a href="/dashboard" class="cancel-button">Cancel</a>
    </form>
</body>
</html>

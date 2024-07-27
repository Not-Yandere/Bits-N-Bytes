<?php
include('../config/db_connect.php');

// Redirect to 404 if not logged in
if (!isset($_SESSION['admin-name']) || !isset($_SESSION['admin-id'])) {
    header('Location: /404');
    exit;
}

$message = '';
$pic = '';

$id = (int)$_GET['id'];

// Fetch item details for editing
$query = "SELECT * FROM items WHERE ItemId = $id";
$result = mysqli_query($conn, $query);
$item = mysqli_fetch_assoc($result);

// Function to determine the base category
function getBaseCategory($category) {
    $keywords = ['new-', 'hot-', 'New-', 'Hot-', 'NEW-', 'HOT-', '-new', '-hot', '-New', '-Hot', '-NEW', '-HOT'];
    foreach ($keywords as $keyword) {
        if (stripos($category, $keyword) === 0) {
            return substr($category, strlen($keyword));
        }
        if (stripos($category, $keyword) === (strlen($category) - strlen($keyword))) {
            return substr($category, 0, strlen($category) - strlen($keyword));
        }
    }
    return $category;
}

// Handle form submission for updating item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-item'])) {
    $id = (int)$_POST['ItemId'];
    $productName = mysqli_real_escape_string($conn, $_POST['ProductName']);
    $description = mysqli_real_escape_string($conn, $_POST['Description']);
    $price = mysqli_real_escape_string($conn, str_replace(',', '', $_POST['Price']));
    $quantity = (int)$_POST['Quantity'];

    // Validate that price is a valid number
    if (!is_numeric($price)) {
        $message = 'Price must be a valid number.';
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
                // Delete the old picture
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $item['Pic'])) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . $item['Pic']);
                }

                // Get the base category
                $baseCategory = getBaseCategory($item['Category']);

                // Create a unique name for the file
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $uploadFileDir = '/products/' . $baseCategory . '/';
                $dest_path = $_SERVER['DOCUMENT_ROOT'] . $uploadFileDir . $newFileName;

                // Check if the upload directory exists and is writable
                if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $uploadFileDir) || !is_writable($_SERVER['DOCUMENT_ROOT'] . $uploadFileDir)) {
                    $message = 'Upload directory does not exist or is not writable.';
                } elseif (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $pic = $uploadFileDir . $newFileName;
                } else {
                    $pic = $item['Pic'];
                    $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                }
            } else {
                $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions) . '. Maximum size: 5MB.';
            }
        } else {
            $pic = $item['Pic'];
        }

        // SQL query to update item
        $updateQuery = "UPDATE items SET ProductName = '$productName', Description = '$description', Price = '$price', Pic = '$pic', Quantity = '$quantity' WHERE ItemId = $id";
        if ($message === '') {
            mysqli_query($conn, $updateQuery);
            header("Location: /dashboard");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <link rel="stylesheet" href="/CSS/dashboard.css">
</head>
<body>
    <?php if (!$item) { ?>
        <div class="empty"><br><br>
            <h1>This Item Doesn't Exist</h1>
            <br><br>
            <a href="/dashboard">Go Back to Dashboard</a>
        </div>
    <?php } else { ?>
        <h1>Edit Item</h1>
        <form action="/edit-item/<?php echo htmlspecialchars($item['ItemId']); ?>" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="ItemId" value="<?php echo htmlspecialchars($item['ItemId']); ?>">
            <label for="ProductName">Product Name:</label>
            <input type="text" id="ProductName" name="ProductName" value="<?php echo htmlspecialchars($item['ProductName']); ?>" required>
            <label for="Description">Description:</label>
            <textarea id="Description" name="Description" required><?php echo htmlspecialchars($item['Description']); ?></textarea>
            <label for="Price">Price:</label>
            <input type="number" id="Price" name="Price" value="<?php echo str_replace(['EGP', ','], '', htmlspecialchars($item['Price'])); ?>" step="0.01" required>
            <label for="Pic">Upload New Picture (Max size: 5MB):</label>
            <input type="file" id="Pic" name="Pic">
            <label for="Quantity">Quantity:</label>
            <input type="number" id="Quantity" name="Quantity" value="<?php echo htmlspecialchars($item['Quantity']); ?>" required>
             <?php if ($message !== '') { echo '<div class="error-message">' . htmlspecialchars($message) . '</div>'; } ?>
            <button type="submit" name="update-item">Update Item</button>
            <a href="/dashboard" class="cancel-button">Cancel</a>
        </form>
    <?php } ?>
</body>
</html>

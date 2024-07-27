<?php
include('../config/db_connect.php');

// Redirect to 404 if not logged in
if (!isset($_SESSION['admin-name']) || !isset($_SESSION['admin-id'])) {
    header('Location: /404');
    exit;
}

// Handle item deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-item'])) {
    $itemId = (int)$_POST['delete-item-id'];

    // Fetch item details for deleting the picture
    $query = "SELECT Pic FROM items WHERE ItemId = $itemId";
    $result = mysqli_query($conn, $query);
    $item = mysqli_fetch_assoc($result);

    if ($item) {
        // Delete the picture file
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $item['Pic'])) {
            unlink($_SERVER['DOCUMENT_ROOT'] . $item['Pic']);
        }

        // SQL query to delete the item
        $deleteQuery = "DELETE FROM items WHERE ItemId = $itemId";
        if (!mysqli_query($conn, $deleteQuery)) {
            echo 'Error deleting item: ' . mysqli_error($conn);
        }
    }
}

// Set the number of items per page
$itemsPerPage = 10; // You can change this to any number you prefer

// Get the current page number from the query string, default to 1 if not set
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $itemsPerPage;

// Fetch the total number of items
$totalItemsQuery = "SELECT COUNT(*) AS total FROM items";
$totalItemsResult = mysqli_query($conn, $totalItemsQuery);
$totalItemsRow = mysqli_fetch_assoc($totalItemsResult);
$totalItems = $totalItemsRow['total'];

// Calculate the total number of pages
$totalPages = ceil($totalItems / $itemsPerPage);

// Fetch items for the current page
$query = "SELECT * FROM items LIMIT $offset, $itemsPerPage";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/CSS/dashboard.css"> <!-- Include your dashboard CSS file here -->
</head>
<body>
    <header>
        <div class="dashboard-title">Admin Dashboard</div>
        <h1><a href="/">Bits N Bytes</a></h1>
        <div class="welcome-message">Welcome, <?php echo htmlspecialchars($_SESSION['admin-name']); ?>!</div>
    </header>

    <div class="header-container">
        <h2>Items</h2>
        <a href="add-item" class="add-item-button">Add New Item</a>
    </div>
    
    <table class="dashboard-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Picture</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['ItemId']); ?></td>
            <td><?php echo htmlspecialchars($row['ProductName']); ?></td>
            <td><?php echo htmlspecialchars($row['Description']); ?></td>
            <td><?php echo htmlspecialchars($row['Price']); ?></td>
            <td><img src="<?php echo htmlspecialchars($row['Pic']); ?>" alt="Product Image" width="50"></td>
            <td><?php echo htmlspecialchars($row['Category']); ?></td>
            <td><?php echo htmlspecialchars($row['Quantity']); ?></td>
            <td>
            <div class="actions-cell">
            <a href="edit-item/<?php echo $row['ItemId']; ?>" class="edit-button">Edit</a>
            <form method="POST" action="" class="inline-form">
            <input type="hidden" name="delete-item-id" value="<?php echo $row['ItemId']; ?>">
            <button type="submit" name="delete-item" class="remove-button" onclick="return confirm('Are you sure you want to delete this item?');">Remove</button>
            </form>
            </div>
            </td>

        </tr>
        <?php } ?>
    </tbody>
</table>


    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?php echo $page + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
</body>
</html>

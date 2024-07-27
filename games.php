<?php
include('config/db_connect.php');
// Define items per page
$itemsPerPage = 8;

// Get the current page number from the query string, default to 1 if not set
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $itemsPerPage;

// Fetch total number of items in the Games category
$totalItemsQuery = "SELECT COUNT(*) AS total FROM items WHERE Category like '%Games%'";
$totalItemsResult = mysqli_query($conn, $totalItemsQuery);
$totalItemsRow = mysqli_fetch_assoc($totalItemsResult);
$totalItems = $totalItemsRow['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

// Fetch items for the current page
$sql = "SELECT * FROM items WHERE Category like '%Games%' LIMIT $offset, $itemsPerPage";
$result = mysqli_query($conn, $sql);
$items = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
    mysqli_free_result($result);
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Games - Bits N Bytes</title>
    <link rel="stylesheet" href="CSS/amazon.css">
    <link rel="stylesheet" href="CSS/carttt.css">
    <link rel="shortcut icon" href="Images/icon.png">
</head>
<body>
<?php include 'header.php';?>
    <aside class="filter"></aside>
    <div class="content">
        <br>
        <h2 class="sub-title">Games</h2>
        <div class="product-view">
            <?php if (count($items) > 0): ?>
                <?php foreach ($items as $row): ?>
                    <a href="hardware/product/<?php echo $row['ItemId']; ?>">
                        <div class="product">
                            <div><img src="<?php echo $row['Pic']; ?>" alt="<?php echo $row['ProductName']; ?>" loading="lazy"/></div>
                            <h3><?php echo $row['ProductName']; ?></h3>
                            <p><?php echo $row['Description']; ?></p>
                            <h3 class="price"><span class="new-price"><?php echo $row['Price']; ?></span></h3>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty"><br><br>
                    <h1>No Games found.</h1>
                    <br><br>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($totalPages > 1): ?>
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
            <br>
        <?php endif; ?>
    </div>
    <aside class="ad"></aside>
</body>
</html>

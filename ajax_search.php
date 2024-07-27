<?php
include('config/db_connect.php');

// Define items per page
$itemsPerPage = 8;

// Get the current page number from the query string, default to 1 if not set
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $itemsPerPage;

// Initialize variables
$search = '';
$totalItems = 0;
$totalPages = 1;
$items = [];

// Handle search query
if (isset($_SESSION['search'])) {
    $search = $_SESSION['search'];
}

// Perform search only if the search term is not empty
if (!empty($search)) {
    // Sanitize and prepare the search term for use in SQL
    $search = "%" . $conn->real_escape_string($search) . "%";

    // Fetch total number of items matching the search query
    $totalItemsQuery = $conn->prepare("
        SELECT COUNT(*) AS total 
        FROM items 
        WHERE 
            ProductName LIKE ? OR 
            Description LIKE ? OR 
            Category LIKE ?
    ");
    $totalItemsQuery->bind_param('sss', $search, $search, $search);
    $totalItemsQuery->execute();
    $totalItemsResult = $totalItemsQuery->get_result();
    $totalItemsRow = $totalItemsResult->fetch_assoc();
    $totalItems = $totalItemsRow['total'];
    $totalPages = ceil($totalItems / $itemsPerPage);

    // Fetch items for the current page matching the search query
    $sql = $conn->prepare("
        SELECT * 
        FROM items 
        WHERE 
            ProductName LIKE ? OR 
            Description LIKE ? OR 
            Category LIKE ? 
        ORDER BY 
            CASE 
                WHEN ProductName LIKE ? THEN 1
                WHEN Description LIKE ? THEN 2
                WHEN Category LIKE ? THEN 3
                ELSE 4
            END 
        LIMIT ?, ?
    ");
    $sql->bind_param('ssssssii', $search, $search, $search, $search, $search, $search, $offset, $itemsPerPage);
    $sql->execute();
    $result = $sql->get_result();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        $result->free();
    }
}
$conn->close();
?>
<div id="results-content">
    <?php if (!empty($search)): ?>
        <br>
        <h2 class="sub-title">Results</h2>
        <div class="product-view">
            <?php if (count($items) > 0): ?>
                <?php foreach ($items as $row): ?>
                    <a href="/hardware/product/<?php echo $row['ItemId']; ?>">
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
                    <h1>This Item Doesn't Exist</h1>
                    <br><br>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="/search/page=<?php echo $page - 1; ?>">Previous</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="/search/page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="/search/page=<?php echo $page + 1; ?>">Next</a>
                <?php endif; ?>
            </div>
            <br>
        <?php endif; ?>
    <?php else: ?>
        <div class="empty"><br><br>
            <h1>Please enter a search term.</h1>
            <br><br>
        </div>
    <?php endif; ?>
</div>

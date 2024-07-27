<?php
include('config/db_connect.php');

// Initialize variables
$search = '';

// Handle search query
if (isset($_POST['submit'])) {
    $search = trim(htmlspecialchars($_POST['search']));
    $_SESSION['search'] = $search; // Store search term in session
} elseif (isset($_SESSION['search'])) {
    $search = $_SESSION['search'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bits N Bytes</title>
    <link rel="stylesheet" href="CSS/amazon.css" />
    <link rel="stylesheet" href="CSS/carttt.css" />
    <link rel="shortcut icon" href="Images/icon.png">
</head>
<body>
<?php include 'header.php'; ?>
<aside class="filter"></aside>
<div class="content">
    <div id="results">
        <?php include 'ajax_search.php'; ?>
    </div>
</div>
<aside class="ad"></aside>
<script>
// JavaScript for handling AJAX pagination
document.addEventListener('DOMContentLoaded', function() {
    function setupPaginationLinks() {
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                fetchResults(this.href);
            });
        });
    }

    function fetchResults(url) {
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            document.querySelector('#results').innerHTML = data;
            window.history.pushState(null, '', url);
            setupPaginationLinks(); // Reattach event listeners for new pagination links
        })
        .catch(error => console.error('Error fetching results:', error));
    }

    setupPaginationLinks();
});
</script>
</body>
</html>

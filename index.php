<?php 
include('config/db_connect.php');
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=0.8" />
    <meta name="description" content="Bits N Bytes - Your one-stop shop for all electronics including accessories, consoles, games, hardware, laptops, monitors, and phones.">
    <meta name="keywords" content="electronics, accessories, consoles, games, hardware, laptops, monitors, phones, online store">
    <meta name="author" content="Bits N Bytes">

    <meta property="og:title" content="Bits N Bytes - Electronics Online Store">
    <meta property="og:description" content="Your one-stop shop for all electronics including accessories, consoles, games, hardware, laptops, monitors, and phones.">
    <meta property="og:image" content="https://bitsnbytes.rf.gd/Images/icon.png">
    <meta property="og:url" content="https://bitsnbytes.rf.gd">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Bits N Bytes - Electronics Online Store">
    <meta name="twitter:description" content="Your one-stop shop for all electronics including accessories, consoles, games, hardware, laptops, monitors, and phones.">
    <meta name="twitter:image" content="https://bitsnbytes.rf.gd/Images/icon.png">
    <title>Bits N Bytes</title>
    <link rel="stylesheet" href="CSS/amazon.css" />
    <link rel="shortcut icon" href="Images/icon.png">
  </head>
  <body>
  <script>
        fetch('/', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'userAgent=' + encodeURIComponent(navigator.userAgent)
        })
    </script>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userAgent'])) {
    $currentTime = time();
    $oneHour = 3600;
    $dir = __DIR__ . '/data';
    $file = $dir . '/visitor.txt';

    // Check if the directory exists
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true); // Create the directory and set permissions
    }

    // Check if the file exists
    if (!file_exists($file)) {
        touch($file); // Create the file if it doesn't exist
        chmod($file, 0644); // Set the file permissions
    }

    // Check if enough time has passed since the last save
    if (!isset($_COOKIE['last_save_time']) || $currentTime - $_COOKIE['last_save_time'] > $oneHour) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_POST['userAgent'];
        $timestamp = date('Y-m-d H:i:s');
        $data = "Timestamp: $timestamp, IP: $ip, UserAgent: $userAgent" . PHP_EOL;
        file_put_contents($file, $data, FILE_APPEND | LOCK_EX);
        $_SESSION['last_save_time'] = $currentTime;
        setcookie('last_save_time', $currentTime, $currentTime + $oneHour);
    }
}
?>


<?php include 'header.php';?>
    <aside class="filter"></aside>
    <div class="content">
      <section> <br>
        <h2 class="sub-title">What's New</h2>
        <div class="product-view">
          <?php
            $sql = "SELECT * FROM items WHERE Category like '%New%' ";
            $result = mysqli_query($conn,$sql);
             while($row=mysqli_fetch_assoc($result)){ ?>
        <a href="hardware/product/<?php echo $row['ItemId']; ?> ">
          <div class="product">
            <div><img src= "<?php echo $row['Pic'] ?>" alt="<?php echo $row['ProductName'] ?> loading="lazy""/></div>
            <h3><?php echo $row['ProductName'] ?></h3>
            <p><?php echo $row['Description'] ?></p>
            <h3 class="price"><span class="new-price"><?php echo $row['Price'] ?></span></h3>
          </div>
        </a>
        <?php }mysqli_free_result($result);?>
        </div>
      </section>
      <section>
        <h2 class="sub-title">Hot deals</h2>
        <div class="product-view">
          <?php
            $sql = "SELECT * FROM items WHERE Category like '%Hot%' ";
            $result = mysqli_query($conn,$sql);
             while($row=mysqli_fetch_assoc($result)){ ?>
          <a href="hardware/product/<?php echo $row['ItemId']; ?> ">
          <div class="product">
            <div><img src= "<?php echo $row['Pic'] ?>" alt="<?php echo $row['ProductName'] ?> loading="lazy""/></div>
            <h3><?php echo $row['ProductName'] ?></h3>
            <p><?php echo $row['Description'] ?></p>
            <h3 class="price"><span class="new-price"><?php echo $row['Price'] ?></span></h3>
          </div>
        </a>
        <?php }mysqli_free_result($result);mysqli_close($conn);?>
        </div>
      </section>
    </div>
    <aside class="ad"></aside>
  </body>
</html>

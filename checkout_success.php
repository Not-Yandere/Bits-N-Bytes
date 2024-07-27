
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=0.8" />
    <title>Bits N Bytes</title>
    <link rel="stylesheet" href="CSS/amazon.css" />
    <link rel="stylesheet" href="CSS/carttt.css" />
    <link rel="shortcut icon" href="Images/icon.png">
  </head>
  <body>
  <?php include 'header.php';?>
<?php
echo '<div class="empty"><br><br>
<h1>&#10003; Purchase Successful</h1>
<br><br></div>' ; 
echo  '<script>
                setTimeout(function(){
                    window.location.href = "/";
                }, 1500);
              </script>';
?>
</body>
</html>
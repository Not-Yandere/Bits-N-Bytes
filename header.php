<?php include 'session_check.php';
include 'config/db_connect.php';
$isUserLoggedIn = isset($_SESSION['user']); 
$user_status = isset($_SESSION['user_status']) ? $_SESSION['user_status'] : '';
$requested_uri = $_SERVER['REQUEST_URI'];
$current_page = basename($_SERVER['PHP_SELF']);
?>

<body>

<?php

include 'cookie-consent.php'; 
?>
<header>
      <h1><a href="/">Bits N Bytes</a></h1>
      <div class="search">
        <form id="searchForm" action="/search" method="POST">
              <input
                type="search"
                name="search"
                id="search"
                placeholder="Search..."
              />
              <button type="submit" name="submit" id="submit"></button>
            </form>
      </div>
      <button class='menu' id='open' onclick="
          document.getElementById('links').style='opacity:1;top:72px';
          document.getElementById('open').style.display='none';
          document.getElementById('close').style='display:block';" >
          <img src="Images\menu.png" alt="menu icon"></button>


      <button class='menu' id='close' onclick="
          document.getElementById('links').style='opacity:0;top:-140px';
          document.getElementById('open').style.display='block';
          document.getElementById('close').style='display:none';">
        <img src="Images/close.png" alt="close menu icon"></button>



      <ul id='links'>
        <li><a href="/">Home</a></li>
        <li>
          <?php if (isset($_SESSION['user'])) {
            echo '
            <a href="/profile">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000" height="25" width="25"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12.12 12.78C12.05 12.77 11.96 12.77 11.88 12.78C10.12 12.72 8.71997 11.28 8.71997 9.50998C8.71997 7.69998 10.18 6.22998 12 6.22998C13.81 6.22998 15.28 7.69998 15.28 9.50998C15.27 11.28 13.88 12.72 12.12 12.78Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M18.74 19.3801C16.96 21.0101 14.6 22.0001 12 22.0001C9.40001 22.0001 7.04001 21.0101 5.26001 19.3801C5.36001 18.4401 5.96001 17.5201 7.03001 16.8001C9.77001 14.9801 14.25 14.9801 16.97 16.8001C18.04 17.5201 18.64 18.4401 18.74 19.3801Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>'
             . $_SESSION['user'] .
            '</a>'; 
            ?>
        </li>
      <li>
       <div class='exit'>
       <script>function logout(){window.location.href='/logout_func';}</script>
        <button onclick='logout()'>
        <svg fill="#ffffff" height="17px" width="27px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 471.2 471.2" xml:space="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M227.619,444.2h-122.9c-33.4,0-60.5-27.2-60.5-60.5V87.5c0-33.4,27.2-60.5,60.5-60.5h124.9c7.5,0,13.5-6,13.5-13.5 s-6-13.5-13.5-13.5h-124.9c-48.3,0-87.5,39.3-87.5,87.5v296.2c0,48.3,39.3,87.5,87.5,87.5h122.9c7.5,0,13.5-6,13.5-13.5 S235.019,444.2,227.619,444.2z"></path> <path d="M450.019,226.1l-85.8-85.8c-5.3-5.3-13.8-5.3-19.1,0c-5.3,5.3-5.3,13.8,0,19.1l62.8,62.8h-273.9c-7.5,0-13.5,6-13.5,13.5 s6,13.5,13.5,13.5h273.9l-62.8,62.8c-5.3,5.3-5.3,13.8,0,19.1c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4l85.8-85.8 C455.319,239.9,455.319,231.3,450.019,226.1z"></path> </g> </g> </g></svg>Logout</button>
      </div>
      <?php }else{echo '<a href="/log-in">Login</a>';} ?>
      </li>
        
      </ul>
      <div class="cart-container" onclick="window.location.href='<?php echo $isUserLoggedIn ? '/cart' : '/log-in'; ?>'">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="30"
              height="30"
              fill="currentColor"
              class="bi bi-cart2"
              viewBox="0 0 16 16"
            >
              <path
                d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"
              /></svg>
            <span class="cart-count">0</span>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', () => {
    const cartContainer = document.querySelector('.cart-container');
    const footer = document.querySelector('footer');
    const currentPage = window.location.pathname;

    function updateCartCount() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const cartCountElement = document.querySelector('.cart-count');
        let itemCount = 0;
        cart.forEach(item => {
            itemCount += item.quantity;
        });

        // Update cart count display
        cartCountElement.textContent = itemCount;

        // Hide or show cart icon based on item count
        if (itemCount > 0 && currentPage !== '/cart') {
            cartContainer.style.display = 'inline-flex';
        } else {
            cartContainer.style.display = 'none';
        }
    }

    function adjustCartPosition() {
        const footerRect = footer.getBoundingClientRect();
        const windowHeight = window.innerHeight;

        if (footerRect.top <= windowHeight) {
            cartContainer.style.bottom = `${windowHeight - footerRect.top + 25}px`;
        } else {
            cartContainer.style.bottom = '25px';
        }
    }

    // Initial check
    updateCartCount();
    adjustCartPosition();

    // Update the cart count whenever the cart is modified
    window.addEventListener('storage', updateCartCount);

    // Adjust position on resize and scroll
    window.addEventListener('resize', adjustCartPosition);
    window.addEventListener('scroll', adjustCartPosition);
});

    </script>
    <script src='menu.js'></script>
    </header>

    <nav id="nav">
      <ul>
        <a href="/Hardware"><li>Hardware</li></a>
        <a href="/laptops"><li>Laptops</li></a>
        <a href="/phones"><li>Mobile Phones</li></a>
        <a href="/monitors"><li>Monitors</li></a>
        <a href="/accessories"><li>Accessories</li></a>
        <a href="/consoles"><li>Consoles</li></a>
        <a href="/games"><li>Video Games</li></a>
      </ul>
    </nav>

    <footer>
  <div class="details footer">
    <h1><a href="/">Bits N Bytes</a></h1>
    <dl>
      <li>622 Broadway, New York, NY</li>
      <li>0572345678</li>
      <li style="text-decoration: underline;">bitsnbytes@gmail.com</li>
    </dl>
  </div>
  <div class="categories footer">
    <h2><a href="#nav">Categories</a></h2>
    <dl>
      <a href="/Hardware"><li>Hardware</li></a>
      <a href="/laptops"><li>Laptops</li></a>
      <a href="/phones"><li>Mobile Phones</li></a>
      <a href="/monitors"><li>Monitors</li></a>
      <a href="/accessories"><li>Accessories</li></a>
      <a href="/consoles"><li>Consoles</li></a>
      <a href="/games"><li>Video Games</li></a>
    </dl>
  </div>
  <div class="credits footer">
    <h2>Built by:</h2>
    <div class="person">
      <h4 class="name">Qasem Ezzaldeen</h4>
      <div class="icons">
        <a href="https://github.com/qasem-ezzaldeen" target="_blank"><img src="./Images/github.png" alt="githubIcon"></a>
        <a href="https://t.me/QasemEzz" target="_blank"><img src="./Images/tele.png" alt="teleIcon"></a>
      </div>
    </div>
    <div class="person">
      <h4 class="name">Mohammed Hamad</h4>
      <div class="icons">
        <a href="https://github.com/Not-Yandere" target="_blank"><img src="./Images/github.png" alt="githubIcon"></a>
        <a href="https://t.me/NOT_YANDERE" target="_blank"><img src="./Images/tele.png" alt="teleIcon"></a>
      </div>
    </div>
    <div class="person">
      <h4 class="name">Ahmed Khoukh</h4>
      <div class="icons">
        <a href="https://github.com/ahmedgamer9991" target="_blank"><img src="./Images/github.png" alt="githubIcon"></a>
        <a href="https://t.me/Akuma910" target="_blank"><img src="./Images/tele.png" alt="teleIcon"></a>
      </div>
    </div>
    <div class="person">
      <h4 class="name">Abdelrahman Alex</h4>
      <div class="icons">
        <a href="https://github.com/abdelrahman8123" target="_blank"><img src="./Images/github.png" alt="githubIcon"></a>
        <a href="https://t.me/body8123" target="_blank"><img src="./Images/tele.png" alt="teleIcon"></a>
      </div>
    </div>
  </div>
  <div class="footer-links">
    <a href="/terms-of-service">Terms of Service</a> | 
    <a href="/privacy-policy">Privacy Policy</a>
  </div>
</footer>
</body>
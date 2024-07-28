<?php include '../session_check.php'; 
$isUserLoggedIn = isset($_SESSION['user']); 
?>

<body>
<?php
include '../additional-details-form.php'; 
include '../cookie-consent.php'; 
?>
<header>
    <h1><a href="/">Bits N Bytes</a></h1>
    <div class="search">
        <form action="/search" method="POST">
            <input type="search" name="search" id="search" placeholder="Search..." />
            <button type="submit" name="submit" id="submit"></button>
        </form>
    </div>

    <button class='menu' id='open' onclick="
        document.getElementById('links').style='opacity:1;top:72px';
        document.getElementById('open').style.display='none';
        document.getElementById('close').style='display:block';">
        <img src="/Images/menu.png" alt="menu icon">
    </button>

    <button class='menu' id='close' onclick="
        document.getElementById('links').style='opacity:0;top:-140px';
        document.getElementById('open').style.display='block';
        document.getElementById('close').style='display:none';">
        <img src="/Images/close.png" alt="close menu icon">
    </button>

    <ul id='links'>
        <li><a href="/">Home</a></li>
        <li class='log-out-li'>
            <?php if (isset($_SESSION['user'])){echo 'Hi, '. $_SESSION['user']; ?>
            <div class='exit'>
                <script>function logout(){window.location.href='/logout_func';}</script>
                <button onclick='logout()'><img src="/Images/exit.png" alt="log out"></button>
            </div>
            <?php }else{echo '<a href="/log-in">Login</a>';} ?>
        </li>
        <li>
            <a href="<?php if(isset($_SESSION['user'])){echo "/cart";}else{echo "/log-in";}?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
                    <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0" />
                </svg>
                Cart
            </a>
        </li>
    </ul>
    <script src='/menu.js'></script>
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
                <a href="https://github.com/qasem-ezzaldeen" target="_blank"><img src="/Images/github.png" alt="githubIcon"></a>
                <a href="https://t.me/QasemEzz" target="_blank"><img src="/Images/tele.png" alt="teleIcon"></a>
            </div>
        </div>
        <div class="person">
            <h4 class="name">Mohammed Hamad</h4>
            <div class="icons">
                <a href="https://github.com/Not-Yandere" target="_blank"><img src="/Images/github.png" alt="githubIcon"></a>
                <a href="https://t.me/NOT_YANDERE" target="_blank"><img src="/Images/tele.png" alt="teleIcon"></a>
            </div>
        </div>
        <div class="person">
            <h4 class="name">Ahmed Khoukh</h4>
            <div class="icons">
                <a href="https://github.com/ahmedgamer9991" target="_blank"><img src="/Images/github.png" alt="githubIcon"></a>
                <a href="https://t.me/Akuma910" target="_blank"><img src="/Images/tele.png" alt="teleIcon"></a>
            </div>
        </div>
        <div class="person">
            <h4 class="name">Abdelrahman Alex</h4>
            <div class="icons">
                <a href="https://github.com/abdelrahman8123" target="_blank"><img src="/Images/github.png" alt="githubIcon"></a>
                <a href="https://t.me/body8123" target="_blank"><img src="/Images/tele.png" alt="teleIcon"></a>
            </div>
        </div>
    </div>
</footer>
</body>

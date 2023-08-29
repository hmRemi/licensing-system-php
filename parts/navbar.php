<header class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <div class="navbar-header">
                <!-- Navbar Brand -->
                <a href="/" class="navbar-brand">
                    <div id="snow"></div>
                    <div class="brand-text brand-big visible">
                        <picture>
                            <source type="image/webp" srcset="/panel/assets/img/favicon.webp" widht="35" height="35">
                            <!--<img src="../assets/img/favicon.png" width="35" height="35">-->
                            <h2 class="h4 no-margin-bottom">Audi Development</h2>
                        </picture>
                    </div>
                    <div class="brand-text brand-sm">
                        <picture>
                            <source type="image/webp" srcset="/panel/assets/img/favicon.webp" widht="35" height="35">
                            <img src="/panel/assets/img/favicon.png" widht="35" height="35">
                        </picture>
                    </div>
                </a>

                <!-- Sidebar Toggle Button -->
                <button class="sidebar-toggle"><i class="fas fa-long-arrow-alt-left"></i></button>
            </div>

            <!-- Middle Icon -->
            <picture>
                <source type="image/webp" srcset="/panel/assets/img/favicon.webp" width="50" height="50">
                <img src="/panel/assets/img/favicon.png" width="50" height="50">
            </picture>

            <!-- Account -->
            <div class="list-inline-item dropdown">
            
                <a id="accountDropdown" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link language dropdown-toggle">
                    <span class="d-sm-inline-block">Username: <?php include $_SERVER['DOCUMENT_ROOT'].'/panel/utils/user.php'; echo $username; ?> </span> 
                </a>
                
                <!-- Dropdown Menu -->
                <div aria-labelledby="accountDropdown" class="dropdown-menu">
                    <a rel="nofollow" href="/logout" class="dropdown-item"><span class="d-sm-inline">Logout</span> <i class="fas fa-sign-out-alt"></i></a>
                </div>

            </div>

        </div>
    </nav>
</header>
<body>
    <script type="text/javascript" src="/panel/assets/js/PureSnow.js"></script>
</body>
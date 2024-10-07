<style>
    /* General Styles */
    body, html {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    /* Navbar */
    .navbar {
        background-color: #d7eac4;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        z-index: 1001; /* Make sure navbar is above the sidebar */
    }

    .navbar .brand {
        font-size: 1.5em;
        font-weight: bold;
        flex: 1;
        margin-left: 20px; /* Added margin to move it away from the hamburger icon */
        transition: all 0.3s ease;
    }
    .navbar .brand img {
        width: 200px; /* Set logo width */
        height: auto; /* Maintain aspect ratio */
    }
    
    .navbar .nav-links {
        display: none;
    }

    .navbar .nav-links a {
        margin-left: 20px;
        text-decoration: none;
        color: black;
    }

    .navbar .nav-links a:hover {
        text-decoration: underline;
    }

    .navbar .hamburger {
        font-size: 1.5em;
        cursor: pointer;
        display: none;
        position: absolute;
        left: 10px;
    }

    .navbar.centered .brand {
        text-align: center;
        margin-left: 0;
    }

    /* Sidebar */
    #sidebar {
        position: fixed;
        top: 0;
        left: -250px;
        width: 250px;
        height: 100%;
        background-color: #343a40;
        padding-top: 60px;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    #sidebar.active {
        left: 0;
    }

    #sidebar a {
        color: white;
        padding: 15px 20px;
        text-decoration: none;
        display: block;
        font-size: 1.1em;
    }

    #sidebar a:hover {
        background-color: #495057;
    }

    /* Main content */
    #main-content {
        padding: 20px;
        margin-left: 0;
        transition: margin-left 0.3s ease;
    }

    #main-content.active {
        margin-left: 250px;
    }

    /* Responsive Design */
    @media (min-width: 992px) {
        .navbar .hamburger {
            display: none;
        }

        .navbar .nav-links {
            display: block;
        }

        #sidebar {
            display: none;
        }

        #main-content {
            margin-left: 0;
        }
    }

    @media (max-width: 991px) {
        .navbar .hamburger {
            display: block;
        }

        .navbar .nav-links {
            display: none;
        }

        /* When sidebar is active, logo centers */
        .navbar.centered .brand {
            margin-left: 0;
        }
    }
</style>

<!-- Sidebar for small devices -->
<div id="sidebar">
    <br>
    <br>
    <a href="user_dashboard.php"><i class="fas fa-home"></i> Home</a>
    <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
    <a href="#"><i class="fas fa-shopping-cart"></i> Cart</a>
    <a href="logout.php" onclick="return confirm('Are you sure you want to log out?');"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>

<!-- Navbar -->
<nav class="navbar" id="navbar">
    <div class="hamburger" id="sidebarToggle">☰</div>
    <a class="brand logo-container">
        <img src="../images/pamilihannet1.png" alt="PamilihanNet Logo">
    </a>
    <div class="nav-links">
        <a href="user_dashboard.php"><i class="fas fa-home"></i> Home</a>
        <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
        <a href="#"><i class="fas fa-shopping-cart"></i> Cart</a>
        <a href="logout.php" onclick="return confirm('Are you sure you want to log out?');"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </div>
</nav>

<!-- Custom script -->
<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContent = document.getElementById('main-content');
    const navbar = document.getElementById('navbar');

    let isSidebarOpen = false; // Track the state of the sidebar

    sidebarToggle.addEventListener('click', function () {
        isSidebarOpen = !isSidebarOpen;

        sidebar.classList.toggle('active');
        mainContent.classList.toggle('active');
        navbar.classList.toggle('centered');

        // Change hamburger icon to X when open, and back to ☰ when closed
        sidebarToggle.innerHTML = isSidebarOpen ? '✖' : '☰'; // Change icon
    });

    // Close sidebar when clicking outside of it or on the sidebar itself
    sidebar.addEventListener('click', function () {
        if (isSidebarOpen) {
            isSidebarOpen = false;
            sidebar.classList.remove('active');
            mainContent.classList.remove('active');
            navbar.classList.remove('centered');
            sidebarToggle.innerHTML = '☰'; // Change back to hamburger
        }
    });
</script>

<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> <!-- Font Awesome -->
<?php
    $pageTitle = isset($customPageTitle) ? $customPageTitle : "Application Page";
    echo "<header class='head'>";
    echo    "<h1 class='header-title'> $pageTitle </h1>";
    echo    "<nav>";
    echo        "<a class='filter' href='halaman_pencari_kerja.php'> <img class='home-img' src='images/home.png' alt='Home'> Home</a>";
// echo            "<a class='filter' href=''>Company</a>";
// echo            "<a class='filter' href=''>Category</a>";
// echo            "<a class='filter' href=''>Location</a>";
// echo            "<a class='filter' href=''>Type</a>";
// echo            "<a class='filter' href=''>Salary</a>";
                
            if ($_SESSION) {
                if ($_SESSION['role'] == "perusahaan") {
                    echo "<a class='filter' href='dashboard_perusahaan.php'>Dashboard</a>";
                }
                    echo "<a class='filter' href='logout.php'> 
                            <i class='fas fa-sign-out-alt'></i> Logout
                        </a>";
            } else {
                    echo "<a class='filter' href='login.php'>
                            <i class='fas fa-sign-in-alt'></i> Login
                        </a>";
            }

    echo    "</nav>";
    echo    "<div class='search-bar'>";
    echo        "<form action='index.html' method='post'>";
    echo            "<input class='searchtext' type='search' name='src' id='SR' placeholder='Search'>";
    echo            "<input class='searchbutton' type='submit' name='src-sub' id='SR-sub'>";
    echo        "</form>";
    echo    "</div>";
    echo "</header>";
?>
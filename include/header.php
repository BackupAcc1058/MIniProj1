<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> 
<?php
    require_once 'config/koneksi.php';
    $pageTitle = isset($customPageTitle) ? $customPageTitle : "Application Page";
    echo "<header class='head'>";
        if ($_SESSION) {
                if ($_SESSION['role'] == "perusahaan") {
                    $hquery = "SELECT * FROM perusahaan WHERE id_user = ?";
                    $hstmt = $conn->prepare($hquery);
                    $hstmt->bind_param("i", $_SESSION['user_id']);
                    $hstmt->execute();
                    $hresult = $hstmt->get_result();
                    $huser = $hresult -> fetch_assoc();
                    echo "<h2>".$huser['nama_perusahaan']."</h2>";
                } elseif ($_SESSION['role'] == "pencari_kerja") {
                    $hquery = "SELECT * FROM pencari_kerja WHERE id_user = ?";
                    $hstmt = $conn->prepare($hquery);
                    $hstmt->bind_param("i", $_SESSION['user_id']);
                    $hstmt->execute();
                    $hresult = $hstmt->get_result();

                    $huser = $hresult -> fetch_assoc();
                    echo "<h2>".$huser['nama_lengkap']."</h2>";
               }
        }
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
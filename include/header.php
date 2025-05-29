<?php
echo    "<header class='head'>";
echo        "<h1 class='header-title'> Application Page </h1>";
echo        "<nav>";
echo            "<a class='filter' href=''> <img class='home-img' src='images/home.png' alt='Home'> Home</a>";
echo            "<a class='filter' href=''>Company</a>";
echo            "<a class='filter' href=''>Category</a>";
echo            "<a class='filter' href=''>Location</a>";
echo            "<a class='filter' href=''>Type</a>";
echo            "<a class='filter' href=''>Salary</a>";
echo            "<a class='filter' href='logout.php'>Logout</a>";
echo        "</nav>";
echo        "<div class='search-bar'>";
echo            "<form action='index.html' method='post'>";
echo                "<input class='searchtext' type='search' name='src' id='SR' placeholder='Search'>";
echo                "<input class='searchbutton' type='submit' name='src-sub' id='SR-sub'>";
echo            "</form>";
echo        "</div>";
echo    "</header>";
?>
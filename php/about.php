<?php
// Initialize the session
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>About-us Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--CSS Links-->
    <link rel="stylesheet" href="../css/mobile/banner_mobile.css">
    <link rel="stylesheet" href="../css/mobile/about_mobile.css">
    <link rel="stylesheet" type="text/css" href="../css/mobile/nav_mobile.css">
    <!--CSS Links Desktop-->
    <link rel="stylesheet" type="text/css" href="../css/desktop/about_desktop.css">
    <link rel="stylesheet" type="text/css" href="../css/desktop/banner_desktop.css">
    <!--Navigation bar desktop-->
    <link rel="stylesheet" href="../css/desktop/nav_desktop.css">
    <script src="../script/nav_desktop.js"></script>
</head>

<body>
<nav class="desktop-nav">
        <div id="btn-toggle-nav" onclick="meny()"></div>
        <img src="../storage/mobile/storymapbanner.jpg">
        <p class="logo_text">Enjoy a storymap of Barcelona's most beautiful places</p>
        <div id="desktop-links" class="nav-inactive">
            <div id="btn-toggle-nav-links" onclick="meny()"></div>
            <ul>
                <li><a href="../php/storymap.php">Home</a></li>
                <li><a href="../php/attractions.php">Attractions</a></li>
                <li><a href="../php/trips.php">Trips</a></li>
                <li><a href="../php/accountpage.php">Account</a></li>
                <li><a href="../php/about.php">About us</a></li>
            </ul>
        </div>
    </nav>
    <!-- Banner -->
    <div class="logo">
        <img src="../storage/mobile/storymaplogo.png">
        <a href="#">Barcelona</a>
    </div>
    <div class="container">
        <div class="about">
            <div class="text">
                <h1>About Us</h1>
                <div class="line"></div>
            </div>
        </div>
        <div class="content">
            <p> We aim to deliver the best platform for our fellow Barcelona travellers. As explorers ourselves, we know how time consuming the research for the trip can be. That's why we created this story map!
            </p>
            <p>
            The story map is a unique service for our users to get the full Barcelona experience. This map will show you all the top attractions in Barcelona, as well as prices, and directions.
            By creating an account you can simply choose the attractions you want to visit, and save the trip in your account for easy access on the go!
            </p>
        </div>
    </div>
    <!-- Navigation bar -->
    <div class="navbar">
        <a href="../php/storymap.php">Home</a>
        <a href="../php/attractions.php">Attractions</a>
        <a href="../php/trips.php">Trips</a>
        <a href="../php/accountpage.php">Account</a>
    </div>
</body>
</html>
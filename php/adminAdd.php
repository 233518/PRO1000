<?php
// Initialize the session
session_start();
require_once "config.php";
$currentUser = "";
$user_id = $_SESSION["id"];
$errorMsg = "";

//Get admin status
if ($user_id == null) {
    header("location: ../php/login.php");
    exit;
}
$getsql = "SELECT admin FROM users where ID ='$user_id'";
$result = $link->query($getsql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['admin'] == 0) {
            header("location: ../php/accountpage.php");
            exit;
        }
    }
}

$lat = "";
$lon = "";
$headline = "";
$text = "";
$url = "";
$caption = "";
$credit = "";
$filename = "";

$roadDesc = "";
$fee = "";
$visitors = "";
$notices = "";

if (!empty($_POST['action'])) {
    //Add attraction
    $lat = $_POST["lat"];
    $lon = $_POST["lon"];
    $headline = $_POST["headline"];
    $text = $_POST["text"];
    $url = $_POST["url"];
    $caption = $_POST["caption"];
    $credit = $_POST["credit"];

    $roadDesc = $_POST["roadDesc"];
    $fee = $_POST["fee"];
    $visitors = $_POST["visitors"];
    $notices = $_POST["notices"];

    $sql = "INSERT INTO attractions (storymap_slides_location_lat, 
    storymap_slides_location_lon, 
    storymap_slides_text_headline, 
    storymap_slides_text_text, 
    storymap_slides_media_url, 
    storymap_slides_media_caption, 
    storymap_slides_media_credit,
    storymap_slides_road_description,
    storymap_slides_entrance_fee,
    storymap_slides_visitors,
    storymap_slides_notices)

    VALUES ('$lat', '$lon', '$headline', '$text', '$url', '$caption', '$credit', '$roadDesc', '$fee', '$visitors', '$notices')";

    if ($link->query($sql) === TRUE) {
        $errorMsg = "New record created successfully";
    } else {
        $errorMsg = "Error: " . $sql . "<br>" . $link->error;
    }
}

if (isset($_FILES['fileToUpload'])) {
    //Upload picture
    $target_dir = "../storage/attractions/";
    $filename = date("Y-m-d") . "_" . date("H-i-s") . "_" . basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $filename;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $errorMsgPicture = "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    if ($imageFileType != "jpg" && $imageFileType != "jpeg") {
        $errorMsgPicture = "Sorry only JPG or JPEG allowed";
        $uploadOk = 0;
    }

    if (!$uploadOk == 0) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $errorMsgPicture = "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        }
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StoryMap/Account Page</title>
    <!--CSS Links-->
    <link rel="stylesheet" href="../css/mobile/banner_mobile.css">
    <link rel="stylesheet" type="text/css" href="../css/mobile/nav_mobile.css">
    <link rel="stylesheet" href="../css/mobile/adminAdd_mobile.css">
    <!--CSS Links Desktop-->
    <link rel="stylesheet" type="text/css" href="../css/desktop/adminAdd_desktop.css">
    <link rel="stylesheet" type="text/css" href="../css/desktop/banner_desktop.css">
    <!--Navigation bar desktop-->
    <link rel="stylesheet" href="../css/desktop/nav_desktop.css" />
    <script src="../script/nav_desktop.js"></script>
</head>

<body>
    <!-- Banner -->
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
    <div class="attractionsAdd">
        <!--Form add attraction!-->
        <!--Error handling for add -->
        <?PHP
        if (isset($errorMsg) && $errorMsg) {
            echo "<p style=\"color: red;\">", htmlspecialchars($errorMsg), "</p>\n\n";
        }
        ?>
        <h1>Upload picture first:</h1>
        <form action="#" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" onchange=form.submit()>
        </form>
        <!--Error handling for upload picture -->
        <?PHP
        if (isset($errorMsgPicture) && $errorMsgPicture) {
            echo "<p style=\"color: red;\">", htmlspecialchars($errorMsgPicture), "</p>\n\n";
        }
        ?>
        <h1>Enter attraction details:</h1>
        <form action="#" method="post">
            <label class="label" for="lat">Attraction lat: </label>
            <input class="input_box" type="text" name="lat" required><br>

            <label class="label" for="lon">Attraction lon: </label>
            <input class="input_box" type="text" name="lon" required><br>

            <label class="label" for="headline">Attraction headline: </label>
            <input class="input_box" type="text" name="headline" required><br>

            <label class="label" for="text">Attraction text: </label>
            <textarea id="input_box_text" class="input_box" type="text" name="text"></textarea><br>

            <label class="label" for="url">Attraction picture: </label>
            <input class="input_box" type="text" name="url" readonly="readonly" value='<?php echo $filename ?>' required><br>

            <label class="label" for="caption">Attraction caption: </label>
            <input class="input_box" type="text" name="caption"><br>

            <label class="label" for="credit">Attraction credit: </label>
            <input class="input_box" type="text" name="credit"><br>

            <label class="label" for="roadDesc">How to get there: </label>
            <input class="input_box" type="text" name="roadDesc"><br>

            <label class="label" for="fee">Entrance fee: </label>
            <input class="input_box" type="text" name="fee"><br>

            <label class="label" for="visitors">Yearly visitors: </label>
            <input class="input_box" type="text" name="visitors"><br>

            <label class="label" for="notices">Notices: </label>
            <input class="input_box" type="text" name="notices">

            <input class="submit_button" type="submit" name="action" value="Submit">
            <a href="adminPage.php"><p class="back_button">Back</p></a>
        </form>

    </div>
    <!-- Navigation bar -->
    <div class="navbar">
        <a href="../php/storymap.php">Home</a>
        <a href="../php/attractions.php">Attractions</a>
        <a href="../php/trips.php">Trips</a>
        <a class="active" href="../php/accountpage.php">Account</a>
    </div>
</body>

</html>
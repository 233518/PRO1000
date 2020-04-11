<?php
// Initialize the session
session_start();
require_once "config.php";
$user_id = $_SESSION["id"];
$errorMsg = "";

//Initialize variables
$table = " <table id='table'> <tr> <th></th> </tr> ";



//Get all attractions
$sql = "SELECT storymap_slides_ID, storymap_slides_text_headline, storymap_slides_media_url FROM attractions";
$result = $link->query($sql);
if (!mysqli_num_rows($result) == 0) {
    while ($row = mysqli_fetch_array($result)) {
        if ($row['storymap_slides_ID'] == 1) {
        } else {
            $table .= "<tr><td style='height: 200px;'> <p style='text-align: center;'>" . $row['storymap_slides_text_headline'] . "</p><img src='" . "../storage/attractions/" . $row['storymap_slides_media_url'] . "'" . " alt='' style='width: 100%; max-width: 400px; height: 200px; margin-left: auto; margin-right: auto;'></img></td></tr>";
        }
    }
}

if (!empty($_POST['data'])) {

    $tripJS = $_POST['data'];
    $name = $_POST['name'];

    $sql = "INSERT INTO trips(userID, attractions, tripname) VALUES ($user_id, '$tripJS', '$name')";
    if ($link->query($sql) === TRUE) {
        print_r("Success!");
    } else {
        print_r($link->error);
    }
    exit();
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StoryMap/Account Page</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!--CSS Links-->
    <link rel="stylesheet" href="../css/mobile/banner_mobile.css">
    <link rel="stylesheet" type="text/css" href="../css/mobile/nav_mobile.css">
    <link rel="stylesheet" href="../css/mobile/tripCreate_mobile.css">
    <!-- Desktop -->
    <link rel="stylesheet" href="../css/desktop/tripCreate_desktop.css">
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
    <div class="tripCreate">
        <h1>Choose the trips you want to visit and view them in our storymap!</h1>
        <div class="input_text">
            <label>Choose name:</label>
            <input type="text" id="textbox_id">
        </div>
        <p>Choose attractions: </p>
        <?php echo $table ?>
        </table>
        <div id='response'></div>
        <div class="button_wrapper">
            <input class="submit_button" type="button" value="Save" id="save">
            <p class="back_button"><a href="accountpage.php">Back</a></p>
        </div>

        <!-- messages -->
        <?PHP
        if (isset($errorMsg) && $errorMsg) {
            echo "<p style=\"color: red;\">", htmlspecialchars($errorMsg), "</p>\n\n";
        }
        ?>
    </div>

    <!-- Navigation bar -->
    <div class="navbar">
        <a href="../php/storymap.php">Home</a>
        <a href="../php/attractions.php">Attractions</a>
        <a href="../php/trips.php">Trips</a>
        <a class="active" href="../php/accountpage.php">Account</a>
    </div>

    <!-- Script to get attractions and send to php -->
    <script>
        var attractions = ['barcelona'];

        $("#table tr").click(function() {
            if ($(this).hasClass("selected")) {
                $(this).removeClass('selected')
                var value = $(this).find('td:first').html();
                var attraction = value.substring(32, value.indexOf("</p>"));
                var index = attractions.indexOf(attraction);
                if (index > -1) {
                    attractions.splice(index, 1);
                }
            } else {
                $(this).addClass('selected');
                var value = $(this).find('td:first').html();
                var attraction = value.substring(32, value.indexOf("</p>"));
                attractions.push(attraction);
            }
        });

        //Send data to php
        $(document).ready(function() {
            $('#save').click(function() {
                var a = document.getElementById('textbox_id').value;
                console.log(a);
                if (a == "") {
                    $('#response').css('color', 'red');
                    $('#response').css('text-align', 'center');
                    $('#response').text('You need to enter a name!');
                } else {
                    var attractionPHP = attractions.join();
                    $.ajax({
                        method: 'post',
                        data: {
                            data: attractionPHP,
                            name: a
                        },
                        success: function(res) {
                            console.log(res);
                            $('#response').css('color', 'red');
                            $('#response').css('text-align', 'center');
                            $('#response').text('Trip successfully created!!');
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
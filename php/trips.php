<?php
// Initialize the session
session_start();
require_once "../php/config.php";

//Initialize arrays
$lat = [];
$lon = [];
$text = [];
$headline = [];
$url = [];
$caption = [];
$credit = [];
$startMap = "";

//Put data in arrays
for ($x = 1; $x <= 16; $x++) {
    $sql = "SELECT storymap_slides_location_lat, 
    storymap_slides_location_lon, 
    storymap_slides_text_headline, 
    storymap_slides_text_text,
    storymap_slides_media_url,
    storymap_slides_media_caption,
    storymap_slides_media_credit FROM attractions WHERE storymap_slides_ID = $x";
    $result = $link->query($sql);
    if (!mysqli_num_rows($result) == 0) {
        while ($row = mysqli_fetch_array($result)) {
            $lat[] = $row["storymap_slides_location_lat"];
            $lon[] = $row["storymap_slides_location_lon"];
            $headline[] = $row["storymap_slides_text_headline"];
            $text[] = $row["storymap_slides_text_text"];
            $url[] = $row["storymap_slides_media_url"];
            $caption[] = $row["storymap_slides_media_caption"];
            $credit[] = $row["storymap_slides_media_credit"];
        }
    }
}

if (!empty($_POST['day3'])) {

    $random = range(1, count($lat)-1);
    shuffle($random);
    

    for ($i = 0; $i < 4; $i++) {
        if ($i == 0) {
            $newLat[] = $lat[$i];
            $newLon[] = $lon[$i];
            $newHeadline[] = $headline[$i];
            $newText[] = $text[$random[$i]];
            $newUrl[] = $url[$i];
            $newCaption[] = $caption[$i];
            $newCredit[] = $credit[$i];
        } else {
            $newLat[] = $lat[$random[$i]];
            $newLon[] = $lon[$random[$i]];
            $newHeadline[] = $headline[$random[$i]];
            $newText[] = $text[$random[$i]];
            $newUrl[] = $url[$random[$i]];
            $newCaption[] = $caption[$random[$i]];
            $newCredit[] = $credit[$random[$i]];
        }
    }

    $startMap = 'startMap()';
    //Encode to json
    $code_lat = json_encode($newLat);
    $code_lon = json_encode($newLon);
    $code_text = json_encode($newText);
    $code_headline = json_encode($newHeadline);
    $code_url = json_encode($newUrl);
    $code_caption = json_encode($newCaption);
    $code_credit = json_encode($newCredit);
}

if (!empty($_POST['day5'])) {

    $random = range(1, count($lat)-1);
    shuffle($random);

    for ($i = 0; $i < 6; $i++) {
        if ($i == 0) {
            $newLat[] = $lat[$i];
            $newLon[] = $lon[$i];
            $newHeadline[] = $headline[$i];
            $newText[] = $text[$random[$i]];
            $newUrl[] = $url[$i];
            $newCaption[] = $caption[$i];
            $newCredit[] = $credit[$i];
        } else {
            $newLat[] = $lat[$random[$i]];
            $newLon[] = $lon[$random[$i]];
            $newHeadline[] = $headline[$random[$i]];
            $newText[] = $text[$random[$i]];
            $newUrl[] = $url[$random[$i]];
            $newCaption[] = $caption[$random[$i]];
            $newCredit[] = $credit[$random[$i]];
        }
    }

    $startMap = 'startMap()';
    //Encode to json
    $code_lat = json_encode($newLat);
    $code_lon = json_encode($newLon);
    $code_text = json_encode($newText);
    $code_headline = json_encode($newHeadline);
    $code_url = json_encode($newUrl);
    $code_caption = json_encode($newCaption);
    $code_credit = json_encode($newCredit);
}


mysqli_close($link);
?>


<!DOCTYPE html>
<html>
<!-- Start of HEAD section -->

<head>
    <title>PRO1000</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--CSS Links-->
    <link rel="stylesheet" href="../css/mobile/trips_mobile.css">
    <link rel="stylesheet" href="../css/mobile/banner_mobile.css">
    <link rel="stylesheet" href="../css/mobile/nav_mobile.css">
    <link rel="stylesheet" href="https://cdn.knightlab.com/libs/storymapjs/latest/css/storymap.css" />
</head>
<!-- Start of BODY section -->

<body>
    <!-- Banner -->
    <div class="logo">
        <img src="../storage/mobile/storymaplogo.png">
        <a href="#">Barcelona</a>
    </div>
    <div class="trips">
        <!-- Storymap -->
        <form action="#" method="post">
            <input class="submit_button_3" type="submit" value="3 Days" name="day3">
            <input class="submit_button_5" type="submit" value="5 Days" name="day5">
        </form>
        <div id="map" style="width: 100%; height: calc(100vh - 50px); z-index: 0;"></div>
    </div>
    <!-- Navigation bar -->
    <div class="navbar" style="font-family: Arial, Helvetica, sans-serif;">
        <a href="../php/storymap.php">Home</a>
        <a href="../php/attractions.php">Attractions</a>
        <a class="active" href="../php/trips.php">Trips</a>
        <a href="../php/accountpage.php">Account</a>
    </div>

    <!--Storymap external script-->
    <script type="text/javascript" src="https://cdn.knightlab.com/libs/storymapjs/latest/js/storymap-min.js"></script>

    <!--Storymap script-->
    <script>
        //Get array from php
        var lat = <?php echo $code_lat; ?>;
        var lon = <?php echo $code_lon; ?>;
        var text = <?php echo $code_text; ?>;
        var headline = <?php echo $code_headline; ?>;
        var url = <?php echo $code_url; ?>;
        var caption = <?php echo $code_caption; ?>;
        var credit = <?php echo $code_credit; ?>;

        var type;
        var slides = [];

        for (let i = 0; i < lat.length; i++) {
            if (i == 0) {
                type = 'overview';
                slides.push({
                    type: type,
                    text: {
                        headline: headline[i],
                        text: text[i]
                    },
                    media: {
                        url: '../storage/attractions/' + url[i],
                        caption: caption[i],
                        credit: credit[i]
                    }
                });
            } else {
                type = 'slide';
                slides.push({
                    type: type,
                    location: {
                        lat: lat[i],
                        lon: lon[i]
                    },
                    text: {
                        headline: headline[i],
                        text: text[i]
                    },
                    media: {
                        url: '../storage/attractions/' + url[i],
                        caption: caption[i],
                        credit: credit[i]
                    }
                });
            }
        }
        console.log(slides);
        //Storymap data path, contains slides info and storymap configurations
        var storymap_data = {
            "calculate_zoom": true,
            "storymap": {
                "language": "en",
                "calculate_zoom": true,
                "map_type": "osm:standard",
                "map_background_color": "white",
                "map_as_image": false,
                "font_css": "'PT Sans', sans-serif",
                slides
            }
        };

        //Storymap extra options
        var storymap_options = {};

        //Load storymap
        function startMap() {
            var storymap = new VCO.StoryMap('map', storymap_data, storymap_options);
            window.onresize = function(event) {
                storymap.updateDisplay(); // this isn't automatic
            }
        }
        <?php echo $startMap ?>
    </script>
</body>

</html>
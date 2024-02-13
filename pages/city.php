<?php
$serverRoot = $_SERVER['DOCUMENT_ROOT'];
session_start();
if (!isset($_GET["city"])) {
    header("Location: ../index.php");
}
define("API_KEY", "1a59599823b73a08ff71aba0ad51f85c");
//Translation handling
require("../php/translation.php");

//Sanitize and Capitalize city name
$city = $_GET['city'];
$city= preg_replace("/[^a-zA-Z0-9ąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]+/", "", $city);
$city = ucfirst($city);

$apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=" . API_KEY. "&lang=$lang&units=metric";

$headers = get_headers($apiUrl);
if (strpos($headers[0], '200') !== false) {
    $response = file_get_contents($apiUrl);
    $result = json_decode($response, true);    

    $timeOfData = date("H:i", $result['dt']);

    $temperature = $result['main']['temp'];
    $temperatureFelt = $result['main']['feels_like'];
    $temperatureMin = $result['main']['temp_min'];
    $temperatureMax = $result['main']['temp_max'];

    $description = $result['weather'][0]['description'];
    $humidty = $result['main']['humidity'];
    $cloudiness = $result['clouds']['all'];
    $iconURL = $result['weather'][0]['icon'];
    $iconURL = "https://openweathermap.org/img/wn/$iconURL.png"; //icon@2x.png also

    $windSpeed = $result['wind']['speed'];
    $windDirection = $result['wind']['deg'];

    $pressure = $result['main']['pressure'];

    $sunrise = $result['sys']['sunrise'];
    $sunset = $result['sys']['sunset'];

    $sunrise = date("H:i", $sunrise);
    $sunset = date("H:i", $sunset);
} else {
    //API error
    $_SESSION['error'] = "Can't find the city, check spelling.";
    header("Location: ../index.php");
}
?>
<?php require('../includes/header.php') ?>
    <main id="main">
        <div class="result flex">
        <h2><?=$city?>, <?=$timeOfData?></h2>
            <div class="result-wrapper flex">
                <div class="info-temperature">
                    <p>
                        <?=$translations['result-temp']?><span class="data-numbers"><b><?=$temperature?></b> °C</span><br>
                        <?=$translations['result-temp-felt']?><span class="data-numbers"><b><?=$temperatureFelt?></b> °C</span><br>
                        <?=$translations['result-temp-min']?><span class="data-numbers"><b><?=$temperatureMin?></b> °C</span><br>
                        <?=$translations['result-temp-max']?><span class="data-numbers"><b><?=$temperatureMax?></b> °C</span>
                    </p>
                </div>
                <div class="info-wind">
                    <p>
                        <?=$translations['result-wind']?><span class="data-numbers"><b><?=$windSpeed?></b> m/s</span>
                    </p>
                    <div id="image-container">
                        <img class="background-image" src="/images/compass.png" alt="compass, showing in clockwise order: North, East, South, West">
                        <img id="wind-arrow" src="/images/arrow.png" alt="arrow pointed towards <?=$windDirection?> degress from south clockwise" style="
                            position: absolute;
                            left: 50%;
                            top: 50%;
                            transform: translate(-50%, -50%) rotate(<?=$windDirection?>deg);
                            width: 50%;
                            height: 50%;
                            transform-origin: center;
                            ">
                    </div>
                </div>
            </div>
            <div class="result-wrapper flex">
                <div class="info-weather">
                    <h3><?=$description?></h3>
                    <div>
                        <img src=<?=$iconURL?> alt=<?=$description?>>
                    </div>
                    <p>
                        
                        <?=$translations['result-weather-hum']?><span class="data-numbers"><b><?=$humidty?></b>%</span><br>
                        <?=$translations['result-weather-clo']?><span class="data-numbers"><b><?=$cloudiness?></b>%</span>
                    </p>
                    <p><?=$translations['result-pressure']?><span class="data-numbers"><b><?=$pressure?></b> hPa</span></p>
                </div>
            </div>
        </div>
    </main>
    <style>

    </style>
<?php require('../includes/footer.php') ?>
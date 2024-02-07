<?php
session_start();
if (!isset($_GET["city"])) {
    header("Location: ../index.php");
}
define("API_KEY", "1a59599823b73a08ff71aba0ad51f85c");
//Translation handling
if (isset($_COOKIE["lang"])) {
    $lang = $_COOKIE["lang"];
    $translationFile = '../lang/'.$_COOKIE["lang"].'.json';
    $translations = json_decode(file_get_contents($translationFile), true);

    echo "cookie is existent with value: ".$_COOKIE["lang"];
    echo "<br>";
    echo "The file is $translationFile";
} else {
    //create cookie for one week, base value = browser's language
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); 
    $translationFile = '../lang/'.$lang.'.json';
    $translations = json_decode(file_get_contents($translationFile), true);

    setcookie("lang", $value, time() + (60 * 60 * 24 * 7),"/");

    echo "cookie created with value: ".$value;   
}
//Sanitize and Capitalize city name
$city = $_GET['city'];
$city= preg_replace("/[^a-zA-Z0-9ąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s]+/", "", $city);
$city = ucfirst($city);

$apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=" . API_KEY. "&lang=$lang&units=metric";

$headers = get_headers($apiUrl);
if (strpos($headers[0], '200') !== false) {
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);    

    $timeOfData = date("H:i", $data['dt']);

    $temperature = $data['main']['temp'];
    $temperatureFelt = $data['main']['feels_like'];
    $temperatureMin = $data['main']['temp_min'];
    $temperatureMax = $data['main']['temp_max'];

    $description = $data['weather'][0]['description'];
    $humidty = $data['main']['humidity'];
    $cloudiness = $data['clouds']['all'];
    $iconURL = $data['weather'][0]['icon'];
    $iconURL = "https://openweathermap.org/img/wn/$iconURL.png"; //icon@2x.png also

    $windSpeed = $data['wind']['speed'];
    $windDirection = $data['wind']['deg'];

    $pressure = $data['main']['pressure'];

    $sunrise = $data['sys']['sunrise'];
    $sunset = $data['sys']['sunset'];

    $sunrise = date("H:i", $sunrise);
    $sunset = date("H:i", $sunset);
} else {
    // Handle API error
    $_SESSION['error'] = "Can't find the city, check spelling.";
    header("Location: ../index.php");
}
?>
<?php require('../includes/header.php') ?>
    <main>
        <div class="result">
            <h2><?=$translations['result-title']?><?=$city?>, <?=$translations['result-title1']?><?=$timeOfData?> UTC</h2>
            <div id="info-temperature">
                <p>
                    <?=$translations['result-temp']?><?=$temperature?> °C<br>
                    <?=$translations['result-temp-felt']?><?=$temperatureFelt?> °C<br>
                    <?=$translations['result-temp-min']?><?=$temperatureMin?> °C<br>
                    <?=$translations['result-temp-max']?><?=$temperatureMax?> °C
                </p>
            </div>
            <hr>
            <div id="info-weather">
                <p>
                    <img src=<?=$iconURL?> alt=<?=$description?>> <br>
                    <?=$translations['result-weather']?><?=$description?> <br>
                    <?=$translations['result-weather-hum']?><?=$humidty?>% <br>
                    <?=$translations['result-weather-clo']?><?=$cloudiness?>%
                </p>
            </div>
            <hr>
            <div id="info-wind">
                <p>
                    <?=$translations['result-wind']?><?=$windSpeed?> m/s <br>
                    <?=$translations['result-wind-dir']?>
                </p>
                <img id="wind-arrow" src="/images/arrow.png" style="transform: rotate(<?=$windDirection?>deg)">
            </div>
            <hr>
            <div class="pressure">
                <p><?=$translations['result-pressure']?><?=$pressure?> hPa</p>
            </div>
            <hr>
            <div class="suntimes">
                <p>
                    <?=$translations['result-sun-rise']?><?=$sunrise?> UTC <br>
                    <?=$translations['result-sun-set']?><?=$sunset?> UTC
                </p>
            </div>
        </div>
    </main>
<?php require('../includes/footer.php') ?>
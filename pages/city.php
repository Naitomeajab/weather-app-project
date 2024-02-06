<?php
session_start();
if (!isset($_GET["city"])) {
    header("Location: ../index.php");
}
define("API_KEY", "1a59599823b73a08ff71aba0ad51f85c");
$city = ucfirst($_GET['city']);
$lang = 'en';

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
            <h2>Current weather for <?=$city?>, time of update: <?=$timeOfData?> UTC</h2>
            <div id="info-temperature">
                <p>
                    Temperature: <?=$temperature?> °C<br>
                    Feels like: <?=$temperatureFelt?> °C<br>
                    Minimal temperature: <?=$temperatureMin?> °C<br>
                    Maximum temperature: <?=$temperatureMax?> °C
                </p>
            </div>
            <hr>
            <div id="info-weather">
                <p>
                    <img src=<?=$iconURL?> alt=<?=$description?>> <br>
                    Weather description: <?=$description?> <br>
                    Humidity: <?=$humidty?>% <br>
                    Cloudiness: <?=$cloudiness?>%
                </p>
            </div>
            <hr>
            <div id="info-wind">
                <p>
                    Wind speed: <?=$windSpeed?> m/s <br>
                    Wind direction:
                </p>
                <img id="wind-arrow" src="/images/arrow.png" style="transform: rotate(<?=$windDirection?>deg)">
            </div>
            <hr>
            <div class="pressure">
                <p>Pressure: <?=$pressure?> hPa</p>
            </div>
            <hr>
            <div class="suntimes">
                <p>
                    Sunrise: <?=$sunrise?> UTC <br>
                    Sunset: <?=$sunset?> UTC
                </p>
            </div>
        </div>
    </main>
<?php require('../includes/footer.php') ?>
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

$apiUrl = "http://api.openweathermap.org/data/2.5/forecast?q=$city&appid=".API_KEY."&lang=$lang&units=metric";

$headers = get_headers($apiUrl);
if (strpos($headers[0], '200') !== false) {
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);    

    //Sort results by days and then by hours, assign them numbers.
    $groupedResults = [];
    $dayNumber = 0;
    $hourNumber = 0;
    $previousDate = null;
    foreach ($data['list'] as $item) {
        $date = substr($item['dt_txt'], 0, 10);
        $hour = substr($item['dt_txt'], 11, 2);
        
        if ($date != $previousDate) {
            $dayNumber++;
            $hourNumber = 1;

            // echo "New date: ".$date." Date number: ".$dayNumber."<br>";
        }
        if (!isset($groupedResults[$dayNumber][$hourNumber])) {
            $groupedResults[$dayNumber][$hourNumber] = $item;
        }

        // echo "New hour: ".$hourNumber."<br>";

        $previousDate = $date;
        $hourNumber++;
    }  
} else {
    //API error
    $_SESSION['error'] = "Can't find the city, check spelling.";
    header("Location: ../index.php");
}
?>
<?php require('../includes/header.php') ?>
    <main class="flex" id="main">
        <?php
        for($i = 1; $i <= count($groupedResults); $i++) {
        ?>
        
        <div id="forecast-header-<?=$i?>" class="forecast-header flex">
            <h3>
                <!-- Getting date name -->
                <?php
                $forecastDate = strtotime($groupedResults[$i][1]["dt_txt"]);
                $dayName = date('D', $forecastDate);
                $dayNumber = date('j', $forecastDate);
                $monthName = date('M', $forecastDate);
                echo $translations['day'][$dayName].", ".$dayNumber." ".$translations['month'][$monthName];
                ?>
            </h3>
            <button onclick="expandList(<?=$i?>)" id="forecast-list-icon-<?=$i?>"><i class="bi bi-caret-right-fill"></i></button>
        </div>

        <?php
        for($j = 1; $j <= count($groupedResults[$i]); $j++){
            $result = $groupedResults[$i][$j];

            $timeOfData = date("H:i", $result['dt']);
            // $timeOfData = $result['dt_txt'];

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
        ?>

        <div class="forecast-block forecast-block-<?=$i?> result flex">
            <h2><?=$city?>, <?=$timeOfData?></h2>
            <div class="result-wrapper flex">
                <div class="info-temperature">
                    <p>
                        <?=$translations['result-temp']?><?=$temperature?> °C<br>
                        <?=$translations['result-temp-felt']?><?=$temperatureFelt?> °C<br>
                        <?=$translations['result-temp-min']?><?=$temperatureMin?> °C<br>
                        <?=$translations['result-temp-max']?><?=$temperatureMax?> °C
                    </p>
                </div>
                <div class="info-wind">
                    <p>
                        <?=$translations['result-wind']?><?=$windSpeed?> m/s <br>
                        <?=$translations['result-wind-dir']?>
                    </p>
                    <div id="image-container">
                        <img class="background-image" src="/images/compass.png">
                        <img id="wind-arrow" src="/images/arrow.png" style="
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
                    <img src=<?=$iconURL?> alt=<?=$description?>> <br>
                    <p>
                        <?=$translations['result-weather']?><?=$description?> <br>
                        <?=$translations['result-weather-hum']?><?=$humidty?>% <br>
                        <?=$translations['result-weather-clo']?><?=$cloudiness?>%
                    </p>
                    <p><?=$translations['result-pressure']?><?=$pressure?> hPa</p>
                </div>
            </div>
        </div>

        <?php
            }
        }
        ?>
    </main>
<?php require('../includes/footer.php') ?>
<?php
session_start();
if (!isset($_GET["city"])) {
    header("Location: ../index.php");
}
$apiKey = '1a59599823b73a08ff71aba0ad51f85c';
$city = ucfirst($_GET['city']);
$lang = 'en';

$apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&lang=$lang&units=metric";

$headers = get_headers($apiUrl);

if (strpos($headers[0], '200') !== false) {
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);    

    $temperature = $data['main']['temp'];
    $temperatureMin = $data['main']['temp_min'];
    $temperatureMax = $data['main']['temp_max'];

    $description = $data['weather'][0]['description'];
    $humidty = $data['main']['humidity'];

    $pressure = $data['main']['pressure'];

    $iconURL = $data['weather'][0]['icon'];
    $iconURL = "https://openweathermap.org/img/wn/$iconURL.png"; //icon@2x.png also
} else {
    // Handle API error
    $_SESSION['error'] = "Can't find the city, check spelling.";
    header("Location: ../index.php");
}
?>
<?php require('../includes/header.php') ?>
    <main>
        <div class="result">
            <h2>Current weather for <?=$city?>:</h2>
            <p>
                Temperature: <?=$temperature?> °C<br>
                Minimal temperature: <?=$temperatureMin?> °C<br>
                Maximum temperature: <?=$temperatureMax?> °C
            </p>
            <img src=<?=$iconURL?> alt=<?=$description?>>
            <p>
                Weather description: <?=$description?><br>
                Humidity: <?=$humidty?>%
            </p>
            <p>Pressure: <?=$pressure?>hPa</p>
        </div>
    </main>
<?php require('../includes/footer.php') ?>
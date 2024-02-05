<?php
session_start();
if (!isset($_GET["city"])) {
    header("Location: ../index.php");
}
$apiKey = '1a59599823b73a08ff71aba0ad51f85c';
$city = ucfirst($_GET['city']);
$lang = 'en';
$userIP = $_SERVER['REMOTE_ADDR'];

$apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&lang=$lang&units=metric";

$headers = get_headers($apiUrl);

if (strpos($headers[0], '200') !== false) {
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);    

    echo "<h1>$city</h1>";

    $temperature = $data['main']['temp'];
    $description = $data['weather'][0]['description'];

    if (isset($temperature)) {
        echo "Temperature: $temperature °C, Description: $description";
    } else {
        echo "Temperature data not available.";
    }
} else {
    // Handle API error
    $_SESSION['error'] = "Can't find the city, check spelling.";
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/main.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather app - Naitomea</title>
</head>
<body>
    <div class="wrapper flex">
        <header>
            <h1>Naitomea's Weather App</h1>
        </header>
        <nav>
            <form action="../php/city.php" method="GET">
                <input type="text" role="search" placeholder="Wheather in the city" name="city">
                <button><i class="bi bi-search"></i></button>
            </form>
        </nav>
        <main>
        </main>
        <footer>
            <p>
                <a href="https://github.com/Naitomeajab/weather-app-project">Github code</a>
                <br>
                data provided by: <a href="https://openweathermap.org/">OpenWeather</a>
            </p>
        </footer>
    </div>
</body>
</html>
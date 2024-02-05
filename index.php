<?php
session_start();
if(isset($_SESSION["error"])){
    echo $_SESSION["error"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/main.css">
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
            <form action="php/city.php" method="GET">
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
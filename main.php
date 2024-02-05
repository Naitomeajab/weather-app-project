<?php

// $apiKey = '1a59599823b73a08ff71aba0ad51f85c';
// $city = 'Białystok'; // Replace with your desired city
// $lang = 'pl';

// $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&lang=$lang";

// $response = file_get_contents($apiUrl);
// $data = json_decode($response, true);

// if ($data['cod'] == 200) {
//     echo "<h1>$city</h1>";
//     // Weather data is available
//     $temperature = $data['main']['temp'];
//     $temperature -= 273.15;
//     $description = $data['weather'][0]['description'];

//     if (isset($temperature)) {
//         echo "Temperature: $temperature °C, Description: $description";
//     } else {
//         echo "Temperature data not available.";
//     }
// } else {
//     // Handle API error
//     echo "Error: Unable to fetch weather data.";
// }
?>

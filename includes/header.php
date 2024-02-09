<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="/css/main.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$translations["title"]?></title>
</head>
<body>
    <div class="wrapper flex">
        <header>
            <a href="/index.php"><img src="/images/Logo.png"></a>
        </header>
        <nav>
            <form action="/pages/city.php" method="GET">
                <input type="text" role="search" placeholder=<?=$translations['search-placeholder']?> name="city">
                <button type="submit"><i class="bi bi-search"></i></button>
            </form>
            <br>
            <button onclick="changeLanguage('pl')" class="lang-button"><img src="/images/pl.jpg" width="100%" height="100%"></button>
            <button onclick="changeLanguage('en')" class="lang-button"><img src="/images/en.jpg" width="100%" height="100%"></button>
            <button onclick="redirect('city.php')">city.php</button>
            <button onclick="redirect('forecast.php')">forecast.php</button>
        </nav>
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
                <button><i class="bi bi-search"></i></button>
            </form>
            <button onclick="changeLanguage('pl')"><img src="/images/pl.jpg" width="25%" height="25%"></button>
            <button onclick="changeLanguage('en')"><img src="/images/en.jpg" width="25%" height="25%"></button>
        </nav>
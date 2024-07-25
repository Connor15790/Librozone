<?php
    session_start();
    include 'partials/_dbconnect.php';

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true) {
        header("location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/about.css">
    <title>About</title>
</head>
<body>
    <?php require 'partials/_navbar.php' ?>

    <div class="container">
        <h1 class="abouttext">About LibroZone</h1>

        <p class="aboutbody my-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nihil quam possimus reprehenderit soluta error pariatur praesentium! Consequatur aliquid cumque earum animi! Deserunt mollitia exercitationem libero autem nesciunt error ab corporis iure earum labore, impedit, asperiores modi id tempore consectetur, alias consequatur? Ducimus ad in necessitatibus, impedit mollitia iste repellendus nobis? Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptate reiciendis reprehenderit veniam eligendi totam dicta assumenda optio ipsum consequuntur expedita nihil quos asperiores veritatis, consectetur quas vero nobis soluta illo commodi. Cumque quibusdam officiis voluptatibus, illo labore hic laudantium delectus doloremque commodi fuga impedit, nemo repudiandae voluptatem, voluptates quo molestias!</p>
    </div>

    <?php require 'partials/_footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
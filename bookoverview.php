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
    <link rel="stylesheet" href="./styles/bookoverview.css">
    <title>BookDemo</title>
</head>
<body>
    <?php require 'partials/_navbar.php' ?>

    <?php
        if (isset($_GET['id'])) {
            $book_id = $_GET['id'];

            // echo $book_id;

            $sql = "SELECT * FROM `books` WHERE `book_id` = $book_id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            
            $book_name = $row['book_name'];
            $book_author = $row['book_author'];
            $book_img = $row['book_image'];
            $book_overview = $row['book_overview'];
            // echo $book_name;
            // echo $book_author;
            // echo $book_img;
        }
    ?>

    <div class="container">
        <h1 class="book_name"><?php echo $book_name?></h1>
        <h5 class="author_name"><?php echo $book_author?></h5>
        <div class="overviewcontainer">
            <div class="overviewbody">
                <h3 class="overviewtext my-4">Overview</h3>
                <p class="overview px-5 py-4" style="border: 2px solid white;"><?php echo $book_overview?></p>
            </div>
            <div class="imgcontainer my-5">
                <img style="height: 300px; margin: auto; border: 2px solid white; border-radius: 20px; margin-top: 34px;" src="<?php echo $book_img?>" class="d-flex" alt="alt1">
            </div>
        </div>
    </div>

    <?php require 'partials/_footer.php' ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/myacc.css">
    <title>Account</title>
</head>
<body>
    <?php require 'partials/_navbar.php' ?>
    <?php require 'partials/_dbconnect.php' ?>

    <div class="container">
        <h1 class="savedbooktext">Saved Books:</h1>

        <?php
            $sql = "SELECT * FROM `shelf` WHERE user_id='" . $_SESSION['user_id'] . "'";
            $result = mysqli_query($conn, $sql);

            $serial_number = 1;
            
            while ($row = mysqli_fetch_assoc($result)) {
                $book_id = $row['book_id'];
                // echo '<h1>' . $book_id . '</h1>';
                $sql1 = "SELECT * FROM `books` WHERE book_id='" . $book_id . "'";
                $result1 = mysqli_query($conn, $sql1);
                while ($row1 = mysqli_fetch_assoc($result1)) {
                    $book_name = $row1['book_name'];
                    $book_id = $row1['book_id'];
                    echo '
                        <div class="cardcontainer d-flex py-4 my-4" style="border: 2px solid white; margin: auto; align-items: center; background-color: #332D2D; border-radius: 10px; justify-content: space-between;">
                            <div class="d-flex mx-3" >
                                <h4 class="px-3" style="color: white;">' . $serial_number . '.</h4>
                                <h4 style="color: white;">' . $book_name . '</h4>
                            </div>
                            <div class="d-flex mx-5">
                                <a href="/librozone/bookoverview.php?id=' . $book_id . '" type="button" class="btn btn-dark btn-lg black-background1 white1">
                                    Read
                                    <img src="./assets/read.png" alt="Logo" width="28" height="28" class="d-inline-block align-text-top ms-2">
                                </a>
                            </div>
                        </div>
                    ';
                    $serial_number++;
                }
            }
        ?>
    </div>

    <?php require 'partials/_footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
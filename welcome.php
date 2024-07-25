<?php
    session_start();
    include 'partials/_dbconnect.php';

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true) {
        header("location: login.php");
        exit;
    }

    function addToCart($conn, $user_id, $book_id) {
        // Check if the item is already in the cart
        $stmt = $conn->prepare("SELECT shelf_id FROM shelf WHERE user_id = ? AND book_id = ?");
        $stmt->bind_param("ii", $user_id, $book_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // If item is already in the cart, do nothing or handle it accordingly
            echo "Item is already in your cart.";
        } else {
            // Insert new item into cart with default quantity of 1
            $stmt = $conn->prepare("INSERT INTO shelf (user_id, book_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $user_id, $book_id);
            $stmt->execute();
            // echo "Item added to cart.";
        }

        $stmt->close();
    }

    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'])) {
        $book_id = $_POST['book_id'];
        addToCart($conn, $user_id, $book_id);
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/welcome.css">
    <title>Welcome - <?php echo $_SESSION['username'] ?></title>
</head>

<body>
    <?php require 'partials/_navbar.php' ?>
    <?php require 'partials/_dbconnect.php' ?>

    <!-- <img class="bg1" src="./assets/bookbg.jpg" alt="IIT Kharagpur" style="width: 100%; position: absolute; z-index: -1; opacity: 0.9;background-attachment: fixed; background-repeat: no-repeat;"> -->
    <div class="container">
        <h1 class="welcometext">Welcome to LibroZone - <?php echo $_SESSION['username']; ?></h1>
        <div class="catcontainer">
            <?php
            $sql = "SELECT * FROM `categories`";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $cat = $row["category_name"];
                $category_id = $row["category_id"];
                echo '<div class="my-2 mx-2">
                            <a href="/librozone/catpage.php?id=' . $category_id . '" class="btn btn-dark btn-lg px-4">' . $cat . '</a>
                        </div>';
            }
            ?>
        </div>

        <!-- <div class="my-5">
            <button type="button" class="btn btn-success btn-lg px-4 me-2">
                Get Your Card
                <img src="./assets/id-card.png" alt="Logo" width="30" height="28" class="d-inline-block align-text-top ms-2">
            </button>
            <button type="button" class="btn btn-primary btn-lg px-4 ms-2">
                Renew Your Card
                <img src="./assets/id-renew.png" alt="Logo" width="30" height="28" class="d-inline-block align-text-top ms-2">
            </button>
        </div> -->

        <div id="carouselExampleIndicators" class="carousel slide my-4">
            <p class="specialoffertext">Popular Right Now</p>
            <div class="carousel-inner my-1" style="background-color: black; width: 80%; margin: auto; border-radius: 20px; border: 2px solid white; text-shadow: 2px 2px 5px black;">


            <div class="carousel-item active my-3" style="width: 100%;">
                <img style="height: 300px;  margin: auto;" src="./assets/donquixote.png" class="d-block" alt="alt1">
                <div class="d-flex mx-5 pt-3" style="justify-content: space-between">
                    <a href="/librozone/bookoverview.php?id=1" type="button" class="btn btn-dark btn-lg black-background1 white1">
                        Read
                        <img src="./assets/read.png" alt="Logo" width="28" height="28" class="d-inline-block align-text-top ms-2">
                    </a>
                    <button type="button" class="btn btn-primary btn-lg black-background2 white2">
                        Rate
                        <img src="./assets/star.png" alt="Logo" width="25" height="25" class="d-inline-block align-text-top ms-2">
                    </button>
                    <form action="" method="POST">
                        <input type="hidden" name="book_id" value="1">
                        <button type="submit" class="btn btn-success btn-lg">
                            Save +
                        </button>
                    </form>
                </div>
            </div>
            
            <?php
                $sql = 'SELECT * FROM `specialoffers`';
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $bookimg = $row['bookimg'];
                    $offervalue = $row['offervalue'];
                    $specoffer_id = $row['specoffer_id'];
                    // Start the loop from here
                    echo '
                        <div class="carousel-item my-3" style="width: 100%;">
                            <img style="height: 300px;  margin: auto;" src="' . $bookimg . '" class="d-block" alt="alt1">
                            <div class="d-flex mx-5 pt-3" style="justify-content: space-between">
                                <a href="/librozone/bookoverview.php?id=' . $specoffer_id . '" type="button" class="btn btn-dark btn-lg black-background1 white1">
                                    Read
                                    <img src="./assets/read.png" alt="Logo" width="28" height="28" class="d-inline-block align-text-top ms-2">
                                </a>
                                <button type="button" class="btn btn-primary btn-lg black-background2 white2">
                                    Rate
                                    <img src="./assets/star.png" alt="Logo" width="25" height="25" class="d-inline-block align-text-top ms-2">
                                </button>
                                <form action="" method="POST">
                                    <input type="hidden" name="book_id" value="' . $specoffer_id . '">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        Save +
                                    </button>
                                </form>
                            </div>
                        </div>
                    ';
                }
            ?>    
                
            </div>
            <button class="carousel-control-prev mt-5" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next mt-5" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

    </div>

    <?php require 'partials/_footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>
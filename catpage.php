<?php
    session_start();
    include 'partials/_dbconnect.php';

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
    <link rel="stylesheet" href="./styles/catpage.css">
    <title>CatPage</title>
</head>

<body>
    <?php require 'partials/_navbar.php' ?>

    <div class="container">
        <?php
            // Connect to the database
            include 'partials/_dbconnect.php';

            if (isset($_GET['id'])) {
                $category_id = $_GET['id'];
                
                // Fetch category information
                $sql = "SELECT * FROM `categories` WHERE `category_id` = $category_id";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $category_name = $row['category_name'];

                $serial_number = 1;
                
                // Display category-specific content
                // echo "<h1>" . $row["category_name"] . "</h1>";
                // Add more code here to display category-specific content

                $booksql = "SELECT * FROM `books` WHERE `category` = '$category_name'";
                $result = mysqli_query($conn, $booksql);

                echo '<h1 class="welcometext">' . $category_name . '</h1>';
                while ($row = mysqli_fetch_assoc($result)) {
                    $book_name = $row['book_name'];
                    $book_id = $row['book_id'];
                    echo '
                        <div class="cardcontainer d-flex py-4 my-4" style="border: 2px solid white; margin: auto; align-items: center; background-color: #332D2D; border-radius: 10px; justify-content: space-between;">
                            <div class="d-flex mx-3" >
                                <h4 class="px-3" style="color: white;">' . $serial_number . '.</h4>
                                <h4 style="color: white;">' . $book_name . '</h4>
                            </div>
                            <div class="d-flex mx-4">
                                <a href="/librozone/bookoverview.php?id=' . $book_id . '" type="button" class="btn btn-dark btn-lg mx-2 black-background1 white1">
                                    Read
                                    <img src="./assets/read.png" alt="Logo" width="28" height="28" class="d-inline-block align-text-top ms-2">
                                </a>
                                <button type="button" class="btn btn-primary btn-lg mx-2 black-background2 white2">
                                    Rate
                                    <img src="./assets/star.png" alt="Logo" width="25" height="25" class="d-inline-block align-text-top ms-2">
                                </button>
                                <form action="" method="POST">
                                    <input type="hidden" name="book_id" value="' . $book_id . '">
                                    <button type="submit" class="btn btn-success btn-lg mx-2">
                                        Save +
                                    </button>
                                </form>
                            </div>
                        </div>
                    ';
                    $serial_number++;
                }
            } else {
                echo "No category selected.";
            }
        ?>
    </div>

    <?php require 'partials/_footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>
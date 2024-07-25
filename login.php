<?php
session_start();

$login = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $user_id = $_POST["user_id"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $book_id = $_POST["book_id"];

    // $sql = "Select * from users where username='$username' AND password='$password'";
    // $sql = "Select * from users where username='$username'";
    // $result = mysqli_query($conn, $sql);
    // $num = mysqli_num_rows($result);

    // if ($num == 1) {
    //     while ($row = mysqli_fetch_assoc($result)) {
    //         if (password_verify($password, $row['password'])) {
    //             $login = true;
    //             session_start();
    //             $_SESSION['loggedin'] = true;
    //             $_SESSION['username'] = $username;
    //             $_SESSION['user_id'] = $user_id;
    //             header("location: welcome.php");
    //         } else {
    //             $showError = "Invalid Credentials";
    //         }
    //     }
    // } else {
    //     $showError = "Invalid Credentials";
    // }

    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $book_id = $_POST["book_id"];
            header("Location: welcome.php");
        } else {
            $showError = "Invalid Credentials";
        }
    } else {
        $showError = "Invalid Credentials";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>LibroZone</title>
</head>

<body>
    <?php require 'partials/_navbar.php' ?>

    <?php
    if ($showError) {
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> ' . $showError . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> ';
    }
    ?>

    <div class="container">
        <h1 class="text-center mt-5">Login to LibroZone</h1>
        <form action="/librozone/login.php" method="post" style="display: flex; flex-direction: column; align-items: center">
            <div class="mt-4 mb-3 col-md-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" maxlength="20" class="form-control" id="username" name="username" aria-describedby="emailHelp">
            </div>
            <div class="mb-3 col-md-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" maxlength="255" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Login</button>
        </form>
    </div>

    <?php require 'partials/_footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <script>
        // JavaScript to hide alerts after 3 seconds
        setTimeout(function() {
            var alertElement = document.querySelector('.alert');
            if (alertElement) {
                alertElement.classList.remove('show');
                alertElement.classList.add('fade');
            }
        }, 3000);
    </script>
</body>

</html>
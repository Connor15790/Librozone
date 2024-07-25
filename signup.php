<?php
    session_start();

    $showAlert = false;
    $showError = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'partials/_dbconnect.php';

        $username = $_POST["username"];
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        // $exists = false;

        $existssql = "SELECT * FROM `users` WHERE username='$username'";
        $result = mysqli_query($conn, $existssql);
        $existsNumRows = mysqli_num_rows($result);
        if ($existsNumRows > 0) {
            $showError = "Username already exists!";
        } else {
            if ($password == $cpassword) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users` (`username`, `password`, `date`) VALUES ('$username', '$hash', current_timestamp())";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    $_SESSION['alert'] = [
                        'type' => 'success',
                        'message' => 'Your account has been created and you can login!'
                    ];
                    header("location: login.php");
                    exit();
                }
            } else {
                $showError = "Passwords do not match!";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>LibroZone</title>
</head>

<body>
    <?php require 'partials/_navbar.php' ?>

    <?php
    if ($showAlert) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                    <strong>Success!</strong> Your account has been created and you can login!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }

    if ($showError) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
                    <strong>Error!</strong> ' . $showError . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
    ?>

    <div class="container">
        <h1 class="text-center mt-5">SignUp to LibroZone</h1>
        <form action="/librozone/signup.php" method="post"
            style="display: flex; flex-direction: column; align-items: center">
            <div class="mt-4 mb-3 col-md-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" maxlength="20" class="form-control" id="username" name="username" aria-describedby="emailHelp">
            </div>
            <div class="mb-3 col-md-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" maxlength="255" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3 col-md-4">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" maxlength="255" class="form-control" id="cpassword" name="cpassword">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
    </div>

    <?php require 'partials/_footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>

    <script>
        // JavaScript to hide alerts after 3 seconds
        setTimeout(function () {
            var successAlert = document.getElementById('successAlert');
            if (successAlert) {
                successAlert.classList.remove('show');
                successAlert.classList.add('fade');
            }
            var errorAlert = document.getElementById('errorAlert');
            if (errorAlert) {
                errorAlert.classList.remove('show');
                errorAlert.classList.add('fade');
            }
        }, 3000);
    </script>
</body>

</html>
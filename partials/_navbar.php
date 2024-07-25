<?php
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
        $loggedin = true;
    } else {
        $loggedin = false;
    }

    echo '<nav class="navbar navbar-expand-lg navbar-fixed-top" style="background-color: #e3f2fd;">
            <div class="container-fluid">
                <a class="navbar-brand" href="/librozone">
                    <img src="./assets/book.png" alt="Logo" width="30" height="24"
                        class="d-inline-block align-text-top">
                    LibroZone
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/librozone/welcome.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/librozone/about.php">About</a>
                        </li>';
                        if ($loggedin == true) {
                            echo '<li class="nav-item">
                                    <a class="nav-link" href="/librozone/myacc.php">'. $_SESSION['username'] . '</a>
                                </li>';
                        }
                echo '</ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-primary mx-2" type="submit">Search</button>';
                if (!$loggedin) {
                    echo '<a href="/librozone/login.php" class="btn btn-outline-primary mx-2">Login</a>
                            <a href="/librozone/signup.php" class="btn btn-outline-primary mx-2" type="submit">Signup</a>';
                    }
                if ($loggedin) {
                    echo '<a href="/librozone/logout.php" class="btn btn-outline-primary mx-2" type="submit">Logout</a>';
                }
                
                echo '</form>
                </div>
            </div>
        </nav>';
<?php
include('conn.php');
session_start();

if (!empty($_SESSION['email'])) {
    if ($_SESSION['role'] == 1) {
        header('Location: admindashboard.php');
    } else {
        header('Location: userdashboard.php');
    }
}

?>
<?php

$wrongDetails = "";
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'";
    $res = mysqli_query($conn, $sql);
    try {
        if ($res &&  mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];
            if ($row['role'] == 1) {
                header('Location: admindashboard.php');
            } else {
                header('Location: userdashboard.php');
            }
        } else {
            $wrongDetails = "Please enter correct deatils";
        }
    } catch (Exception $e) {
        echo $e;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>USER LOGIN</title>
    <style>
        body {
            width: 100vw;
            height: 100vh;
            background: url('https://media.istockphoto.com/id/1279502184/photo/project-management-concept-with-gantt-chart.jpg?s=1024x1024&w=is&k=20&c=QSufo-YfpQBREJkc2zAqVj8PUxrOwpkGIfnTMHwDViY=');
        }
    </style>
</head>

<body>

    <section class="main-section h-100 w-100 d-flex align-items-center justify-content-center">
        <div class="main-content bg-light w-50 text-dark m-5 p-5">
            <div class="main-content-container">

                <form action="" method="post">
                    <div class=" fs-3 fw-bold d-flex">USER LOGIN FORM</div>

                    <div class="form-group my-2">
                        <label for="email">Enter email : </label>
                        <input required type="email" name="email" id="email" class="form-control" placeholder="email@email.com" aria-describedby="helpId">
                    </div>

                    <div class="form-group my-2">
                        <label for="password">Enter password : </label>
                        <input required type="password" name="password" id="password" class="form-control" placeholder="password" aria-describedby="helpId">
                    </div>

                    <div class="form-group my-3">
                        <button name="submit" class="btn btn-success btn-sm" type="submit" href="#" role="button">SUBMIT</button>
                        <a class="btn btn-info text-light btn-sm" href="index.php">HOME</a>
                    </div>

                    <div class="form-group">
                        <p class="text-danger"><?= $wrongDetails; ?></p>
                    </div>

                </form>

            </div>
        </div>
    </section>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
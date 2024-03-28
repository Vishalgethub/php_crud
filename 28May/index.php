<?php 

session_start();

if (!empty($_SESSION['email'])) {
    if ($_SESSION['role'] == 1) {
        header('Location: userdashboard.php');
    } else {
        header('Location: userdashboard.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>TMS</title>
    <style>

    </style>
</head>

<body>

    <section class="main-section h-100 w-100 d-flex align-items-center justify-content-center">
        <div class="main-content bg-light w-50 text-dark m-5 p-5">
          <div class="main-content-container">
          <div class="main-content-header fs-3 fw-bold  d-flex align-items-center justify-content-center">CHOOSE ROLE
                TO LOGIN</div>
            <div class="main-content-row row my-5 mx-2 w-100 align-items-center justify-content-center">
                <div class="col-md-4 user-login-container">
                    <a class="btn btn-primary btn-sm" href="userlogin.php">USER LOGIN</a>
                </div>
                <div class="col-md-4 user-registration-conatiner">
                    <a class="btn btn-success btn-sm" href="userregister.php">USER REGISTER</a>
                </div>
            </div>
          </div>
        </div>
    </section>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
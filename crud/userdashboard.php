<?php

session_start();
if (empty($_SESSION['email'])) {
    
    header('Location: userlogin.php');
} else {
    if ($_SESSION['role'] == 2) {
        $tabs = array(
            '<a id="dashboardTab" href="#" class="list-group-item list-group-item-action active">
            <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Main dashboard</span>
            </a>',
            '<a id="taskTab" href="#" class="list-group-item list-group-item-action">
            <i class="fas fa-chart-area fa-fw me-3"></i><span>Tasks</span>
        </a>',
            ' <a href="#" class="list-group-item list-group-item-action">
            <i class="fas fa-users fa-fw me-3"></i><span>Users</span>
        </a>',
        );
    } else if ($_SESSION['role'] == 1) {
        $tabs = array(
            '<a id="mainDashboard" href="#" class="list-group-item list-group-item-action active">
            <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Main dashboard</span>
            </a>',
            '<a id="taskTab" href="#" class="list-group-item list-group-item-action">
            <i class="fas fa-chart-area fa-fw me-3"></i><span>Tasks</span>
        </a>',
            '<a href="#" class="list-group-item list-group-item-action">
            <i class="fas fa-chart-bar fa-fw me-3"></i><span>Manage tasks</span>
        </a>',
            ' <a href="#" class="list-group-item list-group-item-action">
            <i class="fas fa-users fa-fw me-3"></i><span>Users</span>
        </a>',
        );
    }
}



if (isset($_POST['logout'])) {
    session_destroy();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FontAwesome 6.2.0 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <title>DASHBOARD</title>
</head>

<style>
    body {
        width: 100vw;
        height: 100vh;
        max-width: 1040px !important;
        margin: 0 auto;
        background: url('https://media.istockphoto.com/id/1279502184/photo/project-management-concept-with-gantt-chart.jpg?s=1024x1024&w=is&k=20&c=QSufo-YfpQBREJkc2zAqVj8PUxrOwpkGIfnTMHwDViY=');
    }

    .circle {
        width: 170px;
        height: 170px;
        line-height: 170px;
        border-radius: 50%;
        /* the magic */
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        text-align: center;
        color: white;
        font-size: 16px;
        text-transform: uppercase;
        font-weight: 700;
        margin: 0 auto 40px;
    }

    .progress {
        background-color: #d8d8d8;
        border-radius: 20px;
        position: relative;
        margin: 15px 0;
        height: 30px;
        width: 660px;
    }

    .progress-done {
        background: linear-gradient(to left, #F2709C, #FF9472);
        box-shadow: 0 3px 3px -5px #F2709C, 0 2px 5px #F2709C;
        border-radius: 20px;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        width: 0;
        opacity: 0;
        transition: 1s ease 0.3s;
    }
</style>

<body>

    <!-- Header section -->

    <div class="navbar w-100 px-2">
        <nav class="navbar navbar-expand-sm navbar-light bg-light w-100  border rounded">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <h4>TMS</h4>
                </a>
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse w-100" id="collapsibleNavId">
                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" aria-current="page"><?= $loginAdminemail ?>
                                <span class="visually-hidden">(current)</span></a>
                        </li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse w-100" id="collapsibleNavId">
                    <ul class="navbar-nav me-auto mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" aria-current="page">
                                <h5>STATUS: ONLINE</h5>
                                <span class="visually-hidden">(current)</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse" id="collapsibleNavId">
                    <ul class="navbar-nav me-auto mt-lg-0">
                        <li class="nav-item">
                            <form action="" method="post">
                                <button class="btn" type="submit" name="logout" class="nav-link active" href="#" aria-current="page">
                                    <h5>LOGOUT</h5>
                                    <span class="visually-hidden">(current)</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </div>

    <div class="main-content-section w-100">
        <!-- Sidebar section -->

        <div class="sidebar-section w-100 mx-2 d-flex">
            <!-- Hover added -->
            <div class="list-group w-25 bg-light">
                <?php
                foreach ($tabs as $tab) {
                    echo $tab;
                }
                ?>

            </div>

            <main style="width: 74.2%;" class="main-section px-2">
                <div class="main-section-content bg-light border rounded">

                    <!-- Dashboard conatiner -->
                    <div id="dashboardContainer" style="display: none;" class="dashboard-container">
                        <h3 class="py-2 px-3">DASHBOARD</h3>
                        <div class="row justify-content-center align-items-center g-2 px-3">
                            <div class="col shadow p-3 px-4 box">
                                <div class="tab-header text-light px-2 my-2 bg-info">Total tasks</div>
                                <div class="circle blue mt-4 bg-info">Blue</div>
                            </div>
                            <div class="col shadow p-3 px-4 box">
                                <div class="tab-header text-light px-2 my-2 bg-warning">Total pending</div>
                                <div class="circle blue mt-4 bg-warning">Blue</div>
                            </div>
                            <div class="col shadow p-3 px-4 box">
                                <div class="tab-header text-light px-2 my-2 bg-success">Total completed</div>
                                <div class="circle blue mt-4 bg-success">Blue</div>
                            </div>
                            <!-- <div class="col shadow p-3 px-4 box">
                                <div class="tab-header text-light px-2 my-2 bg-danger">Tasks reverted</div>
                                <div class="circle blue mt-4 bg-danger">Blue</div>
                            </div> -->
                            <div class="col shadow p-3 px-4 box">
                                <div style=" background : linear-gradient(to left, #F2709C, #FF9472);" class="tab-header text-light px-2 my-2">Progress Bar</div>
                                <div class="progress">
                                    <div class="progress-done bg-info" data-done="70">70%</div>
                                </div>
                                <div class="progress">
                                    <div class="progress-done bg-success" data-done="70">70%</div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Task conatiner -->

                    <div id="taskContainer" style="display: none;" class="task-list-conatiner">
                        <h3 class="py-2 px-3">TASKS</h3>
                        <div class="py-2 px-3 table-responsive">
                            <table class="table table-light">
                                <thead>
                                    <tr>
                                        <th scope="col">Task id</th>
                                        <th scope="col">Task Name</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Machine</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        <td scope="row">1</td>
                                        <td>CRUD</td>
                                        <td>18 hours</td>
                                        <td>Active</td>
                                        <td>Local</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <!-- Task conatiner -->

                    <div id="taskConatiner" style="display: block;" class="user-profile-conatiner">
                        <h3 class="py-2 px-3">PROFILE</h3>

                        div.

                    </div>
                </div>



            </main>

        </div>
    </div>

    <!-- (Optional) Use CSS or JS implementation -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {

            // Sidebar active class
            $('.list-group-item').on('click', function() {
                $('.list-group-item').siblings().removeClass('active');
                $(this).addClass('active');
            });

            // Sidebar tabs toggle
            $('#mainDashboard').click(function(){
                $('#dashboardContainer').css('display', 'block');
                $('#taskContainer').css('display', 'none');
            });

            $('#taskTab').click(function(){
                $('#taskContainer').css('display', 'block');
                $('#dashboardContainer').css('display', 'none');                

            });

            $('#mainDashboard').click(function(){
                $('#dashboardContainer').css('display', 'block');
            });

            $('#mainDashboard').click(function(){
                $('#dashboardContainer').css('display', 'block');
            });

            // Progresss bar width
            var processDone = $('.progress-done').attr('data-done') + '%';
            $('.progress-done').css('width', processDone);
            $('.progress-done').css('opacity', '1');

            
        });
    </script>

</body>

</html>
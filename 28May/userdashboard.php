<?php

include('conn.php');
session_start();

$totalTasks;
$pendingTasks;
$completdTasks;
$taskProgress;


if ($_SESSION['role'] == 1) {
    //Count total tasks
    $sql = "SELECT COUNT(*) FROM `task`";
    $res = mysqli_query($conn, $sql);
    $num = mysqli_fetch_array($res);
    $total = $num[0];
    $totalTasks = $total;
    // Count pending tasks
    $sql = "SELECT COUNT(*) FROM `task` WHERE status = 'pending'";
    $res = mysqli_query($conn, $sql);
    $num = mysqli_fetch_array($res);
    $total = $num[0];
    $pendingTasks = $total;
    // Completed tasks
    $sql = "SELECT COUNT(*) FROM `task` WHERE status = 'completed'";
    $res = mysqli_query($conn, $sql);
    $num = mysqli_fetch_array($res);
    $total = $num[0];
    $completdTasks = $total;
    // Task progress
    $taskProgress = $pendingTasks / $totalTasks * 100;
} else if ($_SESSION['role'] == 2) {
    //Count total tasks
    $userEmail = $_SESSION['email'];
    $sql1 = "SELECT `id` FROM `users` WHERE email = '$userEmail';";
    $res1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_assoc($res1);
    $id1 = $row1['id'];
    $sql = "SELECT COUNT(*) FROM `task` WHERE user_id = '$id1'";
    $res = mysqli_query($conn, $sql);
    $num = mysqli_fetch_array($res);
    $total = $num[0];
    $totalTasks = $total;


    // Count pending tasks
    $sql = "SELECT COUNT(*) FROM `task` WHERE user_id = '$id1' AND status = 'pending'";
    $res = mysqli_query($conn, $sql);
    $num = mysqli_fetch_array($res);
    $total = $num[0];
    $pendingTasks = $total;
    // Completed tasks
    $sql = "SELECT COUNT(*) FROM `task` WHERE user_id = '$id1' AND status = 'completed'";
    $res = mysqli_query($conn, $sql);
    $num = mysqli_fetch_array($res);
    $total = $num[0];
    $completdTasks = $total;

    // Task progress
    if ($totalTasks > 0) {
        $taskProgress = $pendingTasks / $totalTasks * 100;
    } else {
        $taskProgress = 0;
    }
}

if (empty($_SESSION['email'])) {

    header('Location: userlogin.php');
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: userlogin.php');
}

if (isset($_POST['addtask'])) {
    $taskId = $_POST['taskid'];
    $taskName = $_POST['name'];
    $taskUserId = $_POST['user'];
    $status = $_POST['status'];
    $machine = $_POST['machine'];

    $sql;

    if (empty($taskId)) {
        $sql = "INSERT INTO `task`(`name`, `user_id`, `status`, `machine`) VALUES ('$taskName','$taskUserId','$status','$machine')";
    } else {
        $sql = "UPDATE `task` SET `name`='$taskName',`user_id`='$taskUserId',`status`='$status',`machine`='$machine' WHERE id = '$taskId'";
    }

    $res = mysqli_query($conn, $sql);

    if ($res) {
        header('Location: dashboard.php');
    }
}

if (isset($_POST['edittask'])) {
    $taskId = $_POST['taskid'];
    $sql = "SELECT * FROM `task` WHERE id = $taskId";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $taskId = $row['id'];
        $taskName = $row['name'];
        $taskUser = $row['user_id'];
        $taskStatus = $row['status'];
        $taskmachine = $row['machine'];
    }
}

if (isset($_POST['deletetask'])) {
    $taskId = $_POST['taskid'];
    $sql = "DELETE FROM `task` WHERE id = '$taskId'";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        header('Location: dashboard.php');
    }
}

$userAllreadyRegistered;

if (isset($_POST['adduser'])) {
    $userId = $_POST['userid'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    $sql1 = "SELECT * FROM `users` WHERE email = '$email';";
    $res1 = mysqli_query($conn, $sql1);

    $row = $res1->fetch_assoc();

    if(is_array($row) && count($row)>0) {
        $userAllreadyRegistered = "User is allready added";

    } else {

        if (empty($userId)) {
            $sql = "INSERT INTO `users`(`name`, `email`, `password`, `phone`, `role`) 
                VALUES ('$name','$email','$password','$phone','$role')";
        } else {
            $sql = "UPDATE `users` SET `name`='$name',`email`='$email',
            `password`='$password',`phone`='$phone',`role`='$role' WHERE id = $userId";
        }

        $res = mysqli_query($conn, $sql);

        if ($res) {
            header('Location: dashboard.php');
        }
    }
}

if (isset($_POST['edituser'])) {
    $userId = $_POST['userid'];

    $sql = "SELECT * FROM `users` WHERE id = '$userId'";
    $res = mysqli_query($conn, $sql);


    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $userId = $row['id'];
        $userName = $row['name'];
        $userEmail = $row['email'];
        $userPassword = $row['password'];
        $userPhone = $row['phone'];
        $userRole = $row['role'];
    }
}

if (isset($_POST['deleteuser'])) {
    $userId = $_POST['userid'];
    $sql = "DELETE FROM `users` WHERE id = '$userId'";
    $res = mysqli_query($conn, $sql);

    if ($res) {
        header('Location: dashboard.php');
    }
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

    .activeTAb {
        display: block;
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
                if ($_SESSION['role'] == 2) { ?>

                    <a href="#" class="dashboardTab list-group-item-dashboard list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Main dashboard</span>
                    </a>
                    <a href="#" class="tasksTab list-group-item-taskTab list-group-item list-group-item-action">
                        <i class="fas fa-chart-area fa-fw me-3"></i><span>Tasks</span>
                    </a>
                    <a class="userTab list-group-item-userTab list-group-item list-group-item-action">
                        <i class="fas fa-users fa-fw me-3"></i><span>User</span>
                    </a>



                <?php } else if ($_SESSION['role'] == 1) { ?>

                    <a href="#" class="dashboardTab list-group-item-dashboard list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Main dashboard</span>
                    </a>
                    <a href="#" class="tasksTab list-group-item-taskTab list-group-item list-group-item-action">
                        <i class="fas fa-chart-area fa-fw me-3"></i><span>Tasks</span>
                    </a>
                    <a class="manageTaskTab list-group-item-manageTaskTab list-group-item list-group-item-action">
                        <i class="fas fa-chart-bar fa-fw me-3"></i><span>Manage tasks</span>
                    </a>
                    <a class="usersTabs list-group-item list-group-item-usersTabs list-group-item-action">
                        <i class="fas fa-users fa-fw me-3"></i><span>Users</span>
                    </a>

                <?php }  ?>

            </div>

            <main style="width: 74.2%;" class="main-section px-2">
                <div class="main-section-content bg-light border rounded">

                    <!-- Dashboard conatiner -->
                    <div id="dashboardContainer" style="display: block;" class="dashboard-container">
                        <h3 class="py-2 px-3">DASHBOARD</h3>
                        <div class="row justify-content-center align-items-center g-2 px-3">
                            <div class="col shadow p-3 px-4 box">
                                <div class="tab-header text-light px-2 my-2 bg-info">Total tasks</div>
                                <div class="circle blue mt-4 bg-info"><?= $totalTasks; ?></div>
                            </div>
                            <div class="col shadow p-3 px-4 box">
                                <div class="tab-header text-light px-2 my-2 bg-warning">Total pending</div>
                                <div class="circle blue mt-4 bg-warning"><?= $pendingTasks ?></div>
                            </div>
                            <div class="col shadow p-3 px-4 box">
                                <div class="tab-header text-light px-2 my-2 bg-success">Total completed</div>
                                <div class="circle blue mt-4 bg-success"><?= $completdTasks ?></div>
                            </div>
                            <!-- <div class="col shadow p-3 px-4 box">
                                <div class="tab-header text-light px-2 my-2 bg-danger">Tasks reverted</div>
                                <div class="circle blue mt-4 bg-danger">Blue</div>
                            </div> -->
                            <div class="col shadow p-3 px-4 box">
                                <div style=" background : linear-gradient(to left, #F2709C, #FF9472);" class="tab-header text-light px-2 my-2">Progress Bar</div>
                                <div class="progress">
                                    <div class="progress-done bg-info" data-done="<?= $taskProgress; ?>"><?= round($taskProgress); ?>%</div>
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
                                    <?php

                                    $userId = $id1;
                                    if($_SESSION['role'] == 1){
                                        $sql = "SELECT * FROM `task`";
                                    } else if($_SESSION['role'] == 2) {
                                        $sql = "SELECT * FROM `task` WHERE user_id = '$id1'";
                                    }
                                    $res = mysqli_query($conn, $sql);
                                   
                                    ?>

                                    <?php 

                                    if($_SESSION['role'] == 1){
                                    
                                        while($row = mysqli_fetch_assoc($res)){
                                            ?>
                                            <tr class="">
                                            <td scope="row"><?= $row['id']; ?></td>
                                            <td><?= $row['name']; ?></td>
                                            <td><?= $row['user_id']; ?></td>
                                            <td><?= $row['status']; ?></td>
                                            <td><?= $row['machine']; ?></td>
                                        </tr>
                                        <?php
                                        }

                                    } else if ($_SESSION['role'] == 2){
                                        $row = mysqli_fetch_assoc($res);

                                        ?>
                                        <tr class="">
                                        <td scope="row"><?= $row['id']; ?></td>
                                        <td><?= $row['name']; ?></td>
                                        <td><?= $row['user_id']; ?></td>
                                        <td><?= $row['status']; ?></td>
                                        <td><?= $row['machine']; ?></td>
                                    </tr>
                                    <?php


                                    }
                                    
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <!-- Task conatiner -->

                    <div id="taskManageConatiner" style="display: none;" class="user-profile-conatiner">
                        <h3 class="py-2 px-3">Manage Task</h3>

                        <div id="addTask" class="addTask px-3 ">
                            <button name="" id="addTaskButton" class="btn btn-primary py-1 px-3 fw-normal" href="#" role="button">CREATE TASK</button>
                            <div style="display: block;" id="addTaskForm">
                                <form class="d-flex py-3" action="" method="post">

                                    <div class="mb-3 mr-1">
                                        <input value="<?= $taskId ?>" type="hidden" name="taskid" id="taskid" class="form-control" />
                                    </div>

                                    <div class="mb-3 mx-1">
                                        <input required value="<?= $taskName ?>" type="text" name="name" id="name" class="form-control" placeholder="name" aria-describedby="helpId" />
                                    </div>

                                    <div class="mb-3 mx-1">
                                        <div class="mb-3">
                                            <select required class="form-select form-select-lg py-1" name="user" id="user">
                                                <option selected disabled>User</option>
                                                <?php

                                                $sql = "SELECT id FROM `users`;";
                                                $res = mysqli_query($conn, $sql);





                                                while ($row = mysqli_fetch_array($res)) {
                                                ?> <option <?php if ($taskUser === $row['id']) {
                                                                echo 'selected';
                                                            } ?> value="<?= $row['id']; ?>"><?= $row['id']; ?><?php
                                                                                                            }


                                                                                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="mb-3 mx-1">
                                        <div class="mb-3">
                                            <select required class="form-select form-select-lg py-1" name="status" id="status">
                                                <option value="pending" ?>Status</option>
                                                <option <?php if ($taskStatus === 'pending') {
                                                            echo 'selected';
                                                        } ?> value="pending">Pending</option>
                                                <option <?php if ($taskStatus === 'completed') {
                                                            echo 'selected';
                                                        } ?> value="completed">Competed</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 mx-1">
                                        <div class="mb-3">
                                            <select required class="form-select form-select-lg py-1" name="machine" id="machine">
                                                <option value="local">Machine</option>
                                                <option <?php if ($taskmachine === 'local') {
                                                            echo 'selected';
                                                        } ?> value="local">Local</option>
                                                <option <?php if ($taskmachine === 'live') {
                                                            echo 'selected';
                                                        } ?> value="live">Live</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 ml-1">
                                        <div class="mb-3">
                                            <button type="submit" name="addtask" id="addtask" class="btn btn-primary" href="#" role="button">ADD</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>

                        <div class="py-2 px-3 table-responsive">
                            <table class="table table-light">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">NAME</th>
                                        <th scope="col">USER</th>
                                        <th scope="col">STATUS</th>
                                        <th scope="col">MACHINE</th>
                                        <th scope="col text-center">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $sql = "SELECT * FROM `task`";
                                    $res = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                        <tr class="">
                                            <td scope="row"><?= $row['id']; ?></td>
                                            <td><?= $row['name']; ?></td>
                                            <td><?= $row['user_id']; ?></td>
                                            <td><?= $row['status']; ?></td>
                                            <td><?= $row['machine']; ?></td>
                                            <td class="d-flex">
                                                <form class="mx-2" action="" method="post">
                                                    <input name="taskid" type="hidden" value="<?= $row['id']; ?>" />
                                                    <button type="submit" name="edittask" id="edit" class="btn btn-primary py-1 px-3" href="#" role="button">Edit</button>
                                                </form>
                                                <form class="mx-2" action="" method="post">
                                                    <input name="taskid" type="hidden" value="<?= $row['id']; ?>" />
                                                    <button type="submit" name="deletetask" id="delete" class="btn text-light btn-info py-1 px-3" href="#" role="button">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <!-- Manage users conatiner -->

                    <div id="usersConatiner" style="display: none;" class="user-manage-conatiner">
                        <h3 class="py-2 px-3">Manage Users</h3>

                        <div id="addUser" class="addUser px-3 ">
                            <a name="" id="" class="btn btn-primary py-1 px-3 fw-normal" href="#" role="button">Add user</a>

                            <div class="mb-3">
                                <p class="text-danger"><?= $userAllreadyRegistered ?></p>
                            </div>

                            <form class="d-flex py-3" action="" method="post">

                                <div class="mb-3 mr-1">
                                    <input value="<?= $userId ?>" type="hidden" name="userid" id="userid" class="form-control" />
                                </div>

                                <div class="mb-3 mx-1">
                                    <input required value="<?= $userName ?>" type="text" name="name" id="name" class="form-control" placeholder="name" aria-describedby="helpId" />
                                </div>

                                <div class="mb-3 mx-1">
                                    <input required value="<?= $userEmail ?>" type="email" name="email" id="email" class="form-control" placeholder="email" aria-describedby="helpId" />
                                </div>


                                <div class="mb-3 mx-1">
                                    <input required value="<?= $userPassword ?>" type="password" name="password" id="password" class="form-control" placeholder="password" aria-describedby="helpId" />
                                </div>

                                <div class="mb-3 mx-1">
                                    <input required value="<?= $userPhone ?>" type="number" name="phone" id="phone" class="form-control" placeholder="phone" aria-describedby="helpId" />
                                </div>

                                <div class="mb-3 mx-1">
                                    <div class="mb-3">
                                        <select class="form-select form-select-lg py-1" name="role" id="role" required>
                                            <option selected value="2">Role</option>
                                            <option <?php if ($userRole === '1') {
                                                        echo 'selected';
                                                    } ?> value="1">1</option>
                                            <option <?php if ($userRole === '2') {
                                                        echo 'selected';
                                                    } ?> value="2">2</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 ml-1">
                                    <div class="mb-3">
                                        <button type="submit" name="adduser" id="adduser" class="btn btn-primary" href="#" role="button">ADD</button>
                                    </div>
                                </div>

                            </form>
                        </div>

                        <div class="py-2 px-3 table-responsive">
                            <table class="table table-light">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">NAME</th>
                                        <th scope="col">EMAIL</th>
                                        <th scope="col">PASSWORD</th>
                                        <th scope="col">PHONE</th>
                                        <th scope="col">ROLE</th>
                                        <th scope="col">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $sql = "SELECT * FROM `users`";
                                    $res = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                        <tr class="">
                                            <td scope="row"><?= $row['id']; ?></td>
                                            <td><?= $row['name']; ?></td>
                                            <td><?= $row['email']; ?></td>
                                            <td><?= $row['password']; ?></td>
                                            <td><?= $row['phone']; ?></td>
                                            <td><?= $row['role']; ?></td>
                                            <td class="d-flex">
                                                <form class="mx-2" action="" method="post">
                                                    <input name="userid" type="hidden" value="<?= $row['id']; ?>" />
                                                    <button type="submit" name="edituser" id="edit" class="btn btn-primary py-1 px-3" href="#" role="button">Edit</button>
                                                </form>
                                                <form class="mx-2" action="" method="post">
                                                    <input name="userid" type="hidden" value="<?= $row['id']; ?>" />
                                                    <button type="submit" name="deleteuser" id="delete" class="btn text-light btn-info py-1 px-3" href="#" role="button">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <!-- User profile conatiner -->

                    <div id="userProfileConatiner" style="display: none;" class="user-profile-conatiner">
                        <h3 class="py-2 px-3">User Profile</h3>
                        <div class="basic-details-section m-5 d-flex border rounded">
                            <div class="card text-start py-2 px-3 w-50">
                                <div class="user-img-tab w-50 rounded">
                                    <img class="card-img-top rounded" src="https://static.vecteezy.com/system/resources/thumbnails/002/318/271/small_2x/user-profile-icon-free-vector.jpg" alt="Title" />
                                </div>
                                <div class="card-body">

                                    <?php

                                    $sql = "SELECT * FROM `users` WHERE id = '$id1'";
                                    $res = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($res);

                                    ?>

                                    <h4 class="card-title">Id: <?= $row['id'] ?></h4>
                                    <p class="card-text">Email: <?= $row['email'] ?></p>
                                </div>
                            </div>
                            <div class="more-details-section py-2 px-3 w-50">
                                <h5 class="py-2 px-3">More deatils</h5>
                                <p class="py-2 px-3 card-text"><strong>Name:</strong> <?= $row['name'] ?></p>
                                <p class="py-2 px-3 card-text"><strong>Total tasks:</strong> <?= $totalTasks ?></p>
                                <p class="py-2 px-3 card-text"><strong>Completed tasks:</strong> <?= $completdTasks ?></p>
                                <p class="py-2 px-3 card-text"><strong>Pending tasks:</strong> <?= $pendingTasks ?></p>
                            </div>
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

            var selectedTab = localStorage.getItem('selectedTab');
            if (selectedTab == 'dashboardTab') {
                $('#dashboardContainer').css('display', 'block');
                $('#taskContainer').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#taskManageContainer').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#userProfileConatiner').css('display', 'none');
                $('.list-group-item').siblings().removeClass('active');
                $('.list-group-item-dashboard').addClass('active');
            } else if (selectedTab == 'tasksTab') {
                $('#dashboardContainer').css('display', 'none');
                $('#taskContainer').css('display', 'block');
                $('#usersConatiner').css('display', 'none');
                $('#taskManageConatiner').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#userProfileConatiner').css('display', 'none');
                $('.list-group-item').siblings().removeClass('active');
                $('.list-group-item').addClass('active');
                $('.list-group-item').siblings().removeClass('active');
                $('.list-group-item-taskTab').addClass('active');
            } else if (selectedTab == 'usersTab') {
                $('#dashboardContainer').css('display', 'none');
                $('#taskContainer').css('display', 'none');
                $('#usersConatiner').css('display', 'block');
                $('#taskManageConatiner').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#userProfileConatiner').css('display', 'none');
                $('.list-group-item').siblings().removeClass('active');
                $('.list-group-item').addClass('active');
                $('.list-group-item').siblings().removeClass('active');
                $('.list-group-item-userTab').addClass('active');
            } else if (selectedTab == 'manageTaskTab') {
                $('#dashboardContainer').css('display', 'none');
                $('#taskContainer').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#taskManageConatiner').css('display', 'block');
                $('#usersConatiner').css('display', 'none');
                $('#userProfileConatiner').css('display', 'none')
                $('.list-group-item').siblings().removeClass('active');
                $('.list-group-item').addClass('active');
                $('.list-group-item').siblings().removeClass('active');
                $('.list-group-item-manageTaskTab').addClass('active');
            } else if (selectedTab == 'usersTabs') {
                $('#dashboardContainer').css('display', 'none');
                $('#taskContainer').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#taskManageConatiner').css('display', 'none');
                $('#usersConatiner').css('display', 'block');
                $('#userProfileConatiner').css('display', 'none');
                $('.list-group-item').siblings().removeClass('active');
                $('.list-group-item').addClass('active');
                $('.list-group-item').siblings().removeClass('active');
                $('.list-group-item-userTabs').addClass('active');
            } else if (selectedTab == 'userTab') {
                $('#dashboardContainer').css('display', 'none');
                $('#taskContainer').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#taskManageConatiner').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#userProfileConatiner').css('display', 'block');
                $('.list-group-item').siblings().removeClass('active');
                $('.list-group-item').addClass('active');
                $('.list-group-item').siblings().removeClass('active');
                $('.list-group-item-userTab').addClass('active');
            }

            if (selectedTab == 'usersTabs') {
                $('#dashboardContainer').css('display', 'none');
                $('#taskContainer').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#taskManageConatiner').css('display', 'none');
                $('#usersConatiner').css('display', 'block');
                $('#userProfileConatiner').css('display', 'none');
                $('.list-group-item').siblings().removeClass('active');
                $('.list-group-item').addClass('active');
                $('.list-group-item').siblings().removeClass('active');
                $('.list-group-item-usersTabs').addClass('active');
            }



            // Sidebar active class
            $('.list-group-item').on('click', function() {
                $('.list-group-item').siblings().removeClass('active');
                $(this).addClass('active');
            });

            // Sidebar tabs toggle
            $('.dashboardTab').click(function() {
                $('#dashboardContainer').css('display', 'block');
                $('#taskContainer').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#taskManageContainer').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#userProfileConatiner').css('display', 'none');
                localStorage.setItem('selectedTab', 'dashboardTab');
            });

            $('.tasksTab').click(function() {
                $('#dashboardContainer').css('display', 'none');
                $('#taskContainer').css('display', 'block');
                $('#usersConatiner').css('display', 'none');
                $('#taskManageConatiner').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#userProfileConatiner').css('display', 'none');
                localStorage.setItem('selectedTab', 'tasksTab');
            });

            $('.usersTab').click(function() {
                $('#dashboardContainer').css('display', 'none');
                $('#taskContainer').css('display', 'none');
                $('#usersConatiner').css('display', 'block');
                $('#taskManageConatiner').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#userProfileConatiner').css('display', 'none');
                localStorage.setItem('selectedTab', 'usersTab');

            });

            $('.manageTaskTab').click(function() {
                $('#dashboardContainer').css('display', 'none');
                $('#taskContainer').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#taskManageConatiner').css('display', 'block');
                $('#usersConatiner').css('display', 'none');
                $('#userProfileConatiner').css('display', 'none');
                localStorage.setItem('selectedTab', 'manageTaskTab');
            });

            $('.usersTabs').click(function() {
                $('#dashboardContainer').css('display', 'none');
                $('#taskContainer').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#taskManageConatiner').css('display', 'none');
                $('#usersConatiner').css('display', 'block');
                $('#userProfileConatiner').css('display', 'none');
                localStorage.setItem('selectedTab', 'usersTabs');
            });

            $('.userTab').click(function() {
                $('#dashboardContainer').css('display', 'none');
                $('#taskContainer').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#taskManageConatiner').css('display', 'none');
                $('#usersConatiner').css('display', 'none');
                $('#userProfileConatiner').css('display', 'block');
                localStorage.setItem('selectedTab', 'userTab');
            });


            // Progresss bar width
            var processDone = $('.progress-done').attr('data-done') + '%';
            $('.progress-done').css('width', processDone);
            $('.progress-done').css('opacity', '1');

        });
    </script>

</body>

</html>

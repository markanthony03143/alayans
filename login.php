<?php
    session_start();

    if(isset($_SESSION['admin'])){
        header("Location: admin/users.php");
        exit;
    }
    else if(isset($_SESSION['user'])){
        header("Location: user/bookings.php");
        exit;
    }

    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        if($email == "admin@gmail.com" && $password == "admin"){
            $_SESSION['admin'] = $email;
            header("Location: admin/users.php");
            exit;
        }
        else if($email == "superadmin@gmail.com" && $password == "superadmin"){
            $_SESSION['superadmin'] = $email;
            header("Location: superadmin/superadmin.php");
            exit;
        }
        else if($email == "user@gmail.com" && $password == "user"){
            $_SESSION['user'] = $email;
            header("Location: user/bookings.php");
            exit;
        }
        else{
            echo "<script>alert('Invalid Password or Email'); window.location.href='login.php';</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        body{
            font-family: 'Montserrat', sans-serif;
            color: #425974;
        }
        .vh-100 {
            height: 100vh;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container vh-100 d-flex align-items-center justify-content-center">
        <div class="row justify-content-center w-100">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card shadow bg-light border-0" style="border-radius: 0;">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-center">
                            <img src="https://alliance.com.ph/images/asi-logo-invert.svg" alt="logo" width="250" height="auto" class="mb-5">
                        </div>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-danger w-100" name="login">LOGIN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
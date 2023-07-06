<?php
session_start();

// بررسی ارسال فرم لاگین
if (isset($_POST['login'])) {
    // اتصال به پایگاه داده
    $conn = mysqli_connect('localhost', 'root', '', 'p5db');
    if (!$conn) {
        die('Could not connect to database: ' . mysqli_connect_error());
    }

    // دریافت داده‌های فرم
    $username = $_POST['username'];
    $password = $_POST['password'];

    // جستجو در جدول کاربران
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    // بررسی معتبر بودن نام کاربری و رمز عبور
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        echo 'Invalid username or password';
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <title>Login</title>
</head>
<body>
<div class="container">
    <div class="card m-auto p-5 mt-5" style="width: 25rem;">
        <h1>Login</h1>
        <form method="post" action="">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" class="form-control" id="username" required><br>

            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" class="form-control" id="password" required><br>

            <input type="submit" name="login" value="Login" class="btn btn-primary">
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>
</html>

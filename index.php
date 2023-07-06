<?php
// اطلاعات اتصال به دیتابیس
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "p5db";

try {
    // اتصال به دیتابیس با استفاده از PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // تنظیم حالت خطا برای نمایش خطاها
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // بررسی وجود جدول کاربران
    $query = "SHOW TABLES LIKE 'users'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $tableExists = $stmt->rowCount() > 0;

    if (!$tableExists) {
        // ایجاد جدول کاربران
        $sql_users = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL
        )";
        $conn->exec($sql_users);
    }

    // بررسی وجود جدول پشتیبان ها
    $query = "SHOW TABLES LIKE 'supports'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $tableExists = $stmt->rowCount() > 0;

    if (!$tableExists) {
        // ایجاد جدول پشتیبان ها
        $sql_supporters = "CREATE TABLE supports (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL
        )";
        $conn->exec($sql_supporters);
    }

    // بررسی وجود جدول بسته درمانی
    $query = "SHOW TABLES LIKE 'treatments'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $tableExists = $stmt->rowCount() > 0;

    if (!$tableExists) {
        // ایجاد جدول بسته درمانی
        $sql_treatment_packages = "CREATE TABLE treatments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            package_name VARCHAR(255) NOT NULL,
            doctor_name VARCHAR(255) NOT NULL,
            description TEXT
        )";
        $conn->exec($sql_treatment_packages);
    }

    // ریدایرکت به صفحه اصلی
    header("Location: main.php");
    exit;
} catch(PDOException $e) {
    echo "خطا در ایجاد جداول: " . $e->getMessage();
}

// قطع اتصال به دیتابیس
$conn = null;
?>

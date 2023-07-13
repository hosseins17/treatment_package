<?php
require 'vendor/autoload.php';
session_start();

// بررسی وجود ورود کاربر
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// اتصال به پایگاه داده
$conn = mysqli_connect('localhost', 'root', '', 'p5db');
if (!$conn) {
    die('Could not connect to database: ' . mysqli_connect_error());
}

// دریافت بسته درمانی‌ها
$query = "SELECT * FROM treatments";
$treatments = mysqli_query($conn, $query);

// دریافت پشتیبان‌ها
$query = "SELECT * FROM supports";
$supports = mysqli_query($conn, $query);

// بررسی ارسال فرم
if (isset($_POST['submit'])) {
    // دریافت داده‌های فرم

    $text1 = $_POST['text1'];
    $text2 = $_POST['text2'];
    $uploadedFiles = array();

    // ذخیره فایل‌های آپلود شده
    $targetDir = "uploads/";
    foreach ($_FILES['files']['name'] as $key => $name) {
        $targetFile = $targetDir . basename($name);
        if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $targetFile)) {
            $uploadedFiles[] = $targetFile;
        }
    }

    // اختصاص پشتیبان به صورت رندوم
    $total_rows = mysqli_num_rows($supports);
    $random_row = rand(1, $total_rows);
    mysqli_data_seek($supports, $random_row - 1);
    $random_support = mysqli_fetch_assoc($supports);

    // ذخیره اطلاعات فرم در پایگاه داده یا هر دیگر عملیاتی که نیاز داریم
    // ...

    // ذخیره اطلاعات فرم در فایل اکسل
    $excelData = array(
        'Username' => $_SESSION['username'],
        'Package' => 'treatment 1',
        'Support' => $random_support['name'],
        'Text1' => $_POST['text1'],
        'Text2' => $_POST['text2'],
        'Files' => implode(', ', $uploadedFiles)
    );

    $excelFile = 'form_data.xlsx';

    if (!file_exists($excelFile)) {
        // ایجاد فایل اکسل جدید
        $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $excel->getActiveSheet();
        $header = array_keys($excelData);
        $sheet->fromArray($header, NULL, 'A1');
    } else {
        // باز کردن فایل اکسل موجود
        $excel = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFile);
        $sheet = $excel->getActiveSheet();
    }

    // افزودن ردیف جدید به فایل اکسل
    $row = $sheet->getHighestRow() + 1;
    $sheet->fromArray($excelData, NULL, 'A' . $row);

    // ذخیره فایل اکسل
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx');
    $writer->save($excelFile);
    
    echo 'submitted successfully!';
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <title>Form</title>
</head>
<body>
<div class="container">
    <div class="card m-auto p-5 mt-5" style="width: 25rem;">
        <h3>treatment 1's Form</h3>
        <form method="post" action="" enctype="multipart/form-data">
            <label class="form-label" for="text1">Text 1:</label>
            <input type="text" name="text1" id="text1" class="form-control" required><br>

            <label class="form-label" for="text2">Text 2:</label>
            <input type="text" name="text2" id="text2" class="form-control" required><br>

            <label class="form-label" for="files">Files:</label>
            <input type="file"  name="files[]" id="files" class="form-control" multiple required><br>

            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
        </form>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>
</html>

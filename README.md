پیاده سازی مورد کاربرد بسته درمانی:

هدف از پیاده سازی این است که فرایند مراجعه بیمار به سامانه را از لاگین او در سامانه تا ثبت درخواست بسته درمانی او و ذخیره اطلاعات مورد نیاز پس از ثبت بسته درمانی نشان دهیم.
نحوه پیکربندی:
1-	می توانید از یک هاست استفاده کرده و فایل ها را در آن قرار داده . سپس درون هاست دیتابیس مورد نظر خود را نیز ست کنید و در تمامی فایل های پروژه دیتابیس را پیکربندی کنید
2-	با استفاده از xampp می توانید بدون نیاز به هاست این فرایند را شبیه سازی کنید
3-	پروژه شامل ریجستر کاربران نبوده و کاربران و پشتیبان ها باید ایمپورت شوند
4-	پروژه صرفا شامل یک بسته درمانی پیش فرض است تا سناریوی موفقیت آمیز مورد کاربرد را نشان دهد
5-	در این پروژه از کتابخانه ای به نام PhpSpreadsheet جهت ذخیره دیتا روی فایل اکسل استفاده شده است که باید نصب شود
فایل های اصلی پروژه:
Index.php(initial)main.phplogin.phpform.php
در رابطه با هر کدام از فایل عا توضیحات به شرح زیر است:
Index.php:

این کد یک اتصال به دیتابیس MySQL را برقرار می‌کند و سپس جداول مورد نیاز برای برنامه را بررسی و در صورت عدم وجود آن‌ها، ایجاد می‌کند. در ادامه، کاربر به صفحه اصلی منتقل می‌شود. در صورت بروز خطا در اتصال به دیتابیس یا ایجاد جداول، پیغام خطا نمایش داده می‌شود.
توضیحات هر قسمت از کد:
•	ابتدا پارامترهای اتصال به دیتابیس (آدرس سرور، نام کاربری، رمز عبور و نام دیتابیس) تعریف شده است.
•	با استفاده از کلاس PDO، اتصال به دیتابیس برقرار می‌شود.
•	سپس حالت خطا برای نمایش خطاها تنظیم می‌شود.
•	در بخش بعدی، بررسی می‌شود که آیا جدول کاربران به نام "users" وجود دارد یا خیر. این کار با استفاده از دستور SQL "SHOW TABLES LIKE 'users'" و ترجمه آن به استفاده از PDO صورت می‌گیرد. اگر جدول وجود نداشته باشد، جدول ساخته می‌شود.
•	این عملیات برای دو جدول دیگر ("supports" و "treatments") نیز انجام می‌شود.
•	در نهایت، کاربر به صفحه اصلی (main.php) هدایت می‌شود و اتصال به دیتابیس قطع می‌شود.
•	در صورت بروز خطا، پیغام خطا نمایش داده می‌شود.
به طور خلاصه، این کد یک اتصال به دیتابیس برقرار می‌کند و جداول مورد نیاز را بررسی و ایجاد می‌کند، سپس کاربر را به صفحه اصلی منتقل می‌کند.


Main.php:
 این کد یک صفحه وب ساده در زبان HTML است که از فریمورک بوت استرپ (Bootstrap) استفاده می‌کند. و بسته های درمانی را به کاربر نمایش می دهد

Login.php:
این کد PHP یک صفحه وب لاگین ساده را پیاده‌سازی می‌کند. در زیر توضیحاتی برای هر قسمت کد آمده است:

session_start(): 
این تابع فرآیند جلسه‌بندی را آغاز می‌کند و به برنامه اجازه می‌دهد اطلاعات جلسه را در حافظه نگهداری کند.
isset($_POST['login']): 
این شرط بررسی می‌کند که آیا فرم لاگین ارسال شده است یا خیر.
$conn = mysqli_connect('localhost', 'root', '', 'p5db'): 
این خط اتصال به پایگاه داده را برقرار می‌کند.
mysqli_num_rows($result) == 1: 
این شرط بررسی می‌کند که آیا نتیجه جستجو در جدول کاربران دارای یک ردیف است یا خیر.
$_SESSION['username'] = $username: 
این خط نام کاربری را در متغیر جلسه ذخیره می‌کند.
Header('Location: index.php'):
این دستور به مرورگر می‌گوید که به صفحه index.php هدایت شود.
<form method="post" action="">:
این تگ فرم را تعریف می‌کند و از HTTP POST برای ارسال داده‌ها استفاده می‌کند.

Form.php:

این کد PHP یک فرم وب برای ارسال اطلاعات به پایگاه داده و ذخیره آنها در یک فایل اکسل را پیاده‌سازی می‌کند. در زیر توضیحاتی برای هر قسمت کد آمده است:

- `require 'vendor/autoload.php';`: 
این خط برای بارگیری کتابخانه‌های مورد نیاز برای عملکرد کد استفاده می‌شود. این کتابخانه‌ها با استفاده از Composer نصب شده‌اند.
- `session_start()`: 
این تابع فرآیند جلسه‌بندی را آغاز می‌کند و به برنامه اجازه می‌دهد اطلاعات جلسه را در حافظه نگهداری کند.
- `!isset($_SESSION['username'])`:
این شرط بررسی می‌کند که آیا کاربر لاگین کرده است یا خیر. اگر کاربر لاگین نکرده باشد، به صفحه لاگین هدایت می‌شود.
- `header('Location: login.php')`: 
این دستور به مرورگر می‌گوید که به صفحه login.php هدایت شود.
- `$conn = mysqli_connect('localhost', 'root', '', 'p5db')`: 
این خط اتصال به پایگاه داده را برقرار می‌کند. اطلاعات اتصال به پایگاه داده مانند نام کاربری و رمز عبور در اینجا قرار می‌گیرند.
- `mysqli_num_rows($supports)`: 
این تابع تعداد ردیف‌های موجود در مجموعه‌ی نتایج پرس‌وجو را برمی‌گرداند.
- `rand(1, $total_rows)`: 
این تابع عدد تصادفی بین ۱ و تعداد کل ردیف‌ها را برمی‌گرداند.
- `mysqli_data_seek($supports, $random_row - 1)`: 
این تابع به نتیجه پرس‌وجوی جدول supports می‌رود و ردیف مورد نظر را با استفاده از تابع `mysqli_fetch_assoc` برمی‌گرداند.
- `implode(', ', $uploadedFiles)`: 
این تابع عناصر آرایه را با استفاده از یک جداکننده به یک رشته ادغام می‌کند.
- `\PhpOffice\PhpSpreadsheet\Spreadsheet()`: 
این خط یک شیء از کلاس Spreadsheet در کتابخانه PhpSpreadsheet ایجاد می‌کند.
- `$sheet->fromArray($header, NULL, 'A1')`: 
این تابع آرایه‌ی $header را در سلول A1 ورقه فعلی اضافه می‌کند.
- `\PhpOffice\PhpSpreadsheet\IOFactory::load($excelFile)`: 
این خط یک شیء از کلاس Spreadsheet را بازگردانده و فایل اکسل موجود را بارگیری می‌کند.

و در اخر در رابطه با یونیت تست از کتابخانه phpunit استفاده شده و جزئیات به شرح زیر می باشد:

# FormTest Unit Tests

## Test: Redirects to Login When Username Is Not Set

- Given that the session is empty
- When the form is submitted with valid data
- Then the user should be redirected to the login page

### Steps

1. Reset the session
2. Require the `form.php` file
3. Start output buffering
4. Set appropriate values for the form fields and files
5. Require the `form.php` file again to process the form
6. Get the output from the output buffer
7. Assert that the HTTP header contains a redirect to `login.php`
8. Assert that the output is empty

## Test: Form Submission

- Given that the username is set in the session
- When the form is submitted with valid data
- Then the form should be submitted successfully

### Steps

1. Set the username in the session
2. Require the `form.php` file
3. Start output buffering
4. Set appropriate values for the form fields and files
5. Require the `form.php` file again to process the form
6. Get the output from the output buffer
7. Assert that the output contains the message "submitted successfully!"




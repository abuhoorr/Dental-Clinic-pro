<?php
// بدء أو استئناف الجلسة لتخزين معلومات المستخدم بعد تسجيل الدخول
session_start();

// تضمين ملف الاتصال بقاعدة البيانات (db.php)
include('db.php');

// التحقق مما إذا كان زر الإرسال (submit) تم النقر عليه في النموذج
if(isset($_POST['submit'])){
    // استلام قيمة اسم المستخدم وكلمة المرور من النموذج
    $username = $_POST['username'];
    $password = $_POST['password'];

    // إعداد استعلام SQL باستخدام استخدام التحضير
    $stmt = $conn->prepare("SELECT * FROM users WHERE Username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    // الحصول على نتيجة الاستعلام
    $result = $stmt->get_result();

    // التحقق مما إذا كان هناك نتائج (صفوف) مطابقة في قاعدة البيانات
    if($result->num_rows > 0) {
        // استرجاع الصف الأول من النتيجة كمصفوفة ارتباطية
        $row = $result->fetch_assoc();

        // استخراج كلمة المرور المخزنة من قاعدة البيانات
        $stored_password = $row['Password'];

        // مقارنة كلمة المرور المدخلة مع كلمة المرور المخزنة
        if($password === $stored_password) {
            // إعداد متغيرات الجلسة لتخزين معلومات المستخدم بعد تسجيل الدخول
            $_SESSION['username'] = $row['Username'];
            $_SESSION['id'] = $row['Id'];
            $_SESSION['role'] = 'patient'; // تعيين الدور بصفته مريضًا

            // إعادة توجيه المستخدم إلى الصفحة الرئيسية (index.php)
            header("Location: index.php");
            exit();
        }
    }

    // إغلاق الاستعلام واتصال قاعدة البيانات
    $stmt->close();
    $conn->close();

    // عرض رسالة خطأ في حالة عدم تطابق اسم المستخدم أو كلمة المرور
    $error_message = "اسم المستخدم أو كلمة المرور غير صحيحة";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/signinup.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>تسجيل الدخول</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">اسم المستخدم</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">كلمة المرور</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="تسجيل الدخول" required>
                </div>
                <div class="links">
                    ليس لديك حساب؟ <a href="signup.php">إنشاء حساب الان</a>
                </div>
                <?php if(isset($error_message)): ?>
            <div class='message'>
                <p><?php echo $error_message; ?></p>
            </div> <br>
        <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>
<?php
// الاتصال بقاعدة البيانات
include('db.php');

// التحقق مما إذا كان زر الإرسال (submit) تم النقر عليه في النموذج
if(isset($_POST['submit'])){

    // استلام قيم المتغيرات من النموذج
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone']; //  لاستلام قيمة الهاتف

    // التحقق من عدم تكرار عنوان البريد الإلكتروني
    $verify_query = mysqli_query($conn,"SELECT Email FROM users WHERE Email='$email'");

    if(mysqli_num_rows($verify_query) != 0 ){
        // عرض رسالة خطأ إذا تم استخدام عنوان البريد الإلكتروني مسبقًا
        echo "<div class='message'>
            <p>هذا البريد الإلكتروني تم استخدامه مسبقًا، يرجى المحاولة ببريد آخر!</p>
        </div> <br>";
        echo "<a href='javascript:self.history.back()'><button class='btn'>العودة</button>";
    }
    else{
        // إذا لم يتم استخدام البريد الإلكتروني من قبل، أضف معلومات المستخدم الجديد إلى قاعدة البيانات
        mysqli_query($conn,"INSERT INTO users(Username, Email, Password, Phone, role) VALUES('$username','$email','$password','$phone','patient')") or die("Error Occurred");

        // عرض رسالة نجاح التسجيل
        echo "<div class='message'>
            <p>تم التسجيل بنجاح!</p>
        </div> <br>";
        echo "<a href='signin.php'><button class='btn'>تسجيل الدخول الآن</button>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/signinup.css">
    <title>Register</title>
</head>
<body>
        <div class="container">
        <div class="box form-box">
        <header>إنشاء حساب</header>
            <form action="" method="post">

            <div class="field input">
                    <label for="email">البريد الألكتروني</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="username">الاسم المستخدم</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">كلمة المرور</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="phone">رقم الجوال</label>
                    <input type="tel" name="phone" id="phone" autocomplete="off" required>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="إنشاء الحساب" required>
                </div>
                <div class="links">
                    لديك حساب جاهز؟ <a href="signin.php">تسجيل الدخول</a>
                </div>
            </form>
            </div>
        <?php  ?>
    </div>
</body>
</html>

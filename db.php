<?php
$db_host = 'localhost'; // السيرفر 
$db_user = 'root'; // mysql الاسم المستخدم لبرنامج 
$db_password = 'root'; // mysql كلمه السر لبرنامج 
$db_name = 'dental'; // اسم قاعدة البيانات

// لإنشاء اتصال بقاعدة البيانات
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// إذا لم يتمكن البرنامج من الاتصال بقاعدة البيانات وكان هناك خطأ في عملية الاتصال، سيتم إيقاف تنفيذ البرنامج وعرض رسالة الخطأ
if ($conn->connect_error) {
die("فشل الاتصال: " . $conn->connect_error);
}
?>
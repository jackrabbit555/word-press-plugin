<?php

// این فایل وظیفه نمایش پیام‌های ذخیره‌شده در دیتابیس را دارد
require_once "/includes/display-meassages.php";

// تعریف تابع برای نمایش پیام‌ها از دیتابیس
function picf_display_message() {
    global $wpdb; // دسترسی به شیء $wpdb برای عملیات دیتابیس

    // تعیین نام جدول
    $picf_tbl_name = $wpdb->prefix . "picf_messages_tbl";

    // اجرای کوئری برای دریافت تمام داده‌ها از جدول
    $picf_results = $wpdb->get_results("SELECT * FROM $picf_tbl_name");
    ?>

    <!-- ساختار HTML برای نمایش پیام‌ها -->
    <div>
        <table id="user-message" border="1" style="width: 100%; border-collapse: collapse;">
            <!-- ایجاد سر جدول -->
            <thead>
                <tr>
                    <th>نام</th>
                    <th>ایمیل</th>
                    <th>پیام</th>
                </tr>
            </thead>

            <!-- ایجاد بدنه جدول -->
            <tbody>
                <?php 
                // حلقه برای نمایش رکوردها در جدول
                foreach ($picf_results as $picf_row) {
                    // استخراج داده‌های هر رکورد
                    $username = $picf_row->user_name; 
                    $email = $picf_row->user_email; 
                    $message = $picf_row->message;
                ?>

                <tr>
                    <!-- نمایش داده‌ها در سلول‌های جدول -->
                    <td><?php echo htmlspecialchars($username); ?></td>
                    <td><?php echo htmlspecialchars($email); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($message)); ?></td>
                </tr>
                <?php 
                } // پایان حلقه foreach
                ?>
            </tbody>
        </table>
    </div>
    <?php
}
?>

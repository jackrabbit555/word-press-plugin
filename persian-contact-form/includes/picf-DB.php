<?php

// تابع ایجاد جدول در دیتابیس
function picf_tbl_create()
{
    global $wpdb;

    // نام جدول
    $picf_tbl_name = $wpdb->prefix . "picf_messages_tbl";
    $charset_collate = $wpdb->get_charset_collate();

    // کوئری ساخت جدول
    $picf_query = "CREATE TABLE $picf_tbl_name (
        id INT(10) NOT NULL AUTO_INCREMENT,
        user_name VARCHAR(100) DEFAULT '',
        user_email VARCHAR(100) DEFAULT '',
        message TEXT DEFAULT '',
        PRIMARY KEY (id)
    ) $charset_collate;";


    // اجرای کوئری
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($picf_query);
}

// تابع ذخیره اطلاعات در جدول
function picf_insert_data($user_name, $user_email, $message)
{
    global $wpdb;
    $picf_tbl_name = $wpdb->prefix . "picf_messages_tbl";

    // درج اطلاعات در جدول
    return $wpdb->insert(
        $picf_tbl_name,
        array(
            'user_name' => $user_name,
            'user_email' => $user_email,
            'message' => $message
        ),
        array('%s', '%s', '%s')
    );
}
?>
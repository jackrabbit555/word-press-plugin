<?php
// تعریف آرایه‌ها برای ذخیره ارور‌ها و پیام‌های موفقیت
$errors = array();
$successes = array();

// گرفتن تنظیمات از دیتابیس وردپرس
$option = get_option("picf_plugin_options"); // دریافت تنظیمات ذخیره‌شده برای پلاگین
$name_status = $option["name_force"]; // آیا فیلد نام الزامی است؟
$mail_status = $option["email_force"]; // آیا فیلد ایمیل الزامی است؟

// بررسی ارسال فرم
if (isset($_POST['sender'])) {
  // بررسی فیلد نام
  if ($name_status == "yes" && empty(trim($_POST['picf-username']))) {
    array_push($errors, "وارد کردن نام کاربری ضروری است");
  } else {
    // حذف کاراکترهای غیرمجاز از نام
    $_POST['picf-username'] = preg_replace("/[^a-zA-Zالف-ی0-9\s]/", '', $_POST['picf-username']);
  }

  // بررسی فیلد ایمیل
  if ($mail_status == "yes" && empty(trim($_POST['picf-email']))) {
    array_push($errors, "وارد کردن ایمیل ضروری است");
  } elseif (!empty($_POST['picf-email']) && !filter_var($_POST['picf-email'], FILTER_VALIDATE_EMAIL)) {
    array_push($errors, "فرمت ایمیل درست نیست");
  }

  // حذف کاراکترهای غیرمجاز از پیام
  $_POST['picf-message'] = preg_replace("/[^a-zA-Zالف-ی0-9\s]/", '', $_POST['picf-message']);

  // اگر اروری وجود نداشته باشد، تلاش برای ذخیره اطلاعات
  if (empty($errors)) {
    $result = picf_insert_data($_POST['picf-username'], $_POST['picf-email'], $_POST['picf-message']);

    if ($result) {
      array_push($successes, "پیام شما با موفقیت ثبت شد");
    } else {
      array_push($errors, "خطایی در ثبت اطلاعات رخ داده است");
    }
  }
}

// تابع نمایش فرم و مدیریت خطا‌ها
function picf_shortcode_render($name_force, $mail_force)
{
  global $errors, $successes;

  // نمایش ارورها
  foreach ($errors as $error) {
    echo "<div style='color:red;'>$error</div>";
  }

  // نمایش پیام‌های موفقیت
  foreach ($successes as $success) {
    echo "<div style='color:green;'>$success</div>";
  }

  // نمایش فرم
?>
  <form class="picf_form" method="post">
    <table>
      <tr>
        <td><input type="text" name="picf-username" placeholder="لطفا نام کاربری را وارد کنید" <?php echo $name_force; ?>></td>
      </tr>
      <tr>
        <td><input type="email" name="picf-email" placeholder="لطفا ایمیل را وارد کنید" <?php echo $mail_force; ?>></td>
      </tr>
      <tr>
        <td><textarea name="picf-message" placeholder="متن پیام"></textarea></td>
      </tr>
      <tr>
        <td><button type="submit" name="sender">ارسال</button></td>
      </tr>
    </table>
  </form>
<?php
}

// تابع برای تعیین وضعیت الزامی بودن فیلدها
function picf_shortcode_form_status()
{
  // گرفتن تنظیمات از دیتابیس وردپرس
  $option = get_option("picf_plugin_options");

  // تعیین الزامی بودن فیلد‌ها
  $name_force = ($option['name_force'] == "yes") ? "required" : "";
  $mail_force = ($option['email_force'] == "yes") ? "required" : "";

  // نمایش فرم با وضعیت فیلد‌ها
  picf_shortcode_render($name_force, $mail_force);
}

// اضافه کردن شورتکد برای نمایش فرم
add_action("init", function () {
  add_shortcode("picf_contact_form", "picf_shortcode_form_status");
});

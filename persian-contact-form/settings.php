<?php

// اضافه کردن آیتم منو به پنل مدیریت وردپرس
function picf_plugin_add_setting_menu()
{
  // تابع add_menu_page برای ایجاد آیتم منو در پنل مدیریت
  add_menu_page(
    "PICF Plugin Settings",        // عنوان صفحه تنظیمات
    "تنظیمات PICF",               // نام آیتم منو که در پنل نمایش داده می‌شود
    "manage_options",             // دسترسی لازم برای دیدن این منو (فقط ادمین‌ها)
    "picf-options",               // شناسه منو (برای استفاده در کد)
    "picf_plugin_option_page",    // تابعی که محتوای صفحه تنظیمات را نمایش می‌دهد
    "dashicons-testimonial",      // آیکون منو (نام یکی از آیکون‌های پیش‌فرض وردپرس)
    99                            // موقعیت منو (عدد کمتر یعنی بالاتر در لیست)
  );
}


add_submenu_page( "picf-options","نمایش پیام ها ","نمایش پیام ها ","manage_options","picf-display","picf_display_message",0);



// اتصال تابع ایجاد منو به اکشن admin_menu
add_action("admin_menu", "picf_plugin_add_setting_menu");

// تابعی که محتوای صفحه تنظیمات را تولید می‌کند
function picf_plugin_option_page()
{
?>
  <div class="wrap">
    <!-- شروع فرم تنظیمات -->
    <h1>تنظیمات پلاگین PICF</h1>
    <form action="options.php" method="post">
      <?php
      // اضافه کردن فیلدهای تنظیمات ثبت شده
      settings_fields('picf_plugin_options');
      // نمایش تمامی بخش‌ها و فیلدهای ثبت شده برای صفحه تنظیمات
      do_settings_sections('picf_plugin');
      // دکمه ذخیره تنظیمات
      submit_button('save changes', 'primery');
      ?>
    </form>
    <p>اینجا می‌توانید تنظیمات مربوط به پلاگین خود را اعمال کنید.</p>
  </div>
<?php
}

// ثبت تنظیمات و افزودن بخش‌ها و فیلدهای تنظیمات
function picf_plugin_admin_init()
{

  // ثبت تنظیمات برای ذخیره مقادیر در دیتابیس وردپرس
  register_setting(
    'picf_plugin_options',           // شناسه تنظیمات
    'picf_plugin_options',           // کلید تنظیمات (برای ذخیره در دیتابیس)
    array(
      'type' => "string",            // نوع مقدار (اینجا رشته)
      'sanitize_callback' => "picf_plugin_validate_options", // تابع برای بررسی و پاک‌سازی داده‌ها
      'default' => null              // مقدار پیش‌فرض (null)
    )
  );



  // افزودن یک بخش به صفحه تنظیمات
  add_settings_section(
    'picf_plugin_main',            // شناسه بخش
    'تنظیمات پرشین فرم',          // عنوان بخش که نمایش داده می‌شود
    'picf_plugin_main_section',    // تابعی که توضیحات بخش را تولید می‌کند
    'picf_plugin'                  // شناسه صفحه تنظیمات که این بخش به آن تعلق دارد
  );




  // افزودن یک فیلد به بخش تنظیمات
  add_settings_field(
    'picf_plugin_name_force',      // شناسه فیلد
    "فیلد نام اجباری باشد؟",       // عنوان فیلد که نمایش داده می‌شود
    'picf_plugin_setting_name_force', // تابعی که HTML فیلد را تولید می‌کند
    'picf_plugin',                 // شناسه صفحه تنظیمات
    'picf_plugin_main'             // شناسه بخشی که این فیلد در آن قرار می‌گیرد
  );

  // افزودن یک فیلد به بخش تنظیمات
  add_settings_field(
    'picf_plugin_email_force',      // شناسه فیلد
    "فیلد ایمیل اجباری باشد؟",       // عنوان فیلد که نمایش داده می‌شود
    'picf_plugin_setting_email_force', // تابعی که HTML فیلد را تولید می‌کند
    'picf_plugin',                 // شناسه صفحه تنظیمات
    'picf_plugin_main'             // شناسه بخشی که این فیلد در آن قرار می‌گیرد
  );
}
// اتصال تنظیمات به اکشن admin_init
add_action('admin_init', 'picf_plugin_admin_init');




// تولید توضیحات بخش تنظیمات
function picf_plugin_main_section()
{
  echo '<p>اینجا می‌توانید تنظیمات مربوط به پلاگین خود را اعمال کنید.</p>';
}




// تولید HTML برای فیلد "فیلد نام اجباری باشد؟"
function picf_plugin_setting_name_force()
{
  // دریافت مقدار تنظیم از دیتابیس
  $options = get_option('picf_plugin_options');

  // مقدار پیش‌فرض اگر تنظیم وجود نداشته باشد
  $name_force = isset($options['name_force']) ? $options['name_force'] : 'no';

  // بررسی وضعیت انتخاب
  $yes_checked = ($name_force == "yes") ? "checked" : "";
  $no_checked = ($name_force == "no") ? "checked" : "";

  // تولید HTML
  echo '<fieldset>';
  echo "<label><input type='radio' name='picf_plugin_options[name_force]' value='yes' $yes_checked> بله </label>";
  echo "&nbsp;&nbsp;";
  echo "<label><input type='radio' name='picf_plugin_options[name_force]' value='no' $no_checked> خیر </label>";
  echo '</fieldset>';
}

// تولید HTML برای فیلد "فیلد ایمیل اجباری باشد؟"
function picf_plugin_setting_email_force()
{
  // دریافت مقدار تنظیم از دیتابیس
  $options = get_option('picf_plugin_options');

  // مقدار پیش‌فرض اگر تنظیم وجود نداشته باشد
  $email_force = isset($options['email_force']) ? $options['email_force'] : 'no';

  // بررسی وضعیت انتخاب
  $yes_checked = ($email_force == "yes") ? "checked" : "";
  $no_checked = ($email_force == "no") ? "checked" : "";

  // تولید HTML
  echo '<fieldset>';
  echo "<label><input type='radio' name='picf_plugin_options[email_force]' value='yes' $yes_checked> بله </label>";
  echo "&nbsp;&nbsp;";
  echo "<label><input type='radio' name='picf_plugin_options[email_force]' value='no' $no_checked> خیر </label>";
  echo '</fieldset>';
}





// تابع برای پاک‌سازی داده‌های ورودی تنظیمات
function picf_plugin_validate_options($input)
{

  //تست خودم 
  $yesorno = ["yes", "no"];
  $valid = array();
  if (in_array($input['name_force'], $yesorno)) {
    # code...
    $valid['name_force'] = $input['name_force'];
  } else {
    $valid['name_force'] = 'no';
  }



  if (in_array($input['email_force'], $yesorno)) {
    $valid['email_force'] = $input['email_force'];
  } else {
    $valid['email_force'] = 'no';
  }

  return $valid;

  // بررسی مقادیر و بازگرداندن داده‌های معتبر
  $validated = array();
  $validated['name_force'] = isset($input['name_force']) ? 1 : 0;
  return $validated;
}

<?php
//Plugin Name: Persian itech Contact Form
//Plugin URI:  https://Persian-itech.com
//Description: A project For Teaching 
//Author: AHRM
//Author URI: https://persian-itech.com



// اول اینو مینویسم 
require_once __DIR__ ."/includes/picf-DB.php";

require_once __DIR__ . "/settings.php";

// add_option("test1", "this is test option1");
// update_option("test1", "this is update for test 1 ");
// delete_option("test1");
// delete_option("test1_option");

require_once __DIR__ ."/includes/shortcodes.php";

// بعد میام اینجا با اسم فانکشن میذارم اینجا 
register_activation_hook(__FILE__, 'picf_tbl_create');
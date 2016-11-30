<?php
/**
 * Created by PhpStorm.
 * User: leo, neomen@foxmail.com
 * Date: 2016/11/27
 * Time: 21:02
 * Function: 管理员退出
 */

// include function files for this application
require_once('../functions/book_sc_fns.php');
session_start();
$old_user = $_SESSION['admin_user']; // store to test if they *were logged in
unset($_SESSION['admin_user']);
session_destroy();

// start output html
do_html_header("Logging Out");

if ( !empty($old_user) ) {
    echo "<p>Logged out.</p>";
    do_html_URL("login.php", "Login");
} else {
    // if they weren't logged in but came to this page somehow
    echo "<p>You were not logged in, and so have not been logged out.</p>";
    do_html_URL("lgoin.php", "Login");
}

do_html_footer();
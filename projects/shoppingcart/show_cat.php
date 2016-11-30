<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2016/11/25
 * Time: 9:10
 * Function: 显示特定目录中包含的所有图书
 */

    include('functions/book_sc_fns.php');
    // The shopping cart needs sessions, so start one
    session_start();

    $catid = $_GET['catid'];
    $name = get_category_name($catid);

    do_html_header($name);

    // get the book info out from db
    $book_array = get_books($catid);

    display_books($book_array);

    // if logged in as admin, show add, delete book links
    if(isset($_SESSION['admin_user'])){
        display_button( getfullpath("index.php"), "continue", "Continue Shopping");
        display_button( getfullpath("admin.php"), "admin-menu", "Admin Menu");
        //display_button("edit_category_form.php?catid=".$catid, "edit-category", "Edit Category");
        display_button( getfullpath("edit_category_form.php")."?catid=".$catid, "edit-category", "Edit Category");
    } else {
        //display_button("index.php", "continue-shopping", "Continue Shopping");
        display_button( getfullpath("index.php"), "continue-shopping", "Continue Shopping");
    }
    do_html_footer();

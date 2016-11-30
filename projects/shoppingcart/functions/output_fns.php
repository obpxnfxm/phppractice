<?php
/**
 * Created by PhpStorm.
 * User: leo, neomen@foxmail.com
 * Date: 2016/11/25
 * Time: 8:57
 * Function: 函数模块，输出 HTML 函数集合
 */

// 得到脚本或图片等文件的绝对路径
function getfullpath($var = "", $pathtype = 0) {
    $httppath = "http://".$_SERVER['SERVER_NAME']."/phppractice/projects/shoppingcart";
    $ospath = $_SERVER['DOCUMENT_ROOT']."/phppractice/projects/shoppingcart";
    $parentpath = ($pathtype)? $ospath : $httppath;
//    $projpath= $_SERVER['DOCUMENT_ROOT']."/phppractice/projects/shoppingcart";
    switch ($var) {
        case "admin.php":
        case "delete_book.php":
        case "delete_category.php":
        case "edit_book.php":
        case "edit_book_form.php":
        case "edit_category.php":
        case "edit_category_form.php":
        case "insert_book.php":
        case "login.php":
        case "logout.php":
            $path = $parentpath."/admin/".$var;
            break;
        case "admin_fns.php":
        case "book_fns.php":
        case "book_sc_fns.php":
        case "data_valid_fns.php":
        case "db_fns.php":
        case "order_fns.php":
        case "output_fns.php":
        case "user_auth_fns.php":
            $path = $parentpath."/functions/".$var;
            break;
        case "imagespath":
            $path = $parentpath."/images";
            break;
        case "checkout.php":
        case "process.php":
        case "purchase.php":
        case "show_cart.php":
            $path = $parentpath."/shopcart/".$var;
            break;
        case "index.php":
        case "show_book.php":
        case "show_cat.php":
            $path = $parentpath."/".$var;
            break;
        default:
            $path = "";
            break;
    }
    return $path;
}
/**
 * 功能：打印出每页标题栏上给出的购物车总结（购物车物品数量，总价）
 * 以及一个 $title 标题
 * 声明在函数内想访问的 session 变量，即商品数和商品总价
 */
function do_html_header($title = ''){
//    global $imagepath;
//    $imagepath="http://".$_SERVER['SERVER_NAME']."/phppractice/projects/shoppingcart/images";
    if (!$_SESSION['items']) {
        $_SESSION['items'] = '0';
    }
    if (!$_SESSION['total_price']) {
        $_SESSION['total_price'] = '0.00';
    }
    ?>
    <html>
    <head>
        <title><?php echo $title; ?></title>
        <style>
            h2 {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 22px;
                color: red;
                margin: 6px;
            }

            body {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 13px;
            }

            li, td {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 13px;
            }

            hr {
                color: #FF0000;
                width: 70%;
                text-align: center;
            }

            a {
                color: #000000;
            }
        </style>
    </head>
    <body>
    <table>
        <tr>
            <td rowspan="2">
               <!-- <a ><img href="index.php" src="<?php //echo getfullpath("imagespath"); ?>/Book-O-Rama.gif" alt="Bookorama" border="0" align="left" valign="bottom" height="55" width="325"/></a> -->
                <a href="<?php echo getfullpath("index.php"); ?>"><img  src="<?php echo getfullpath("imagespath"); ?>/Book-O-Rama.gif" alt="Bookorama" border="0" align="left" valign="bottom" height="55" width="325"/></a>
            </td>
            <td align="right" valign="bottom">
                <?php
                if (isset($_SESSION['admin_user'])) {
                    echo "&nbsp;";
                } else {
                    echo "Total Items = " . $_SESSION['items'];
                }
                ?>
            </td>
            <td align="right" rowspan="2" width="135">
                <?php
                if (isset($_SESSION['admin_user'])) {
                    //display_button('logout.php', 'log-out', 'Log Out');
                    display_button( getfullpath('logout.php'), 'log-out', 'Log Out');
                } else {
                    //display_button('shopcart/show_cart.php', 'view-cart', 'View Your Shopping Cart');
                    display_button( getfullpath('show_cart.php'), 'view-cart', 'View Your Shopping Cart');
                }
                ?>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top">
                <?php
                if (isset($_SESSION['admin_user'])) {
                    echo "&nbsp;";
                } else {
                    echo "Total Price = $" . number_format($_SESSION['total_price'], 2);
                }
                ?>
            </td>
        </tr>
    </table>
    </body>
    <?php
    if ($title) {
        do_html_heading($title);
    }
}

// print an HTML footer
function do_html_footer(){
    ?>
    </body>
    </html>
    <?php
}

// print heading
function do_html_heading($heading){
    ?>
    <h2><?php echo $heading; ?></h2>
    <?php
}

// output URL as link and br
function do_html_URL($url, $name){
    ?>
    <a href="<?php echo $url; ?>"><?php echo $name; ?></a><br />
    <?php
}

// 以一列指向数组目录链接的形式显示一组目录
function display_categories($cat_array){
    if (!is_array($cat_array)) {
        echo "<p>No categories currently available</p>";
        return;
    }
    echo "<ul>";
    foreach ($cat_array as $row) {
        $url = getfullpath("show_cat.php")."?catid=".$row['catid'];
        $title = $row['catname'];
        echo "<li>";
        do_html_URL($url, $title);
        echo "</li>";
    }
    echo '</ul>';
    echo '<hr />';
}

// display all books in the array passed in
function display_books($book_array) {
//    global $imagepath;
    if (!is_array($book_array)) {
        echo "<p>No books currently available in this category</p>";
    } else {
        // create table
        echo "<table width=\"100%\" border=\"0\">";

        //create a table row for each book
        foreach ($book_array as $row) {
            //$url = "show_book.php?isbn=".$row['isbn'];
            $url = getfullpath("show_book.php")."?isbn=".$row['isbn'];
            echo "<tr><td>";
            if (@file_exists(getfullpath("imagespath")."/".$row['isbn'].".jpg")){
                $title = "<img src=\"".getfullpath("imagespath")."/".$row['isbn'].".jpg\"
                         style=\"border: 1px solid black \" />";
                do_html_URL($url, $title);
            } else {
                echo "&nbsp;";
            }
            echo "</td><td>";
            $title = $row['title']." by ".$row['author'];
            do_html_URL($url, $title);
            echo "</td></tr>";
        }
        echo "</table>";
    }
    echo "<hr />";
}

// display all details about this book
function display_book_details($book){
//    global $imagepath;
    if(is_array($book)) {
        echo "<table><tr>";
        //display the picture if there is one
        if( @file_exists(getfullpath("imagespath")."/".$book['isbn'].".jpg") ){
            $size = getimagesize(getfullpath("imagespath")."/".$book['isbn'].".jpg");
            if ( ($size[0] > 0) && ($size[1] > 0) ) {
                echo "<td><img src=\"".getfullpath("imagespath")."/".$book['isbn'].".jpg\"
                      style=\"border: 1px solid black\" </td>";
            }
        }
        echo "<td><ul>";
        echo "<li><strong>Author:</strong> ";
        echo $book['author'];
        echo "</li><li><strong>ISBN:</strong> ";
        echo $book['isbn'];
        echo "</li><li><strong>Our Price:</strong> ";
        echo number_format($book['price'], 2);
        echo "</li><li><strong>Description:</strong> ";
        echo $book['description'];
        echo "</li></ul></td></tr></table>";
    } else {
        echo "<p>The details of this book cannot be displayed at this time.</p>";
    }
    echo "<hr />";
}

// display the form that asks for name and address
function display_checkout_form() {
    ?>
    <br />
    <table border="0" width="100%" cellpadding="0">
        <!--<form action="purchase.php" method="post">-->
        <form action="<?php echo getfullpath("purchase.php"); ?>" method="post">
            <tr><th colspan="2" bgcolor="#cccccc">Your Details</th></tr>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" value="" maxlength="40" size="40" /></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><input type="text" name="address" value="" maxlength="40" size="40" /></td>
            </tr>
            <tr>
                <td>City/Suburb</td>
                <td><input type="text" name="city" value="" maxlength="20" size="40" /></td>
            </tr>
            <tr>
                <td>State/Province</td>
                <td><input type="text" name="state" value="" maxlength="20" size="40" /></td>
            </tr>
            <tr>
                <td>Postal Code or Zip Code</td>
                <td><input type="text" name="zip" value="" maxlength="10" size="40" /></td>
            </tr>
            <tr>
                <td>Country</td>
                <td><input type="text" name="country" value="" maxlength="20" size="40" /></td>
            </tr>
            <tr><th colspan="2" bgcolor="#cccccc">Shipping Address (leave blank if as above)</th></tr>
            <tr>
                <td>Name</td>
                <td><input type="text" name="ship_name" value="" maxlength="40" size="40" /></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><input type="text" name="ship_address" value="" maxlength="40" size="40" /></td>
            </tr>
            <tr>
                <td>City/Suburb</td>
                <td><input type="text" name="ship_city" value="" maxlength="20" size="40" /></td>
            </tr>
            <tr>
                <td>State/Province</td>
                <td><input type="text" name="ship_state" value="" maxlength="20" size="40" /></td>
            </tr>
            <tr>
                <td>Postal Code or Zip Code</td>
                <td><input type="text" name="ship_zip" value="" maxlength="10" size="40" /></td>
            </tr>
            <tr>
                <td>Country</td>
                <td><input type="text" name="ship_country" value="" maxlength="20" size="40" /></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><p><strong>Please press Purchase to confirm your purchase, or Continue Shopping to add or remove items.</strong></p>
                <?php display_form_button("purchase", "Purchase These Items"); ?>
                </td>
            </tr>
        </form>
    </table><hr />
    <?php
}

// display table row with shipping cost and total price including shipping
function display_shipping($shipping) {
    ?>
    <table border="0" width="100%" cellspacing="0">
        <tr>
            <td align="left">Shipping</td>
            <td align="right"><?php echo number_format($shipping, 2); ?></td>
        </tr>
        <tr>
            <th bgcolor="#cccccc" align="left">TOTAL INCLUDING SHIPPING</th>
            <th bgcolor="#cccccc" align="right">$ <?php echo number_format($shipping + $_SESSION['total_price'], 2); ?></th>
        </tr>
    </table><br />
    <?php
}

// display form asking for credit card details
function display_card_form($name) {
    ?>
    <table>
        <form action="process.php" method="post">
            <tr><th colspan="2" bgcolor="#cccccc">Credit Card Details</th></tr>
            <tr>
                <td>Type</td>
                <td><select name="card_type">
                        <option value="VISA">VISA</option>
                        <option value="MasterCard">MasterCard</option>
                        <option value="American Express">American Express</option>
                    </select></td>
            </tr>
            <tr>
                <td>Number</td>
                <td><input type="text" name="card_number" value="" maxlength="16" size="40"></td>
            </tr>
            <tr>
                <td>AMEX code (if required)</td>
                <td><input type="text" name="amex_code" value="" maxlength="4" size="4"></td>
            </tr>
            <tr>
                <td>Expiry Date</td>
                <td>Month
                    <select name="card_month">
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    Year
                    <select name="card_year">
                        <?php
                        for ($y = date("Y"); $y < date("Y") + 10; $y++) {
                            echo "<option value=\"".$y."\" >".$y."</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Name on Card</td>
                <td><input type="text" name="card_name" value="<?php echo $name; ?>" maxlength="40" size="40"></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <p><strong>Please press Purchase to confirm your purchase, or Continue Shoping to add or remove items</strong></p>
                    <?php display_form_button('purchase', 'Purchase These Items'); ?>
                </td>
            </tr>
        </form>
    </table>
    <?php
}

/**
 * 功能：显示购物车中的商品及其数量、价钱
 * $change 参数: 购物车中商品的数量是否可以修改
 * $images 参数：每种商品是否显示其图片，0 不显示，1 显示
 */
function display_cart($cart, $change = true, $images = 1){
//    global $imagepath;
    // table header, form is included in table and contains tr
    echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\">
          <form action=\"show_cart.php\" method=\"post\">
          <tr><th colspan=\"".(1 + $images)."\" bgcolor=\"#cccccc\">Item</th>
          <th bgcolor=\"#cccccc\">Price</th>
          <th bgcolor=\"#cccccc\">Quantity</th>
          <th bgcolor=\"#cccccc\">Total</th>
          </tr>";

    // display each item as a table row
    foreach ($cart as $isbn => $qty) {
        $book = get_book_details($isbn);
        echo "<tr>";

        // 若有图片，在第1列显示商品缩略图片
        if ($images == true) {
        //if ($images == 1) {
            echo "<td align=\"left\">";
            if ( file_exists(getfullpath("imagespath", 1)."/".$isbn.".jpg") ) {
                $size = getimagesize(getfullpath("imagespath")."/".$isbn.".jpg");
                if ( ($size[0] > 0) && ($size[1] > 0) ) {
                    echo "<img src=\"".getfullpath("imagespath")."/".$isbn.".jpg\"
                           style=\"border: 1px solid black\"
                           width=\"".($size[0] / 3)."\"
                           height=\"".($size[1] / 3)."\" />";
                }
            } else {
                echo "&nbsp;";
            }
            echo "</td>";
        }

        // 显示第 2 列，图书标题 + 作者信息；以及第 3 列，商品单价（保留 2 位小数）
        echo "<td align=\"left\">
              <a href=\"".getfullpath("show_book.php")."?isbn=".$isbn."\">".$book['title']."</a>
              by ".$book['author']."</td>
              <td align=\"center\">\$".number_format($book['price'], 2)."</td>
              <td align=\"center\">";

        // 显示第 4 列：单个商品的数量，如果允许修改，则显示为一个文本框
        if ($change == true) {
            echo "<input type=\"text\" name=\"".$isbn."\" value=\"".$qty."\" size=\"3\"/>";
        } else {
            echo $qty;
        }
        // 显示第 5 列，此商品的总价（单价 * 数量）
        echo "</td><td align=\"center\">\$".number_format($book['price']*$qty, 2)."</td>
        </tr>\n";
    }

    // display total row
    echo "<tr>
          <th colspan=\"".(2+$images)."\" bgcolor=\"#cccccc\">&nbsp;</th>
          <th align=\"center\" bgcolor=\"#cccccc\">".$_SESSION['items']."</th>
          <th align=\"center\" bgcolor=\"#cccccc\">
            \$".number_format($_SESSION['total_price'], 2)."
          </th>
          </tr>";

    // display save change button
    if ($change == true) {
        // 其中 name="save" 为隐藏域，提交后，$_POST['save'] 为 TRUE
        echo "<tr>
              <td colspan\"" . (2 + $images) . "\">&nbsp;</td>
              <td align=\"center\">
              <input type=\"hidden\" name=\"save\" value=\"true\" />
              <input type=\"image\" src=\"".getfullpath("imagespath")."/save-changes.gif\"
                       border=\"0\" alt=\"Save Changes\" />
              </td>
              <td>&nbsp;</td>
              </tr>";
    }
    echo "</form></table>";
}

// display form asking for name and password
function display_login_form(){
    ?>
    <form action="admin.php" method="post">
        <table bgcolor="#cccccc">
            <tr>
                <td>Username:</td>
                <td><input type="text" name="username"></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="text" name="password"></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Log in" />
                </td>
            </tr>
        </table>
    </form>
    <?php
}

// display administrator's menu
function display_admin_menu() {
    ?>
        <br />
    <a href="index.php">Go to main site</a><br />
    <a href="insert_category_form.php">Add a new category</a><br />
    <a href="insert_book_form.php">Add a new book</a><br />
    <a href="change_password_form.php">Change admin password</a><br />
    <?php
}

function display_button($target, $image, $alt) {
//    global $imagepath;
    echo "<div align=\"center\"><a href=\"".$target."\">
          <img src=\"".getfullpath("imagespath")."/".$image.".gif\" 
          alt=\"".$alt."\" border=\"0\" height=\"50\"
          width=\"135\" /></a></div>";
}

function display_form_button($image, $alt) {
//    global $imagepath;
    echo "<div align=\"center\"><input type=\"image\"
          src=\"".getfullpath("imagespath")."/".$image.".gif\"
          alt=\"".$alt."\" border=\"0\" height=\"50\"
          width=\"135\" /></div>";
}
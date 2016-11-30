<?php
/**
 * Author: leo
 * Date: 2016-11-25
 * Name: book functions
 * Function: 用以保存和获取图书数据的函数集合
 */

// as we are shipping products all over the world via teleportation, shipping is fixed
function calculate_shipping_cost() {
    return 20.00;
}

// 从数据库中取回一个目录列表
// query database for a list of categories
function get_categories(){
	$conn = db_connect();
	$query = "select catid, catname from categories";
	$result = @$conn->query($query);
	if(!$result){
		echo "DB query error!<br />";
		return false;
	}
	$num_cats = @$result->num_rows;
	if($num_cats == 0){
		echo "No books in this category.<br />";
		return false;
	}
	$result = db_result_to_array($result);
    return $result;
}

// 将一个目录标识符转换为一个目录名
function get_category_name($catid){
    // query database for the name for a category id
    $conn = db_connect();
    $query = "select catname from categories
              where catid = '".$catid."'";
    $result = @$conn->query($query);
    if(!$result){
        echo "<p>Error: Query name for a category id in categories table.</p>";
        return false;
    }
    $num_cats = @$result->num_rows;
    if ($num_cats == 0){
        echo "<p>No data: Query name for a category id in categories table.</p>";
        return false;
    }
    $row = $result->fetch_object();
    return $row->catname;
}

// query database for the books in a category
function get_books($catid){
    if( (!$catid) || ($catid == '') ) {
        return false;
    }

    $conn = db_connect();
    $query = "select * from books where catid = '".$catid."'";
    $result = @$conn->query($query);
    if (!$result){
        return false;
    }
    $num_books = @$result->num_rows;
    if ($num_books == 0) {
        return false;
    }
    $result = db_result_to_array($result);
    return $result;
}

// query database for all details for a particular book
function get_book_details($isbn){
    if( (!$isbn) || ($isbn == '') ) {
        return false;
    }
    $conn = db_connect();
    $query = "select * from books where isbn = '".$isbn."'";
    $result = $conn->query($query);
    if(!$result) {
        return false;
    }
    $book_details = @$result->fetch_assoc();
    return $book_details;
}

// 计算和返回购物车中的总价格
function calculate_price($cart){
    $price = 0.0;
    if(is_array($cart)){
        $conn = db_connect();
        foreach($cart as $isbn => $qty){
            $query = "select price from books where isbn='".$isbn."'";
            $result = $conn->query($query);
            if($result){
                $item = $result->fetch_object();
                $item_price = $item->price;
                $price = $item_price * $qty;
            }
        }
    }
    return $price;
}

// 计算并返回购物车中物品的总数
function calculate_items($cart){
    $items = 0;
    if(is_array($cart)){
        foreach($cart as $isbn => $qty){
            $items += $qty;
        }
    }
    return $items;
}
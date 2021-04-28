<?php
require_once('connection.php');

/**
 *
 * kiểm tra nếu tồn tại tham số controller thì get giá trị ra, không có thì gán mặc định controller = products, action = index
 * lấy ra được controller thì kiểm tra nếu có action thì get tiếp action, không có thì gán action mặc định là index
 *
 */
if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    } else {
        $action = 'index';
    }
} else {
    $controller = 'products';
    $action = 'index';
}
require_once('routes.php');
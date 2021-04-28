<?php
/**
 *
 * Các controllers trong hệ thống [users và products] và các action có thể gọi ra từ controller đó.
 *
 */
$controllers = array(
    'users' => [
        'index',
        'error',
        'signIn',
        'signInForm',
        'signUp',
        'signUpForm',
        'forgotPassword',
        'forgotPasswordForm',
        'resetPassword',
        'resetPasswordForm',
        'signOut',
        'listUsers',
        'deleteUser',
        'formSearch',
    ],
    'products' => ['index', 'manageProduct', 'add', 'addProductForm', 'update', 'delete'],
);

/**
 *
 * Nếu các tham số nhận được từ URL không hợp lệ (không thuộc list controller và action có thể gọi
 * thì trang báo lỗi sẽ được gọi ra
 * vế đầu là kiểm tra key controller có trong mảng controllers không, không có trả về false, !false = true
 * vế sau là kiêm tra giá trị action có tồn tại trong mảng controllers[controller] không,
 * không có trả về false, !false = true
 *
 */
if (!array_key_exists($controller, $controllers) || !in_array($action, $controllers[$controller])) {
    $controller = 'users';
    $action = 'error';
}

/**
 *
 * Nhúng file định nghĩa controller vào để có thể dùng được class định nghĩa trong file đó
 *
 */
include_once('controllers/' . $controller . '_controller.php');

/**
 *
 * Tạo ra tên controller class từ các giá trị lấy được từ URL sau đó gọi ra để hiển thị trả về cho người dùng.
 * ucwords($controller, '_') VD: users -> Users_
 * str_replace('_', '', x) thay thế '_' bằng '' VD: Users_ -> Users
 * Users.Controller -> UsersController
 *
 */

$klass = str_replace('_', '', ucwords($controller, '_')) . 'Controller';
$controller = new $klass;
$controller->$action();
<?php
require_once('models/product_model.php');

class BaseController
{
    protected $folder;

    /**
     *
     * Hoa
     * Create at 07-05-2021 17h00
     * get model
     *
     */
    public function model($model)
    {
        require_once('models/' . $model . '_model.php');
        $modelClass = ucfirst($model) . 'Model';
        return new $modelClass;
    }

    /**
     *
     * Hoa
     * Created at 21-04-2021 20h:30
     * render view
     *
     */
    function render($file, $data = array())
    {
        // Kiểm tra file gọi đến có tồn tại hay không?
        $view_file = 'views/' . $this->folder . '/' . $file . '.php';
        if (is_file($view_file)) {
            // Nếu tồn tại file đó thì tạo ra các biến chứa giá trị truyền vào lúc gọi hàm
            extract($data);
            // Sau đó lưu giá trị trả về khi chạy file view template với các dữ liệu đó vào 1 biến chứ chưa hiển thị luôn ra trình duyệt
            ob_start();
            require_once($view_file);
            $content = ob_get_clean();
            // Sau khi có kết quả đã được lưu vào biến $content, gọi ra template chung của hệ thống đế hiển thị ra cho người dùng
            $product = new ProductModel();
            $categories = $product->getCategories();
            require_once('views/layouts/application.php');
        } else {
            // Nếu file muốn gọi ra không tồn tại thì chuyển hướng đến trang báo lỗi.
            header('Location: index.php?controller=users&action=error');
        }
    }
}
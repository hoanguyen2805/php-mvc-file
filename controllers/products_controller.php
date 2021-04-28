<?php
session_start();
require_once('controllers/base_controller.php');
require_once('models/product.php');
class ProductsController extends BaseController{
    function __construct()
    {
        $this->folder = 'products';
    }

    /**
     *
     * Hoa
     * Created at 26-04-2021 08h:30
     * go to page home
     *
     */
    public function index(){
        $this->render('index');
    }
}
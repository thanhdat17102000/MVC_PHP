<?php

namespace App\Controller;

class Home extends \Core\Controller {

    public function index() {
        session_start();
        $userInfo = isset($_SESSION['userInfo']) ? $_SESSION['userInfo'] : null;
        $categoryModel = new \App\Model\Category();
        $productModel = new \App\Model\Product();

        $listCategory = $categoryModel
                ->db
                ->reset()
                ->where([
                    \App\Model\Category::FIELD_ID_PARENT => \App\Model\Category::ID_ROOT
                ])
                ->get()
                ->result();

        $listProduct = $productModel
                ->db
                ->reset()
                ->order([
                    \App\Model\Product::FIELD_ID => "DESC"
                ])
                ->limit(4)
                ->get()
                ->result();
        $this->view('page/home/index', [
                'listCategory' =>$listCategory,
                'listProduct' =>$listProduct,
                'productModel' => $productModel,
                'categoryModel' => $categoryModel,
                'userInfo' => $userInfo,
                'action' => 'index'
        ]);
    }

}

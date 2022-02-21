<?php

namespace App\Controller;

class Product extends \Core\Controller {

    function detail($productId) {
        session_start();
        $userInfo = isset($_SESSION['userInfo']) ? $_SESSION['userInfo'] : null;
        $categoryModel = new \App\Model\Category();
        $productModel = new \App\Model\Product();

        $product = false;
        $breakcums = [];

        if ($productId != false) {
            $product = $productModel
                    ->db
                    ->reset()
                    ->where([
                        \App\Model\Product::FIELD_ID => $productId
                    ])
                    ->get()
                    ->result();
            if ($product != false) {
                $product = $product[0];
                $breakcums = $categoryModel->getBreakcums($product[\App\Model\Product::FIELD_ID_CATEGORY]);
                // Tăng lượt xem sản phẩm thêm +1
                $product[\App\Model\Product::FIELD_VIEW]++;
                $productModel
                        ->db
                        ->reset()
                        ->where([
                            \App\Model\Product::FIELD_ID => $productId
                        ])
                        ->update([
                            \App\Model\Product::FIELD_VIEW => $product[\App\Model\Product::FIELD_VIEW]
                ]);
            }
        }
        $this->view('page/product/detail', [
            'product' => $product,
            'breakcums' => $breakcums,
            'productModel' => $productModel,
            'categoryModel' => $categoryModel,
            'action'=>'product',
            'userInfo' => $userInfo
        ]);
    }

    function ajax_like() {
        $result = [
            'status' => 'OK',
            'msg' => 'Đã đánh dấu thích sản phẩm',
            'data' => [],
        ];

        $productModel = new \App\Model\Product();
        $product = $productModel
                ->db
                ->reset()
                ->where([
                    \App\Model\Product::FIELD_ID => $_POST['productId']
                ])
                ->get()
                ->result();
        if ($product != false) {
            $product = $product[0];
            // Tăng lượt thích sản phẩm thêm +1
            $product[\App\Model\Product::FIELD_LIKE]++;
            $productModel
                    ->db
                    ->reset()
                    ->where([
                        \App\Model\Product::FIELD_ID => $product[\App\Model\Product::FIELD_ID]
                    ])
                    ->update([
                        \App\Model\Product::FIELD_LIKE => $product[\App\Model\Product::FIELD_LIKE]
            ]);
            $result['data']['totalLike'] = $product[\App\Model\Product::FIELD_LIKE];
        } else {
            $result = [
                'status' => 'NG',
                'msg' => 'Sản phẩm không khả dụng',
                'data' => [],
            ];
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function ajax_addToCart() {
        $result = [
            'status' => 'OK',
            'msg' => 'Đã thêm vào giỏ hàng',
            'data' => [],
        ];
        $productId = $_POST['productId'];
        $productModel = new \App\Model\Product();
        $product = $productModel
                ->db
                ->reset()
                ->where([
                    \App\Model\Product::FIELD_ID => $productId
                ])
                ->get()
                ->result();
        if ($product != false) {
            $product = $product[0];
            // Thêm sản phẩm vào giỏ hàng bằng cookie
            $cart = [];
            if (isset($_COOKIE['cart'])) {
                $cart = $_COOKIE['cart'];
                $cart = json_decode($cart, true);
            }
            if (!isset($cart[$productId])) {
                $cart[$productId] = 0;
            }
            $cart[$productId] += $_POST['quanti'];
            setcookie('cart', json_encode($cart, JSON_UNESCAPED_UNICODE), time() + 6 * 30 * 24 * 60 * 60, '/');
        } else {
            $result = [
                'status' => 'NG',
                'msg' => 'Sản phẩm không khả dụng',
                'data' => [],
            ];
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

}

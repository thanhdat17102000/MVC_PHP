<?php

namespace App\Controller;

class Cart extends \Core\Controller {

    function index() {
        session_start();
        $userInfo = isset($_SESSION['userInfo']) ? $_SESSION['userInfo'] : null;
        $categoryModel = new \App\Model\Category();
        $productModel = new \App\Model\Product();

        $cart = [];
        if (isset($_COOKIE['cart'])) {
            $cart = $_COOKIE['cart'];
            $cart = json_decode($cart, true);
        }

        $cartData = [];
        $totalMomey = 0;
        if (!empty($cart)) {
            foreach ($cart as $productId => $buyQuanti) {
                $productRow = $productModel->db->reset()->where([
                            \App\Model\Product::FIELD_ID => $productId
                        ])->get()->result();

                if ($productRow != false) {
                    $productRow[0]['totalMoney'] = $productRow[0][\App\Model\Product::FIELD_PRICE] * $buyQuanti;
                    $totalMomey += $productRow[0]['totalMoney'];
                    array_push($cartData, [
                        'productRow' => $productRow[0],
                        'buyQuanti' => $buyQuanti
                    ]);
                }
            }
        }
        $this->view('page/cart/index', [
            'cartData' => $cartData,
            'categoryModel' => $categoryModel,
            'productModel' => $productModel,
            'cart' => $cart,
            'totalMomey' => $totalMomey,
            'userInfo' => $userInfo,
            'action' => 'cart'
        ]);
    }

    function ajax_updateQuanti() {
        $result = [
            'status' => 'OK',
            'msg' => 'Đã cập nhật giỏ hàng',
            'data' => [],
        ];
        $productId = $_POST['productId'];
        $quanti = $_POST['quanti'];

        $cart = [];
        if (isset($_COOKIE['cart'])) {
            $cart = $_COOKIE['cart'];
            $cart = json_decode($cart, true);
        }
        if (isset($cart[$productId])) {
            $cart[$productId] = $quanti;
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

    function ajax_bulkDelete() {
        $result = [
            'status' => 'OK',
            'msg' => 'Đã cập nhật giỏ hàng',
            'data' => [],
        ];
        $productIds = $_POST['productIds'];

        $cart = [];
        if (isset($_COOKIE['cart'])) {
            $cart = $_COOKIE['cart'];
            $cart = json_decode($cart, true);
        }

        if (!empty($cart) && !empty($productIds)) {
            foreach ($productIds as $productId) {
                unset($cart[$productId]);
            }
        }

        setcookie('cart', json_encode($cart, JSON_UNESCAPED_UNICODE), time() + 6 * 30 * 24 * 60 * 60, '/');

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function ajax_buyProcessDone() {
        $result = [
            'status' => 'OK',
            'msg' => 'Tiến hành đặt hàng thành công',
            'data' => [],
        ];
        $productIds = $_POST['productIds'];

        $cart = [];
        if (isset($_COOKIE['cart'])) {
            $cart = $_COOKIE['cart'];
            $cart = json_decode($cart, true);
        }

        if (!empty($cart) && !empty($productIds)) {
            $productModel = new \App\Model\Product();
            $orderModel = new \App\Model\Order();
            $orderDetailModel = new \App\Model\OrderDetail();

            // Create new order
            $orderModel->db->reset()->insert([
                \App\Model\Order::FIELD_NAME => $_POST['name'],
                \App\Model\Order::FIELD_PHONE => $_POST['phone'],
                \App\Model\Order::FIELD_ADDRESS => $_POST['address'],
                \App\Model\Order::FIELD_NOTE => $_POST['note'],
                \App\Model\Order::FIELD_CREATE => time(),
                \App\Model\Order::FIELD_UPDATE => time()
            ]);
            $orderId = $orderModel->db->getConnection()->lastInsertId();
            $totalPrice = 0;

            foreach ($productIds as $productId) {

                $productRow = $productModel->db->reset()->where([
                            \App\Model\Product::FIELD_ID => $productId
                        ])->get()->result();
                if ($productRow != false) {
                    $productRow = $productRow[0];

                    // Add order detail
                    $orderDetailModel->db->reset()->insert([
                        \App\Model\OrderDetail::FIELD_ID_ORDER => $orderId,
                        \App\Model\OrderDetail::FIELD_ID_PRODUCT => $productId,
                        \App\Model\OrderDetail::FIELD_PRICE => $productRow[\App\Model\Product::FIELD_PRICE],
                        \App\Model\OrderDetail::FIELD_QUANTI => $cart[$productId],
                        \App\Model\OrderDetail::FIELD_PRODUCT_NAME => $productRow[\App\Model\Product::FIELD_TITLE]
                    ]);

                    // Calculator the total price of order
                    $totalPrice += $productRow[\App\Model\Product::FIELD_PRICE] * $cart[$productId];

                    // Update quanti, buy for product
                    $productModel->db->reset()->where([
                        \App\Model\Product::FIELD_ID => $productId
                    ])->update([
                        \App\Model\Product::FIELD_QUANTI => $productRow[\App\Model\Product::FIELD_QUANTI] - $cart[$productId],
                        \App\Model\Product::FIELD_BUY => $productRow[\App\Model\Product::FIELD_BUY] + $cart[$productId]
                    ]);
                }

                // Remove from the cart
                unset($cart[$productId]);
            }

            // Update total price for order
            $orderModel->db->reset()->where([
                \App\Model\Order::FIELD_ID => $orderId
            ])->update([
                \App\Model\Order::FIELD_TOTAL_PRICE => $totalPrice
            ]);
        }

        setcookie('cart', json_encode($cart, JSON_UNESCAPED_UNICODE), time() + 6 * 30 * 24 * 60 * 60, '/');

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

}

<?php

namespace App\Controller;

class Admin extends \Core\Controller {

    function index() {
        return $this->category();
    }

    function category() {
        $this->view('admin/index', [
            'action' => 'category'
        ]);
    }

    function product() {
        $categoryModel = new \App\Model\Category();
        $productModel = new \App\Model\Product();
        $categoryModel->db->reset();
        $listCategory = $categoryModel->getAllCategory();
        $productStatusLabels = $productModel->getStatusLabel();
        $this->view('admin/index', [
            'action' => 'product',
            'listCategory' => $listCategory,
            'productStatusLabels' => $productStatusLabels
        ]);
    }

    function order() {
        $categoryModel = new \App\Model\Category();
        $productModel = new \App\Model\Product();
        $orderModel = new \App\Model\Order();
        $orderStatusLabel = $orderModel->getStatusLabel();
        $orderStatusPurcharLabel = $orderModel->getStatusPurcharLabel();
        $orderStatusShipLabel = $orderModel->getStatusShipLabel();
        $this->view('admin/index', [
            'action' => 'order',
            'orderStatusLabel' => $orderStatusLabel,
            'orderStatusPurcharLabel' => $orderStatusPurcharLabel,
            'orderStatusShipLabel' => $orderStatusShipLabel
        ]);
    }

    function ajaxcategory_loadlist() {
        $result = [
            'status' => 'OK',
            'msg' => 'Tải danh mục thành công',
            'data' => [],
        ];

        $categoryModel = new \App\Model\Category();
        $listCategory = $categoryModel->getAllCategory();
        if (!empty($listCategory)) {
            $result['data'] = $listCategory;
        }

        if ($categoryModel->db->getErrorText() !== null) {
            $result = [
                'status' => 'NG',
                'msg' => $categoryModel->db->getErrorText(),
                'data' => [],
            ];
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function ajaxcategory_add() {
        $result = [
            'status' => 'OK',
            'msg' => 'Thêm danh mục thành công',
            'data' => [],
        ];

        $categoryModel = new \App\Model\Category();
        $categoryModel->db->insert([
            \App\Model\Category::FIELD_TITLE => $_POST['categoryTitle'],
            \App\Model\Category::FIELD_ID_PARENT => $_POST['categoryIdParent']
        ]);

        if ($categoryModel->db->getErrorText() !== null) {
            $result = [
                'status' => 'NG',
                'msg' => $categoryModel->db->getErrorText(),
                'data' => [],
            ];
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function ajaxcategory_delete() {
        $result = [
            'status' => 'OK',
            'msg' => 'Xóa danh mục thành công',
            'data' => [],
        ];

        $categoryModel = new \App\Model\Category();
        $categoryModel->db->where([
            \App\Model\Category::FIELD_ID => $_POST['idCategory']
        ])->delete();

        if ($categoryModel->db->getErrorText() !== null) {
            $result = [
                'status' => 'NG',
                'msg' => $categoryModel->db->getErrorText(),
                'data' => [],
            ];
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function ajaxcategory_loadDetail() {
        $result = [
            'status' => 'OK',
            'msg' => 'Lấy thông tin danh mục thành công',
            'data' => [],
        ];

        $categoryModel = new \App\Model\Category();
        $list = $categoryModel->db->where([
                    \App\Model\Category::FIELD_ID => $_POST['idCategory']
                ])->get()->result();
        if ($list != false) {
            $result['data'] = $list[0];
        }

        if ($categoryModel->db->getErrorText() !== null) {
            $result = [
                'status' => 'NG',
                'msg' => $categoryModel->db->getErrorText(),
                'data' => [],
            ];
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function ajaxcategory_update() {
        $result = [
            'status' => 'OK',
            'msg' => 'Cập nhật danh mục thành công',
            'data' => [],
        ];

        $categoryModel = new \App\Model\Category();
        $categoryModel->db->where([
            \App\Model\Category::FIELD_ID => $_POST['idCategory']
        ])->update([
            \App\Model\Category::FIELD_TITLE => $_POST['categoryTitle'],
            \App\Model\Category::FIELD_ID_PARENT => $_POST['categoryIdParent'],
            \App\Model\Category::FIELD_INDEX => $_POST['categoryIndex'],
        ]);

        if ($categoryModel->db->getErrorText() !== null) {
            $result = [
                'status' => 'NG',
                'msg' => $categoryModel->db->getErrorText(),
                'data' => [],
            ];
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function ajaxproduct_loadlist() {
        $categoryModel = new \App\Model\Category();
        $productModel = new \App\Model\Product();
        $listProduct = $productModel
                ->db
                ->reset()
                ->order([
                    \App\Model\Product::FIELD_ID => "DESC"
                ])
                ->get()
                ->result();
        if (!empty($listProduct)) {
            foreach ($listProduct as $key => $product) {
                // Get category data
                $category = $categoryModel
                        ->db
                        ->reset()
                        ->where([
                            \App\Model\Category::FIELD_ID => $product[\App\Model\Product::FIELD_ID_CATEGORY]
                        ])
                        ->get()
                        ->result();
                if ($category == false) {
                    $listProduct[$key]['categoryInfo'] = null;
                } else {
                    $listProduct[$key]['categoryInfo'] = $category[0];
                }

                // Get status text
                $listProduct[$key]['m_status_text'] = $productModel->getStatusLabel()[$product[\App\Model\Product::FIELD_STATUS]];

                // Get avata
                $avata = [
                    'original' => $productModel->getAvataOriginal($product[\App\Model\Product::FIELD_ID]),
                    'thumbs' => []
                ];
                foreach ($productModel->avataThumbs as $avataType => $avataConfig) {
                    $avata['thumbs'][$avataType] = $productModel->getAvata($product[\App\Model\Product::FIELD_ID], $avataType);
                }
                $listProduct[$key]['avata'] = $avata;
            }
            $result['data'] = $listProduct;
        }

        if ($productModel->db->getErrorText() !== null) {
            $result = [
                'status' => 'NG',
                'msg' => $productModel->db->getErrorText(),
                'data' => [],
            ];
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function ajaxproduct_add() {
        $result = [
            'status' => 'OK',
            'msg' => 'Thêm sản phẩm thành công',
            'data' => [],
        ];

        $productModel = new \App\Model\Product();
        $productModel->db->insert([
            \App\Model\Product::FIELD_TITLE => $_POST['productTitle'],
            \App\Model\Product::FIELD_TIME_CREATE => time(),
            \App\Model\Product::FIELD_TIME_UPDATE => time()
        ]);

        if ($productModel->db->getErrorText() !== null) {
            $result = [
                'status' => 'NG',
                'msg' => $productModel->db->getErrorText(),
                'data' => [],
            ];
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function ajaxproduct_delete() {
        $result = [
            'status' => 'OK',
            'msg' => 'Xóa sản phẩm thành công',
            'data' => [],
        ];

        $productModel = new \App\Model\Product();
        $productModel->db->where([
            \App\Model\Product::FIELD_ID => $_POST['idProduct']
        ])->delete();

        if ($productModel->db->getErrorText() !== null) {
            $result = [
                'status' => 'NG',
                'msg' => $productModel->db->getErrorText(),
                'data' => [],
            ];
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function ajaxproduct_deleteAvata() {
        $result = [
            'status' => 'OK',
            'msg' => 'Xóa hình ảnh sản phẩm thành công',
            'data' => [],
        ];

        $productModel = new \App\Model\Product();
        $deleteStatus = $productModel->delAvata($_POST["idProduct"]);

        if ($deleteStatus === false) {
            $result = [
                'status' => 'NG',
                'msg' => "Không xóa được hình ảnh sản phẩm",
                'data' => [],
            ];
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function ajaxproduct_loadDetail() {
        $result = [
            'status' => 'OK',
            'msg' => 'Lấy thông tin sản phẩm thành công',
            'data' => [],
        ];

        $productModel = new \App\Model\Product();
        $list = $productModel->db->where([
                    \App\Model\Product::FIELD_ID => $_POST['idProduct']
                ])->get()->result();
        if ($list != false) {
            $result['data'] = $list[0];
            // Get avata
            $avata = [
                'original' => $productModel->getAvataOriginal($list[0][\App\Model\Product::FIELD_ID]),
                'thumbs' => []
            ];
            foreach ($productModel->avataThumbs as $avataType => $avataConfig) {
                $avata['thumbs'][$avataType] = $productModel->getAvata($list[0][\App\Model\Product::FIELD_ID], $avataType);
            }
            $result['data']['avata'] = $avata;
        }

        if ($productModel->db->getErrorText() !== null) {
            $result = [
                'status' => 'NG',
                'msg' => $productModel->db->getErrorText(),
                'data' => [],
            ];
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function ajaxproduct_update() {
        $result = [
            'status' => 'OK',
            'msg' => 'Cập nhật sản phẩm thành công',
            'data' => [],
        ];

        $productModel = new \App\Model\Product();
        $productModel->db->where([
            \App\Model\Product::FIELD_ID => $_POST['idProduct']
        ])->update([
            \App\Model\Product::FIELD_TITLE => $_POST['productTitle'],
            \App\Model\Product::FIELD_ID_CATEGORY => $_POST['productIdCategory'],
            \App\Model\Product::FIELD_TIME_UPDATE => time(),
            \App\Model\Product::FIELD_STATUS => $_POST['productStatus'],
            \App\Model\Product::FIELD_PRICE => $_POST['productPrice'],
            \App\Model\Product::FIELD_ORIGINAL_PRICE => $_POST['productOriginalPrice'],
            \App\Model\Product::FIELD_QUANTI => $_POST['productQuanti'],
            \App\Model\Product::FIELD_BUY => $_POST['productBuy'],
            \App\Model\Product::FIELD_SHORT_DESCRIPTION => $_POST['productShortDescription'],
            \App\Model\Product::FIELD_DESCRIPTION => $_POST['productDescription']
        ]);

        if ($productModel->db->getErrorText() !== null) {
            $result = [
                'status' => 'NG',
                'msg' => $productModel->db->getErrorText(),
                'data' => [],
            ];
        } else {
            if (trim($_POST['imageData']) != "") {
                $productModel->setAvata($_POST['idProduct'], $_POST['imageData']);
            }
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function ajaxorder_loadlist() {
        $result = [
            'status' => 'OK',
            'msg' => 'Tải đơn hàng thành công',
            'data' => [],
        ];

        $categoryModel = new \App\Model\Category();
        $productModel = new \App\Model\Product();
        $orderModel = new \App\Model\Order();
        $listOrder = $orderModel
                ->db
                ->reset()
                ->order([
                    \App\Model\Order::FIELD_ID => "DESC"
                ])
                ->get()
                ->result();
        if (!empty($listOrder)) {
            foreach ($listOrder as $key => $order) {
                $listOrder[$key]['m_status_text'] = $orderModel->getStatusLabel()[$order[\App\Model\Order::FIELD_STATUS]];
                $listOrder[$key]['m_status_purchar_text'] = $orderModel->getStatusPurcharLabel()[$order[\App\Model\Order::FIELD_STATUS_PURCHAR]];
                $listOrder[$key]['m_status_ship_text'] = $orderModel->getStatusShipLabel()[$order[\App\Model\Order::FIELD_STATUS_SHIP]];
            }
            $result['data'] = $listOrder;
        }

        if ($orderModel->db->getErrorText() !== null) {
            $result = [
                'status' => 'NG',
                'msg' => $orderModel->db->getErrorText(),
                'data' => []
            ];
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function ajaxorder_loadDetail() {
        $result = [
            'status' => 'OK',
            'msg' => 'Tải chi tiết đơn hàng thành công',
            'data' => [],
        ];

        $categoryModel = new \App\Model\Category();
        $productModel = new \App\Model\Product();
        $orderModel = new \App\Model\Order();
        $orderDetailModel = new \App\Model\OrderDetail();
        $orderId = $_POST['orderId'];
        $order = $orderModel
                ->db
                ->reset()
                ->where([
                    \App\Model\Order::FIELD_ID => $orderId
                ])
                ->get()
                ->result();
        if (!empty($order)) {
            $order = $order[0];
            $order['m_status_text'] = $orderModel->getStatusLabel()[$order[\App\Model\Order::FIELD_STATUS]];
            $order['m_status_purchar_text'] = $orderModel->getStatusPurcharLabel()[$order[\App\Model\Order::FIELD_STATUS_PURCHAR]];
            $order['m_status_ship_text'] = $orderModel->getStatusShipLabel()[$order[\App\Model\Order::FIELD_STATUS_SHIP]];

            // Get the order detail
            $order['details'] = [];
            $details = $orderDetailModel
                    ->db
                    ->reset()
                    ->where([
                        \App\Model\OrderDetail::FIELD_ID_ORDER => $orderId
                    ])
                    ->get()
                    ->result();

            if (!empty($details)) {
                foreach ($details as $detail) {
                    array_push($order['details'], $detail);
                }
            }

            $result['data'] = $order;
        }

        if ($orderModel->db->getErrorText() !== null) {
            $result = [
                'status' => 'NG',
                'msg' => $orderModel->db->getErrorText(),
                'data' => []
            ];
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    function ajaxorder_save() {
        $result = [
            'status' => 'OK',
            'msg' => 'Cập nhật đơn hàng thành công',
            'data' => [],
        ];

        $orderId = $_POST['orderId'];
        $status = $_POST['status'];
        $purchar = $_POST['purchar'];
        $ship = $_POST['ship'];

        $categoryModel = new \App\Model\Category();
        $productModel = new \App\Model\Product();
        $orderModel = new \App\Model\Order();
        $orderModel
                ->db
                ->reset()
                ->where([
                    \App\Model\Order::FIELD_ID => $orderId
                ])
                ->update([
                    \App\Model\Order::FIELD_STATUS => $status,
                    \App\Model\Order::FIELD_STATUS_PURCHAR => $purchar,
                    \App\Model\Order::FIELD_STATUS_SHIP => $ship
        ]);

        if ($orderModel->db->getErrorText() !== null) {
            $result = [
                'status' => 'NG',
                'msg' => $orderModel->db->getErrorText(),
                'data' => []
            ];
        }

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

}

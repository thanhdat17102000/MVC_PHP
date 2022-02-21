<?php include_once "./app/View/page/common/header.php" ?>
        <main>
            <div class="container">

                <div class="margin_t1em shop_cart_content">
                    <div class="grid_header">
                        <span class="grid_header_label">Giỏ hàng</span>
                        <div class="clear_both"></div>
                    </div>
                    <div class="grid_content">
                        <div class="shop_cart_actionresult"></div>
                        <select class="margin_l0 align_middle shop_cart_actionlist">
                            <option value="0">- Tác vụ -</option>
                            <option value="del">Xóa</option>
                        </select>
                        <span class="button align_middle shop_cart_actionbtn">Thực hiện</span>
                        <div class="margin_t1em shop_cart_list">
                            <div class="padding_v shop_cart_list_header">
                                <div class="row">
                                    <div class="col-12 col-md-1">
                                        <input class="align_middle btn_checkall" id="shop_cart_btncheckall" type="checkbox" checked="checked" data-checkallfor=".shop_cart_item_check">

                                    </div>
                                    <div class="col-12 col-md-11 destop_label">
                                        <div class="row">
                                            <div class="col-12 col-md-5">Sản Phẩm</div>
                                            <div class="col-12 col-md-7 align_right">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        Đơn giá
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Số lượng
                                                    </div>
                                                    <div class="col-sm-4">
                                                        Thành tiền
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if (!empty($cartData)) {
                                foreach ($cartData as $cartRow) {

                                    echo '
                                    <div class="padding_v shop_cart_item">
                                        <div class="row">
                                            <div class="col-12 col-md-1">
                                                <input class="align_middle shop_cart_item_check" type="checkbox" data-id="' . $cartRow['productRow'][\App\Model\Product::FIELD_ID] . '" checked="checked">
                                            </div>
                                            <div class="col-12 col-md-11">
                                                <div class="row">
                                                    <div class="col-12 col-md-5">
                                                        <div class="">
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col-sm-2">
                                                                    <img class="padding_r1em" style="max-height: 80px; display: block; margin-right: 10px" src="' . $productModel->getAvata($cartRow['productRow'][\App\Model\Product::FIELD_ID], 'small') . '">
                                                                </div>
                                                                <div class="col-sm-10">
                                                                    <span class="fontsize_a2 bold display_inline_block">' . $cartRow['productRow'][\App\Model\Product::FIELD_TITLE] . '</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-12 col-md-7 align_right">
                                                        <div class="row align-items-center">
                                                            <div class="col-sm-4">
                                                                <span class="mobile_label">Đơn giá: </span>
                                                                <span class="cart_item_price">' . number_format($cartRow['productRow'][\App\Model\Product::FIELD_PRICE], 0, ',', '.') . '</span> đ
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <span class="mobile_label">Số lượng: </span>
                                                                <input type="number" name="count_input" data-id="' . $cartRow['productRow'][\App\Model\Product::FIELD_ID] . '" value="' . $cartRow['buyQuanti'] . '">
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <span class="mobile_label">Thành tiền: </span>
                                                                <span class="cart_item_price_total">' . number_format($cartRow['productRow']['totalMoney'], 0, ',', '.') . '</span> đ
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                }
                            } else {
                                echo '<p class="margin_t padding_l1em">Hiện chưa có sản phẩm nào trong giỏ hàng.</p>';
                            }
                            ?>
                        </div>
                        <div class="margin_t1em">&nbsp;</div>
                        <div class="margin_t1em">
                            <i class="fa fa-money"></i> 
                            Tổng thanh toán : <span class="totalMoney"><?= number_format($totalMomey, 0, ',', '.') ?></span> đ
                        </div>
                        <div class="margin_t1em padding_v1em">
                            <span class="padding margin_l0 button noborder paybtn_cash">Tiến hành đặt hàng</span>
                        </div>
                    </div>
                </div>
                <div class="dialog cart-buyProcessDialog">
                    <div class="dialog-inside">
                        <div class="dialog-header">Tiến hành đặt hàng</div>
                        <div class="dialog-content">
                            <h2 class="margin_b1em">Hãy nhập vào thông tin để nhận hàng</h2>
                            <div class="row">
                                <div class="col-6">
                                    <label for="buyProcessName">Tên người nhận</label>
                                    <input type="text" id='buyProcessName' class="fullwidth">
                                </div>
                                <div class="col-6">
                                    <label for="buyProcessPhone">Số điện thoại</label>
                                    <input type="text" id='buyProcessPhone' class="fullwidth">
                                </div>
                            </div>
                            
                            <label for="buyProcessAddress" class='margin_t'>Địa chỉ</label>
                            <input type="text" id='buyProcessAddress' class="fullwidth">
                            
                            <label for="buyProcessNote" class='margin_t'>Ghi chú</label>
                            <textarea type="text" id='buyProcessNote' class="fullwidth"></textarea>

                        </div>
                        <div class="dialog-footer">
                            <span class="button dialog-close-btn">Đóng</span>
                            <span class="button dialog-ok-btn">Hoàn tất đặt hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once "app/View/page/common/footer.php" ?>


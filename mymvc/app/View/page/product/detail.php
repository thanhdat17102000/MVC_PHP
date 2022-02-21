<?php include_once "./app/View/page/common/header.php" ?>
<main>
    <div class="container">
        <h1 class="page-title" data-product-id="<?= $product[\App\Model\Product::FIELD_ID] ?>"><?= $product[\App\Model\Product::FIELD_TITLE] ?></h1>
        <div class="product_detail_info">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="align_center margin_b1em">
                        <img class="product-avata" src="<?= $productModel->getAvata($product[\App\Model\Product::FIELD_ID], 'large') ?>" alt="<?= $product[\App\Model\Product::FIELD_TITLE] ?>" />
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <p class="product_profile_scrible"><?= $product[\App\Model\Product::FIELD_SHORT_DESCRIPTION] ?></p>
                    <div class="fontsize_d2 stt_tip product_profile_linktype">
                        <a class="display_inline_block" href="index.php">Sản phẩm</a>
                        <?php
                        if (!empty($breakcums)) {
                            foreach ($breakcums as $categoryItem) {
                                echo ' / <a class="display_inline_block" href="category.php?id=' . $categoryItem[\App\Model\Product::FIELD_ID] . '">' . $categoryItem[\App\Model\Product::FIELD_TITLE] . '</a>';
                            }
                        }
                        ?>
                    </div>
                    <div class="margin_b">
                        <span class="margin_r1em align_middle product_profile_realprice">
                            <i class="fa fa-level-up fa-rotate-90"></i>
                            <?= number_format($product[\App\Model\Product::FIELD_PRICE], 0, ',', '.') ?> đ
                        </span>
                        <span class="margin_r1em align_middle product_profile_saleoff">- <?= number_format($product[\App\Model\Product::FIELD_PRICE] / $product[\App\Model\Product::FIELD_ORIGINAL_PRICE] * 100, 0, ',', '.') ?> %</span>
                        <span class="stt_tip align_middle product_profile_price">Giá gốc <?= number_format($product[\App\Model\Product::FIELD_ORIGINAL_PRICE], 0, ',', '.') ?> đ</span>
                    </div>

                    <div class="margin_v1em product_profile_action_order">
                        Số lượng ( Chỉ còn lại
                        <span id="productDetail-quantiMax"><?= $product[\App\Model\Product::FIELD_QUANTI] ?></span>
                        sản phẩm)
                        <div class="margin_t button-group">
                            <input type="number" placeholder="Số lượng" title="Số lượng" value="1" class="product_profile_count_select">
                            <span class="button" id="productDetail-addToCart-btn">
                                <i class="fa fa-cart-plus"></i>
                                Đặt hàng
                            </span>
                        </div>
                        <div class="dialog productDetail-addToCartDialog">
                            <div class="dialog-inside">
                                <div class="dialog-header">Thêm sản phẩm vào giỏ hàng</div>
                                <div class="dialog-content">Đang tiến hành, xin chờ...</div>
                                <div class="dialog-footer">
                                    <span class="button dialog-close-btn">Đóng</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="padding_v margin_t1em button-group">
                        <span class="display_inline_block align_middle margin_r">
                            <span class="button gray noborder" id="productDetail-like-btn">
                                <span class="align_middle">
                                    <i class="fa fa-heart-o"></i>
                                    Thích
                                    <span id="productDetail-like-total"><?= $product[\App\Model\Product::FIELD_LIKE] ?></span>
                                </span>
                            </span>
                        </span>
                        <span class="display_inline_block align_middle margin_r">
                            <span class="align_middle">Đánh giá </span>
                            <span class="display_inline_block align_middle">
                                <i class="fa fa-star-o stt_action"></i>
                                <i class="fa fa-star-o stt_action"></i>
                                <i class="fa fa-star-o stt_action"></i>
                                <i class="fa fa-star-o stt_action"></i>
                                <i class="fa fa-star-o stt_action"></i>
                            </span>
                        </span>
                        <span class="display_inline_block align_middle">
                            <span class="button transparent">
                                <i class="fa fa-eye"></i>
                                <?= $product[\App\Model\Product::FIELD_VIEW] ?> Lượt xem
                            </span>
                        </span>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include_once "app/View/page/common/footer.php" ?>
<?php include_once "./app/View/page/common/header.php" ?>
<main>
    <div class="container">
        <div class="product_type_box">
            <div class="padding padding_h1em">
                <div class="product_type_listbox">
                    <?php
                    if ($listCategory != false) {
                        foreach ($listCategory as $category) {
                            echo '<a class="product_type_item" href="category?id=' . $category[\App\Model\Category::FIELD_ID] . '" title="' . $category[\App\Model\Category::FIELD_TITLE] . '">
                                <img src="asset/img/system/category.png" alt="' . $category[\App\Model\Category::FIELD_TITLE] . '" class="align_middle product_type_item_avata">
                                <span class="align_middle product_type_item_title">
                                    ' . $category[\App\Model\Category::FIELD_TITLE] . '
                                </span>
                            </a>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="shop_product_box">
            <div class="header">
                Sản Phẩm Mới
            </div>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        if ($listProduct != false) {
                            foreach ($listProduct as $product) {
                                echo '<div class="col-12 col-md-6 col-lg-3">
                                    <div class="padding">
                                        <div class="product_item_2">
                                            <div class="product_item_2_avata_box">
                                                <a href="product/detail/' . $product[\App\Model\Product::FIELD_ID] . '" title="' . $product[\App\Model\Product::FIELD_TITLE] . '">
                                                    <img src="' . $productModel->getAvata($product[\App\Model\Product::FIELD_ID], 'medium') . '" alt="' . $product[\App\Model\Product::FIELD_TITLE] . '" class="product_item_2_avata">
                                                </a>
                                            </div>
                                            <div class="product_item_2_detailbox">
                                                <div class="product_item_2_title">
                                                    <a href="product/detail/' . $product[\App\Model\Product::FIELD_ID] . '" title="' . $product[\App\Model\Product::FIELD_TITLE] . '" class="">' . $product[\App\Model\Product::FIELD_TITLE] . '</a>
                                                </div>
                                                <div class="align_center product_item_2_moredetail">
                                                    <span class="display_inline_block product_item_2_price">
                                                        ' . number_format($product[\App\Model\Product::FIELD_PRICE], 0, ',', '.') . 'đ
                                                    </span>
                                                    <div class="product_item_2_button">
                                            <a href="product/detail/' . $product[\App\Model\Product::FIELD_ID] . '" title="' . $product[\App\Model\Product::FIELD_TITLE] . '">
                                                <button class="btn btn-2">Xem chi tiết >></button>        
                                            </a>
                                            </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include_once "app/View/page/common/footer.php" ?>
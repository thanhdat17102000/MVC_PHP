<form action="javascript:void(0)" method="post" id="admin-product-add">
    <h3>Thêm sản phẩm mới</h3>
    <div id="admin-product-add-status"></div>
    <div class="input-box">
        <input id="admin-product-add-name" type="text" placeholder="Nhập vào tên sản phẩm mới..." value="">
    </div>
    <div class="btn-box">
        <button type="submit" id="admin-product-add-btn">Thêm</button>
    </div>
</form>

<form action="javascript:void(0)" method="post" id="admin-product-edit">
    <h3>Chỉnh sửa sản phẩm</h3>
    <br>
    <div id="admin-product-edit-status"></div>
    <div class="row">
        <div class="col-12 col-md-4">
            <div class="input-box">
                <label for="admin-product-edit-name">Tên sản phẩm</label>
                <input id="admin-product-edit-name" type="text" placeholder="Nhập vào tên sản phẩm" value="">
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="input-box">
                <label for="admin-product-edit-category">Danh mục</label>
                <select id="admin-product-edit-category">
                    <option value="0">----</option>
                    <?php
                    if (!empty($listCategory)) {

                        function renderItems($items, &$str, $indent) {
                            forEach ($items as $item) {
                                if (count($item['subCategory']) > 0) {
                                    renderItems($item['subCategory'], $str, $indent + 4);
                                }

                                $indentText = "";
                                for ($i = 0; $i < $indent; $i++) {
                                    $indentText .= "&nbsp;";
                                }

                                $str = '<option value="' . $item[\App\Model\Category::FIELD_ID] . '">' . $indentText . $item[\App\Model\Category::FIELD_TITLE] . '</option>' . $str;
                            }
                        }

                        $str = "";
                        renderItems($listCategory, $str, 0);
                        echo $str;
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="input-box">
                <label for="admin-product-edit-currentStatus">Trạng thái</label>
                <select id="admin-product-edit-currentStatus">
                    <?php
                    forEach ($productStatusLabels as $key => $value) {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-3">
            <div class="input-box">
                <label for="admin-product-edit-price">Giá bán</label>
                <input id="admin-product-edit-price" type="text" value="">
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="input-box">
                <label for="admin-product-edit-original-price">Giá gốc</label>
                <input id="admin-product-edit-original-price" type="text" value="">
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="input-box">
                <label for="admin-product-edit-quanti">Số lượng tồn kho</label>
                <input id="admin-product-edit-quanti" type="text" value="">
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="input-box">
                <label for="admin-product-edit-buy">Số lượng đã bán</label>
                <input id="admin-product-edit-buy" type="text" value="">
            </div>
        </div>

    </div>

    <div class="admin-product-edit-avata">
        Hình ảnh sản phẩm
        <div class="row">
            <div class="col-12 col-md-4">
                <input type="file" id="admin-product-edit-avata-input" accept=".jpg,.png">
                <div id="admin-product-edit-avata-preview-box">
                    <div id="admin-product-edit-avata-preview-inside">
                        <img src="../assets/img/default/product.jpg" alt="Hình ảnh xem trước" id="admin-product-edit-avata-preview">
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-2">
                <div class="row">
                    <div class="col-6 col-md-12">
                        <div class="btn-box">
                            <span class="button" id="admin-product-edit-avata-btn-change">Đổi hình</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-12">
                        <div class="btn-box">
                            <span class="button" id="admin-product-edit-avata-btn-delete">Xóa hình</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div id="admin-product-edit-avata-status"></div>
                <div id="admin-product-edit-avata-info">
                    <p>
                        -Tên file: 
                        <span id="admin-product-edit-avata-info-name">----</span>
                    </p>
                    <p>
                        -Định dạng: 
                        <span id="admin-product-edit-avata-info-type">----</span>
                    </p>
                    <p>
                        -Dung lượng: 
                        <span id="admin-product-edit-avata-info-size">----</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id='admin-product-edit-short-description-box'>
        Mô tả ngắn
        <textarea id='admin-product-edit-short-description'></textarea>
    </div>
    
    
    <div id='admin_product_edit_description_box'>
        Mô tả chi tiết sản phẩm
        <div id='admin_product_edit_description'></div>
    </div>

    <div class="btn-box">
        <button type="submit" id="admin-product-edit-submit-btn" data-id="">Cập nhật</button>
        &nbsp;&nbsp;
        <button type="submit" id="admin-product-edit-close-btn" data-id="">Đóng</button>
    </div>
</form>

<div id="admin-product-list">
    <h3>Danh sách sản phẩm</h3>
    <div id="admin-product-list-scrollbox">
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Danh mục</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Tổng SL</th>
                    <th>SL Đã bán</th>
                    <th>Tác vụ</th>
                </tr>
            </thead>
            <tbody id="admin-product-list-content">

            </tbody>
        </table>
    </div>
</div>
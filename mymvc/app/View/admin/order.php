<div class="">
    <div class="margin_b1em">
        <h2>Quản lý đơn hàng</h2>
        <span class="button radius_5px admin-order-btnLoadlist">
            <i class="fa fa-refresh"></i>
        </span>
    </div>
    <div class="admin-order-list">
        <div class="header">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-12 col-lg-1">
                        Mã
                    </div>
                    <div class="col-12 col-lg-2">
                        Khách hàng
                    </div>
                    <div class="col-12 col-lg-2">
                        Giá trị
                    </div>
                    <div class="col-12 col-lg-2">
                        Trạng thái
                    </div>
                    <div class="col-12 col-lg-2">
                        Ngày tạo
                    </div>
                    <div class="col-12 col-lg-2">
                        Tác vụ
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="content">
                hihi
            </div>
        </div>
    </div>
    <div class="dialog admin-order-detail">
        <div class="dialog-inside">
            <div class="dialog-header">Chi tiết đơn hàng</div>
            <div class="dialog-content">Đang tải thông tin, xin chờ...</div>
            <div class="dialog-footer">
                <span class="button dialog-close-btn">Đóng</span>
            </div>
        </div>
    </div>
    <div class="dialog admin-order-update">
        <div class="dialog-inside">
            <div class="dialog-header">Cập nhật đơn hàng</div>
            <div class="dialog-content">
                <b>Mã hóa đơn:</b>
                <span id="admin-order-update-id">----</span>
                <div class="horizon"></div>
                <div class="row">
                    <div class="col-4">
                        Trạng thái thanh toán
                        <br>
                        <select id="admin-order-update-purchar">
                            <?php
                                foreach ($orderStatusPurcharLabel as $code => $label) {
                                    echo "<option value='".$code."'>".$label."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-4">
                        Trạng thái giao hàng
                        <br>
                        <select id="admin-order-update-ship">
                            <?php
                                foreach ($orderStatusShipLabel as $code => $label) {
                                    echo "<option value='".$code."'>".$label."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-4">
                        Tiến độ đơn hàng
                        <br>
                        <select id="admin-order-update-status">
                            <?php
                                foreach ($orderStatusLabel as $code => $label) {
                                    echo "<option value='".$code."'>".$label."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="dialog-footer">
                <span class="button dialog-close-btn">Đóng</span>
                <span class="button dialog-save-btn">Lưu</span>
            </div>
        </div>
    </div>
</div>
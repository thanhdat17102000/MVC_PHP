(function ($) {
    var adminOrder = function () {
        var self = this;
        this.loadList = function () {
            $(".admin-order-list .content").html("");
            $.ajax({
                url: "admin/ajaxorder_loadlist",
                type: "get",
                beforeSend: function () {
                    $(".admin-order-list .content").text("Đang xử lý, vui lòng chờ...");
                },
                success: function (result) {
                    console.log("++++ Admin order > load list: ");
                    console.log(result);
                    result = JSON.parse(result);
                    self.onLoadedList(result);
                },
                error: function () {
                    $(".admin-order-list .content").addClass('error').text("Có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };
        this.onLoadedList = function (result) {
            $(".admin-order-list .content").text("");
            if (result.data.length > 0) {
                result.data.forEach(function (item) {
                    var createTime = new Date(item.m_create * 1000);
                    $(".admin-order-list .content").append(''
                            + '<div class="row item">'
                            + '    <div class="col-12 col-lg-1">'
                            + '        ' + item.id
                            + '    </div>'
                            + '    <div class="col-12 col-lg-2">'
                            + '        <div class="fontsize_d2">'
                            + '            ' + item.m_name
                            + '            <br>'
                            + '            ' + item.m_phone
                            + '        </div>'
                            + '    </div>'
                            + '    <div class="col-12 col-lg-2">'
                            + '        ' + (item.m_total_price * 1).toLocaleString('it-IT', {style: 'currency', currency: 'VND'}).replace('VND', '') + ' đ'
                            + '    </div>'
                            + '    <div class="col-12 col-lg-2">'
                            + '        ' + item.m_status_text
                            + '        <br>'
                            + '        ' + item.m_status_purchar_text
                            + '        <br>'
                            + '        ' + item.m_status_ship_text
                            + '    </div>'
                            + '    <div class="col-12 col-lg-2">'
                            + '        ' + createTime.getDate() + "/" + (createTime.getMonth() + 1) + "/" + createTime.getFullYear()
                            + '    </div>'
                            + '    <div class="col-12 col-lg-3">'
                            + '        <span class="button small radius_5px admin-order-btnEdit" data-id="' + item.id + '" data-status="' + item.m_status + '" data-status-purchar="' + item.m_status_purchar + '" data-status-ship="' + item.m_status_ship + '">Sửa</span>&nbsp;'
                            + '        <span class="button small radius_5px admin-order-btnDetail" data-id="' + item.id + '">Chi tiết</span>'
                            + '    </div>'
                            + '</div>');
                });
            }
        };
        this.loadDetail = function (orderId) {
            $.ajax({
                url: "admin/ajaxorder_loadDetail",
                type: "post",
                data: {
                    orderId: orderId
                },
                beforeSend: function () {
                    $('.admin-order-detail .dialog-content').html('Đang tải thông tin, xin chờ...');
                    $('.admin-order-detail').addClass('show');
                },
                success: function (result) {
                    console.log("++++ Admin order > load detail: ");
                    console.log(result);
                    result = JSON.parse(result);
                    self.onLoadedDetail(result);
                },
                error: function () {
                    $('.admin-order-detail .dialog-content').text("Có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };
        this.onLoadedDetail = function (result) {
            var detail = ''
                    + '<div id="admin_shop_bill_detail">'
                    + '    <p class="fontsize_a4 margin_v">Khách hàng</p>'
                    + '    <div class="row">'
                    + '        <div class="col-12 col-md-4">'
                    + '            <p>'
                    + '                <b>Tên</b>'
                    + '            </p>'
                    + '            <p class="margin_t margin_b1em">' + result.data.m_name + '</p>'
                    + '        </div>'
                    + '        <div class="col-12 col-md-4">'
                    + '            <p>'
                    + '                <b>Điện thoại</b>'
                    + '            </p>'
                    + '            <p class="margin_t margin_b1em">' + result.data.m_phone + '</p>'
                    + '        </div>'
                    + '    </div>'

                    + '    <div class="horizon"></div>'

                    + '    <p class="fontsize_a4 margin_v">Thanh toán</p>'
                    + '    <div class="row">'
                    + '        <div class="col-12 col-md-4">'
                    + '            <p>'
                    + '                <b>Trạng thái</b>'
                    + '            </p>'
                    + '            <p class="margin_t margin_b1em">' + result.data.m_status_purchar_text + '</p>'
                    + '        </div>'

                    + '        <div class="col-12 col-md-4">'
                    + '            <p>'
                    + '                <b>Tổng tiền</b>'
                    + '            </p>'
                    + '            <p class="margin_t margin_b1em">' + (result.data.m_total_price * 1).toLocaleString('it-IT', {style: 'currency', currency: 'VND'}).replace('VND', '') + ' đ</p>'
                    + '        </div>'
                    + '    </div>'

                    + '    <div class="horizon"></div>'

                    + '    <p class="fontsize_a4 margin_v">Giao hàng</p>'
                    + '    <div class="row">'
                    + '        <div class="col-12 col-md-4">'
                    + '            <p>'
                    + '                <b>Trạng thái</b>'
                    + '            </p>'
                    + '            <p class="margin_t margin_b1em">' + result.data.m_status_ship_text + '</p>'
                    + '        </div>'
                    + '        <div class="col-12 col-md-8">'
                    + '            <p>'
                    + '                <b>Địa chỉ nhận hàng</b>'
                    + '            </p>'
                    + '            <p class="margin_t margin_b1em">' + result.data.m_address + '</p>'
                    + '        </div>'
                    + '    </div>'

                    + '    <div class="horizon"></div>'
                    + '    <p class="fontsize_a4 margin_v">Chi tiết</p>'
                    + '    <div class="row">'
                    + '        <div class="col-12 col-md-4">'
                    + '            <p>'
                    + '                <b>Mã đơn hàng</b>'
                    + '            </p>'
                    + '            <p class="margin_t margin_b1em">' + result.data.id + '</p>'
                    + '        </div>'
                    + '        <div class="col-12 col-md-4">'
                    + '            <p>'
                    + '                <b>Trạng thái</b>'
                    + '            </p>'
                    + '            <p class="margin_t margin_b1em">' + result.data.m_status_text + '</p>'
                    + '        </div>'
                    + '        <div class="col-12 col-md-4">'
                    + '            <p>'
                    + '                <b>Số lượng mặt hàng</b>'
                    + '            </p>'
                    + '            <p class="margin_t margin_b1em">' + result.data.details.length + '</p>'
                    + '        </div>'
                    + '    </div>'
                    + '    <div class="container-fluid">'
                    + '        <div class="row fontsize_a2 bg_dark padding_v admin-order-detail-products-header">'
                    + '            <div class="col-1">STT</div>'
                    + '            <div class="col-5">Tên sản phẩm</div>'
                    + '            <div class="col-2">Số lượng</div>'
                    + '            <div class="col-2">Đơn giá</div>'
                    + '            <div class="col-2">Thành tiền</div>'
                    + '        </div>'
                    + '        <div class="admin-order-detail-products-items"></div>'
                    + '    </div>'
                    + '</div>';

            $('.admin-order-detail .dialog-content').html(detail);

            if (result.data.details.length > 0) {
                for (var i = 0; i < result.data.details.length; i++) {
                    var product = ''
                            + '<div class="row padding_v item">'
                            + '    <div class="col-1">' + (i + 1) + '</div>'
                            + '    <div class="col-5">'
                            + '        ' + result.data.details[i].m_product_name
                            + '    </div>'
                            + '    <div class="col-2">' + result.data.details[i].m_quanti + '</div>'
                            + '    <div class="col-2">' + (result.data.details[i].m_price * 1).toLocaleString('it-IT', {style: 'currency', currency: 'VND'}).replace('VND', '') + ' đ</div>'
                            + '    <div class="col-2">' + (result.data.details[i].m_price * result.data.details[i].m_quanti).toLocaleString('it-IT', {style: 'currency', currency: 'VND'}).replace('VND', '') + ' đ</div>'
                            + '</div>';
                    $('.admin-order-detail-products-items').append(product);
                }
            }
        };
        
        this.save = function(){
            $.ajax({
                url: "admin/ajaxorder_save",
                type: "post",
                data: {
                    orderId: $('#admin-order-update-id').text(),
                    status: $('#admin-order-update-status').val(),
                    purchar: $('#admin-order-update-purchar').val(),
                    ship: $('#admin-order-update-ship').val()
                },
                beforeSend: function () {
                    $(".admin-order-list .content").text("Đang xử lý, vui lòng chờ...");
                },
                success: function (result) {
                    console.log("++++ Admin order > save: ");
                    console.log(result);
                    result = JSON.parse(result);
                    self.loadList();
                    alert("Cập nhật thành công");
                },
                error: function () {
                    alert("Có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };

        // Event
        $(".admin-order-btnLoadlist").click(function(){
            self.loadList();
        });
        $('.admin-order-detail .dialog-close-btn').click(function () {
            $('.admin-order-detail').removeClass('show');
        });
        $('.admin-order-update .dialog-close-btn').click(function () {
            $('.admin-order-update').removeClass('show');
        });
        $('.admin-order-update .dialog-save-btn').click(function () {
            self.save();
        });
        $('.admin-order-list .content').on('click', '.admin-order-btnDetail', function () {
            var orderId = $(this).data('id');
            self.loadDetail(orderId);
        });
        $('.admin-order-list .content').on('click', '.admin-order-btnEdit', function () {
            $('.admin-order-update').addClass('show');
            
            var orderId = $(this).data('id');
            var status = $(this).data('status');
            var statusPurchar = $(this).data('status-purchar');
            var statusShip = $(this).data('status-ship');
            
            $('#admin-order-update-id').text(orderId);
            $('#admin-order-update-status').val(status);
            $('#admin-order-update-purchar').val(statusPurchar);
            $('#admin-order-update-ship').val(statusShip);
        });

        this.loadList();
    };
    $(window).ready(function () {
        new adminOrder();
    });
})($);
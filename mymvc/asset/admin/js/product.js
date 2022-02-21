(function ($) {
    var admin_product = function () {
        var self = this;

        this.imageData = '';

        this.add = function () {
            $("#admin-product-add-status").removeClass('error').html("").show();
            var productTitle = $("#admin-product-add-name").val();
            if (productTitle.length == 0) {
                $("#admin-product-add-status").addClass('error').text("Vui lòng nhập vào tên sản phẩm");
                return;
            }

            $.ajax({
                url: "admin/ajaxproduct_add",
                type: "post",
                data: {
                    productTitle: productTitle
                },
                beforeSend: function () {
                    $("#admin-product-add-status").text("Đang xử lý, vui lòng chờ...");
                },
                success: function (result) {
                    console.log("++++ Admin product > add: ");
                    console.log(result);

                    result = JSON.parse(result);
                    $("#admin-product-add-status").html(result.msg);
                    setTimeout(function () {
                        $("#admin-product-add-status").hide();
                    }, 5000);
                    $("#admin-product-add-name").val("");
                    self.loadlist();
                },
                error: function () {
                    $("#admin-product-add-status").addClass('error').text("Có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };
        this.loadlist = function () {
            $("#admin-product-list-content").html("");
            $.ajax({
                url: "admin/ajaxproduct_loadlist",
                type: "get",
                beforeSend: function () {
                    $("#admin-product-list-content").text("Đang xử lý, vui lòng chờ...");
                },
                success: function (result) {
                    console.log("++++ Admin product > load list: ");
                    console.log(result);
                    result = JSON.parse(result);
                    self.onLoadedList(result);
                },
                error: function () {
                    $("#admin-product-list-content").addClass('error').text("Có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };
        this.onLoadedList = function (result) {
            if (result.data.length == 0) {
                $("#admin-product-list-content").html("<tr><td colspan='9'>Chưa có sản phẩm nào</td></tr>");
            } else {
                $("#admin-product-list-content").html("");
                var stt = 0;
                result.data.forEach(function (item) {
                    stt++;
                    var newItem = $("<tr class='item' data-id='" + item.id + "'></tr>");
                    newItem.append("<td>" + stt + "</td>");
                    newItem.append("<td>" + ((item.categoryInfo != null) ? item.categoryInfo.m_title : "----") + "</td>");
                    newItem.append("<td><div class='item-title'><img class='item-avata' src='../" + item.avata.thumbs.small + "'>" + item.m_title + "</div></td>");
                    newItem.append("<td>" + item.m_price + "</td>");
                    newItem.append("<td>" + item.m_status_text + "</td>");
                    newItem.append("<td>" + item.m_quanti + "</td>");
                    newItem.append("<td>" + item.m_buy + "</td>");
                    newItem.append("<td><i class='fa fa-pencil item-edit-btn' title='Sửa sản phẩm'></i>&nbsp;&nbsp;<i class='fa fa-trash-o item-delete-btn' title='Xóa sản phẩm'></i></td>");

                    $("#admin-product-list-content").append(newItem);
                });
                /*
                 * Event for list
                 */
                $("#admin-product-list-content .item-delete-btn").click(function () {
                    var idProduct = $(this).parents(".item").data('id');
                    self.delete(idProduct);
                });
                $("#admin-product-list-content .item-edit-btn").click(function () {
                    var idProduct = $(this).parents(".item").data('id');
                    self.loadFormEdit(idProduct);
                });
            }
        };
        this.delete = function (idProduct) {
            $.ajax({
                url: "admin/ajaxproduct_delete",
                type: "post",
                data: {
                    idProduct: idProduct
                },
                success: function (result) {
                    console.log("++++ Admin product > delete: ");
                    console.log(result);
                    self.loadlist();
                },
                error: function () {
                    alert("Có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };
        this.deleteAvata = function (idProduct) {
            $.ajax({
                url: "admin/ajaxproduct_deleteAvata",
                type: "post",
                data: {
                    idProduct: idProduct
                },
                success: function (result) {
                    $("#admin-product-edit-avata-preview").attr('src', "../assets/img/default/product.jpg");
                    self.imageData = "";
                    console.log("++++ Admin product > delete avata: ");
                    console.log(result);
                    self.loadlist();
                },
                error: function () {
                    alert("Có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };
        this.loadFormEdit = function (idProduct) {
            self.imageData = '';
            $("#admin-product-edit").show();
            $("#admin-product-edit-status").text("Đang tải dữ liệu, xin chờ");
            $.ajax({
                url: "admin/ajaxproduct_loadDetail",
                type: "post",
                data: {
                    idProduct: idProduct
                },
                success: function (result) {
                    console.log("++++ Admin product > loadDetail: ");
                    console.log(result);
                    result = JSON.parse(result);
                    $("#admin-product-edit-status").html("");
                    $("#admin-product-edit-name").val(result.data.m_title);
                    $("#admin-product-edit-short-description").val(result.data.m_short_description);
                    $("#admin-product-edit-category").val((result.data.m_id_category != null) ? result.data.m_id_category : '0');
                    $("#admin-product-edit-currentStatus").val(result.data.m_status);
                    $("#admin-product-edit-price").val(result.data.m_price);
                    $("#admin-product-edit-original-price").val(result.data.m_original_price);
                    $("#admin-product-edit-quanti").val(result.data.m_quanti);
                    $("#admin-product-edit-buy").val(result.data.m_buy);
                    $("#admin-product-edit-avata-preview").attr('src', "../" + result.data.avata.thumbs.medium);
                    CKEDITOR.instances.admin_product_edit_description.setData((result.data.m_description != null) ? result.data.m_description : '');

                    $("#admin-product-edit-submit-btn").attr("data-id", result.data.id);
                    $("#admin-product-edit-avata-btn-delete").attr("data-id", result.data.id);
                },
                error: function () {
                    alert("Có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };

        this.onUpdateChangeAvata = function (e) {
            // Reset file data / image preview
            $("#admin-product-edit-avata-status").text("");
            $("#admin-product-edit-avata-preview").attr('src', "asset/img/default/product.jpg");
            self.imageData = '';

            var file = e.target.files[0];
            $("#admin-product-edit-avata-info-name").text(file.name);
            $("#admin-product-edit-avata-info-type").text(file.type);
            $("#admin-product-edit-avata-info-size").text(file.size + " bytes");

            // Validate file type
            if (['image/png', 'image/jpeg'].indexOf(file.type) == -1) {
                $("#admin-product-edit-avata-status").text("File không hợp lệ (chỉ file hình jpg và hình png được chấp nhận)");
                return;
            }

            // Validate file size
            if (file.size > 30 * 1024 * 1024) {
                $("#admin-product-edit-avata-status").text("Dung lượng file vượt quá giới hạn (tối đa 30MB được chấp nhận)");
                return;
            }

            var reader = new FileReader();
            reader.onload = function (e) {
                self.imageData = e.target.result;

                // Validate file content
                $("#admin-product-edit-avata-preview").on('error', function () {
                    self.imageData = "";
                    $("#admin-product-edit-avata-preview").attr('src', "../assets/img/default/product.jpg");
                    $("#admin-product-edit-avata-status").text('Nội dung hình không hợp lệ');
                });
                $("#admin-product-edit-avata-preview").attr('src', self.imageData);
            };
            reader.readAsDataURL(file);
        };
        this.update = function (idProduct) {
            $("#admin-product-edit-status").removeClass('error').html("").show();
            var productTitle = $("#admin-product-edit-name").val();
            if (productTitle.length == 0) {
                $("#admin-product-edit-status").addClass('error').text("Vui lòng nhập vào tên sản phẩm");
                return;
            }
            var productIdCategory = $("#admin-product-edit-category").val();
            var productStatus = $("#admin-product-edit-currentStatus").val();
            var productPrice = $("#admin-product-edit-price").val();
            var productOriginalPrice = $("#admin-product-edit-original-price").val();
            var productQuanti = $("#admin-product-edit-quanti").val();
            var productBuy = $("#admin-product-edit-buy").val();
            var productShortDescription = $("#admin-product-edit-short-description").val();
            var productDescription = CKEDITOR.instances.admin_product_edit_description.getData();
            $.ajax({
                url: "admin/ajaxproduct_update",
                type: "post",
                data: {
                    idProduct: idProduct,
                    productTitle: productTitle,
                    productIdCategory: productIdCategory,
                    productStatus: productStatus,
                    productPrice: productPrice,
                    productOriginalPrice: productOriginalPrice,
                    productQuanti: productQuanti,
                    productBuy: productBuy,
                    productShortDescription: productShortDescription,
                    productDescription: productDescription,
                    imageData: self.imageData
                },
                beforeSend: function () {
                    $("#admin-product-edit-status").text("Đang xử lý, vui lòng chờ...");
                },
                success: function (result) {
                    self.imageData = '';
                    console.log("++++ Admin product > update: ");
                    console.log(result);

                    result = JSON.parse(result);
                    $("#admin-product-edit-status").html(result.msg);
                    setTimeout(function () {
                        $("#admin-product-edit-status").hide();
                    }, 5000);
                    self.loadlist();
                },
                error: function () {
                    $("#admin-product-edit-status").addClass('error').text("Có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };
        this.loadlist();
        CKEDITOR.replace('admin_product_edit_description', {});
        /*
         * Event
         */
        $("#admin-product-add-btn").click(function () {
            self.add();
        });
        $("#admin-product-edit-submit-btn").click(function () {
            var idProduct = $(this).attr('data-id');
            self.update(idProduct);
        });
        $("#admin-product-edit-close-btn").click(function () {
            $("#admin-product-edit").hide();
        });
        $("#admin-product-edit-avata-btn-change").click(function () {
            $("#admin-product-edit-avata-input").trigger('click');
        });
        $("#admin-product-edit-avata-input").change(function (e) {
            self.onUpdateChangeAvata(e);
        });
        $("#admin-product-edit-avata-btn-delete").click(function(){
            var idProduct = $(this).data("id");
            self.deleteAvata(idProduct);
        });
    };
    $(window).ready(function () {
        new admin_product();
    });
})($);
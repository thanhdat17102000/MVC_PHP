(function ($) {
    var admin_category = function () {
        var self = this;

        this.add = function () {
            $("#admin-category-add-status").removeClass('error').html("").show();
            var categoryTitle = $("#admin-category-add-name").val();
            if (categoryTitle.length == 0) {
                $("#admin-category-add-status").addClass('error').text("Vui lòng nhập vào tên danh mục sản phẩm");
                return;
            }
            var categoryIdParent = $("#admin-category-add-parent").val();
            $.ajax({
                url: "admin/ajaxcategory_add",
                type: "post",
                data: {
                    categoryTitle: categoryTitle,
                    categoryIdParent: categoryIdParent
                },
                beforeSend: function () {
                    $("#admin-category-add-status").text("Đang xử lý, vui lòng chờ...");
                },
                success: function (result) {
                    console.log("++++ Admin category > add: ");
                    console.log(result);

                    result = JSON.parse(result);
                    $("#admin-category-add-status").html(result.msg);
                    setTimeout(function () {
                        $("#admin-category-add-status").hide();
                    }, 5000);
                    $("#admin-category-add-name").val("");
                    self.loadlist();
                },
                error: function () {
                    $("#admin-category-add-status").addClass('error').text("Có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };
        this.loadlist = function () {
            $("#admin-category-list-content").html("");
            $.ajax({
                url: "admin/ajaxcategory_loadlist",
                type: "get",
                beforeSend: function () {
                    $("#admin-category-list-content").text("Đang xử lý, vui lòng chờ...");
                },
                success: function (result) {
                    console.log("++++ Admin category > load list: ");
                    console.log(result);
                    result = JSON.parse(result);
                    self.onLoadedList(result);
                },
                error: function () {
                    $("#admin-category-list-content").addClass('error').text("Có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };
        this.onLoadedList = function (result) {
            var editIdParent = $("#admin-category-edit-parent").val();
            $("#admin-category-add-parent").html('<option value="0">----</option>');
            $("#admin-category-edit-parent").html('<option value="0">----</option>');
            if (result.data.length == 0) {
                $("#admin-category-list-content").text("Chưa có danh mục nào");
            } else {
                var renderItems = function (items) {
                    var html = "";
                    items.forEach(function (item) {
                        var itemActions = "<span class='float-right'><i class='fa fa-pencil item-edit-btn' title='Sửa danh mục'></i>&nbsp;&nbsp;<i class='fa fa-trash-o item-delete-btn' title='Xóa danh mục'></i></span>";
                        itemActions += "<div class='clear_both'></div>";
                        html += "<div class='item' data-id='" + item.id +"'>" + item.m_title + itemActions + "</div>";
                        
                        if (item.subCategory.length > 0) {
                            html += "<div class='subItems'>" + renderItems(item.subCategory) + "</div>";
                        }
                        
                        $("#admin-category-add-parent").append('<option value="'+item.id+'">'+item.m_title+'</option>');
                        $("#admin-category-edit-parent").append('<option value="'+item.id+'">'+item.m_title+'</option>');
                    });
                    return html;
                };
                $("#admin-category-list-content").html(renderItems(result.data));
                $("#admin-category-edit-parent").val(editIdParent);
                /*
                 * Event for list
                 */
                $("#admin-category-list-content .item-delete-btn").click(function(){
                    var idCategory = $(this).parents(".item").data('id');
                    self.delete(idCategory);
                });
                $("#admin-category-list-content .item-edit-btn").click(function(){
                    var idCategory = $(this).parents(".item").data('id');
                    self.loadFormEdit(idCategory);
                });
            }
        };
        this.delete = function(idCategory){
            $.ajax({
                url: "admin/ajaxcategory_delete",
                type: "post",
                data: {
                    idCategory: idCategory
                },
                success: function (result) {
                    console.log("++++ Admin category > delete: ");
                    console.log(result);
                    self.loadlist();
                },
                error: function () {
                    alert("Có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };
        this.loadFormEdit = function(idCategory){
            $("#admin-category-edit").show();
            $("#admin-category-edit-status").text("Đang tải dữ liệu, xin chờ");
            $.ajax({
                url: "admin/ajaxcategory_loadDetail",
                type: "post",
                data: {
                    idCategory: idCategory
                },
                success: function (result) {
                    console.log("++++ Admin category > loadDetail: ");
                    console.log(result);
                    result = JSON.parse(result);
                    $("#admin-category-edit-status").html("");
                    $("#admin-category-edit-name").val(result.data.m_title);
                    $("#admin-category-edit-parent").val(result.data.m_id_parent);
                    $("#admin-category-edit-index").val(result.data.m_index);
                    $("#admin-category-edit-submit-btn").attr("data-id", result.data.id);
                    
                },
                error: function () {
                    alert("Có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };
        this.update = function(idCategory){
            $("#admin-category-edit-status").removeClass('error').html("").show();
            var categoryTitle = $("#admin-category-edit-name").val();
            if (categoryTitle.length == 0) {
                $("#admin-category-edit-status").addClass('error').text("Vui lòng nhập vào tên danh mục sản phẩm");
                return;
            }
            var categoryIdParent = $("#admin-category-edit-parent").val();
            var categoryIndex = $("#admin-category-edit-index").val();
            $.ajax({
                url: "admin/ajaxcategory_update",
                type: "post",
                data: {
                    categoryTitle: categoryTitle,
                    idCategory: idCategory,
                    categoryIdParent: categoryIdParent,
                    categoryIndex: categoryIndex
                },
                beforeSend: function () {
                    $("#admin-category-edit-status").text("Đang xử lý, vui lòng chờ...");
                },
                success: function (result) {
                    console.log("++++ Admin category > update: ");
                    console.log(result);

                    result = JSON.parse(result);
                    $("#admin-category-edit-status").html(result.msg);
                    setTimeout(function () {
                        $("#admin-category-edit-status").hide();
                    }, 5000);
                    self.loadlist();
                },
                error: function () {
                    $("#admin-category-edit-status").addClass('error').text("Có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };
        this.loadlist();
        /*
         * Event
         */
        $("#admin-category-add-btn").click(function () {
            self.add();
        });
        $("#admin-category-edit-submit-btn").click(function () {
            var idCategory = $(this).attr('data-id');
            self.update(idCategory);
        });
        $("#admin-category-edit-close-btn").click(function () {
            $("#admin-category-edit").hide();
        });
    };
    $(window).ready(function () {
        new admin_category();
    });
})($);
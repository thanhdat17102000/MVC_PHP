(function ($) {
    var cart = function () {
        var self = this;
        this.selectors = {
            checkAllBtn: $('#shop_cart_btncheckall'),
            item: $('.shop_cart_item'),
            checkItem: $('.shop_cart_item_check'),
            quantiInput: $('.shop_cart_item [name="count_input"]'),
            totalMoney: $(".totalMoney"),
            bulkActionBtn: $('.shop_cart_actionbtn'),
            bulkActionList: $(".shop_cart_actionlist"),
            buyProcessBtn: $(".paybtn_cash"),
            buyProcessDialog: $(".cart-buyProcessDialog")
        };
        this.updateQuanti = function(productId, quanti){
            $.ajax({
                url: "cart/ajax_updateQuanti",
                type: "post",
                data: {
                    productId: productId,
                    quanti: quanti
                },
                beforeSend: function () {
                    //
                },
                success: function (result) {
                    console.log("++++ cart > update quanti: ");
                    console.log(result);

                    result = JSON.parse(result);
                    if (result.status == 'NG'){
                        alert(result.msg);
                        return;
                    }
                    self.selectors.item.trigger('changePricing');
                },
                error: function () {
                    alert("Đã có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
            
        };
        
        this.bulkDel = function(){
            var checkedItems = this.selectors.checkItem.filter(':checked');
            if (checkedItems.length < 1){
                alert("Hãy chọn sản phẩm để xóa khỏi giỏ hàng của bạn");
                return false;
            }
            var productIds = [];
            checkedItems.each(function(index, item){
                productIds.push($(item).data('id'));
            });
            
            $.ajax({
                url: "cart/ajax_bulkDelete",
                type: "post",
                data: {
                    productIds: productIds
                },
                beforeSend: function () {
                    //
                },
                success: function (result) {
                    console.log("++++ cart > bulk delete: ");
                    console.log(result);

                    result = JSON.parse(result);
                    if (result.status == 'NG'){
                        alert(result.msg);
                        return;
                    }
                    window.location.reload();
                },
                error: function () {
                    alert("Đã có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };
        this.buyProcessDone = function(){
            var checkedItems = this.selectors.checkItem.filter(':checked');
            if (checkedItems.length < 1){
                alert("Hãy chọn sản phẩm để tiến hành mua hàng");
                return false;
            }
            var productIds = [];
            checkedItems.each(function(index, item){
                productIds.push($(item).data('id'));
            });
            
            $.ajax({
                url: "cart/ajax_buyProcessDone",
                type: "post",
                data: {
                    productIds: productIds,
                    name: $("#buyProcessName").val(),
                    phone: $("#buyProcessPhone").val(),
                    address: $("#buyProcessAddress").val(),
                    note: $("#buyProcessNote").val()
                },
                beforeSend: function () {
                    self.selectors.buyProcessDialog.find('.dialog-content').text('Đang tiến hành, xin chờ...');
                },
                success: function (result) {
                    console.log("++++ cart > buy process: ");
                    console.log(result);

                    result = JSON.parse(result);
                    if (result.status == 'NG'){
                        alert(result.msg);
                        return;
                    }
                    self.selectors.buyProcessDialog.find('.dialog-content').html('Đơn hàng của bạn đã được tiếp nhận, chúng tôi sẽ liên hệ bạn trong thời gian sớm nhất.');
                    setTimeout(function(){
                        window.location.reload();
                    }, 3000);
                },
                error: function () {
                    alert("Đã có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };
        
        // Event
        this.selectors.checkAllBtn.click(function () {
            var checkAllState = $(this).prop('checked');
            self.selectors.checkItem.prop('checked', checkAllState);
        });
        this.selectors.checkItem.click(function () {
            var uncheckedItem = self.selectors.checkItem.filter(':not(:checked)');
            if (uncheckedItem.length == 0){
                self.selectors.checkAllBtn.prop('checked', true);
            } else {
                self.selectors.checkAllBtn.prop('checked', false);
            }
        });
        this.selectors.quantiInput.change(function(){
            var productId = $(this).data('id');
            var quanti = $(this).val();
            self.updateQuanti(productId, quanti);
        });
        this.selectors.item.on('changePricing', function(){
            // Update price for current item
            var currentQuanti = $(this).find('[name="count_input"]').val();
            var currentPrice = $(this).find('.cart_item_price').text().replace(/[^\d]/g, '')*1;
            var totalPrice = currentQuanti * currentPrice;
            $(this).find('.cart_item_price_total').text(totalPrice.toLocaleString('it-IT', {style : 'currency', currency : 'VND'}).replace('VND', ''));
            
            // Update total price for all item
            var totalMoney = 0;
            $('.cart_item_price_total').each(function(index, item){
                totalMoney += $(item).text().replace(/[^\d]/g, '')*1;
                console.log($(item).text().replace(/[^\d]/g, '')*1);
            });
            self.selectors.totalMoney.text(totalMoney.toLocaleString('it-IT', {style : 'currency', currency : 'VND'}).replace('VND', ''));
        });
        this.selectors.bulkActionBtn.click(function(){
            var action = self.selectors.bulkActionList.val();
            if (action == 'del'){
                self.bulkDel();
            }
        });
        this.selectors.buyProcessBtn.click(function(){
            self.selectors.buyProcessDialog.addClass('show');
        });
        self.selectors.buyProcessDialog.find('.dialog-close-btn').click(function(){
            self.selectors.buyProcessDialog.removeClass('show');
        });
        self.selectors.buyProcessDialog.find('.dialog-ok-btn').click(function(){
            self.buyProcessDone();
        });
    };
    $(window).ready(function () {
        new cart();
    });
})($);
(function ($) {
    var product = function () {
        var self = this;
        this.productId = $("h1").data('product-id');
        this.liked = false;
        this.quantiMax = $("#productDetail-quantiMax").text() * 1;
        this.selectors = {
            likeBtn: $("#productDetail-like-btn"),
            likeTotal: $("#productDetail-like-total"),
            addToCartBtn: $("#productDetail-addToCart-btn"),
            addToCartQuantiInput: $(".product_profile_count_select"),
            addToCartDialog: $(".productDetail-addToCartDialog"),
        };
        this.addToCart = function () {
            var currentQuanti = this.selectors.addToCartQuantiInput.val() * 1;
            if (currentQuanti <= 0) {
                alert("Số lượng mua tối thiểu là: 1");
                return;
            }
            if (currentQuanti > this.quantiMax) {
                alert("Số lượng mua tối đa là: " + this.quantiMax);
                return;
            }
            $.ajax({
                url: "product/ajax_addToCart",
                type: "post",
                data: {
                    productId: this.productId,
                    quanti: currentQuanti
                },
                beforeSend: function () {
                    self.selectors.addToCartDialog.addClass('show').find('.dialog-content').html('Đang tiến hành, xin chờ...');
                },
                success: function (result) {
                    console.log("++++ Product > add to cart: ");
                    console.log(result);

                    result = JSON.parse(result);
                    if (result.status == 'NG'){
                        alert(result.msg);
                        return;
                    }
                    
                    self.selectors.addToCartDialog.find('.dialog-content').html(result.msg);
                    self.selectors.addToCartDialog.find('.dialog-content').append('<br/><a href="">Tiếp tục mua sắm</a>');
                    self.selectors.addToCartDialog.find('.dialog-content').append('<br/><a href="/cart">Xem giỏ hàng</a>');
                },
                error: function () {
                    alert("Đã có lỗi xảy ra, vui lòng thử lại sau");
                }
            });
        };
        this.like = function () {
            if (this.liked == false) {
                this.liked = true;
                $.ajax({
                    url: "product/ajax_like",
                    type: "post",
                    data: {
                        productId: this.productId
                    },
                    beforeSend: function () {
                        self.selectors.likeTotal.text("...");
                    },
                    success: function (result) {
                        console.log("++++ Product detail > like: ");
                        console.log(result);

                        result = JSON.parse(result);
                        self.selectors.likeTotal.text(result.data.totalLike);

                        self.selectors.likeBtn.css({
                            'cursor': 'not-allowed'
                        });
                    },
                    error: function () {
                        alert("Đã có lỗi xảy ra, vui lòng thử lại sau");
                        self.liked = false;
                    }
                });
            } else {
                this.selectors.likeBtn.css({
                    'border-color': 'red'
                });
                setTimeout(function () {
                    self.selectors.likeBtn.css({
                        'border-color': 'transparent'
                    });
                }, 500);
            }
        };
        // Event
        this.selectors.likeBtn.click(function () {
            self.like();
        });
        this.selectors.addToCartBtn.click(function () {
            self.addToCart();
        });
    };
    $(window).ready(function () {
        new product();
        $(".dialog-close-btn").click(function () {
            $(this).parents('.dialog').removeClass('show');
        });
    });
})($);
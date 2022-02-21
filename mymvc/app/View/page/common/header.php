<html>
    <head>
        <title>Trang mua sắm trực tuyến</title>
        <meta charset = "UTF-8">
        <base href = "<?= \App\Config\Routes::getBaseUrl() ?>">
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        <link href = "asset/css/lib.css" rel = "stylesheet" type = "text/css"/>
        <link href = "asset/css/owl.carousel.min.css" rel = "stylesheet" type = "text/css"/>
        <link href = "asset/css/common.css" rel = "stylesheet" type = "text/css"/>
        <link href = "asset/css/<?=$action?>.css" rel = "stylesheet" type = "text/css"/>
    </head>
    <body>
        <header>
            <div class = "container">
                <div class = "header-logo">
                    <a href = "#">
                    <h2><span>Điện thoại </span>giá rẻ</h2>
                    </a>
                </div>
                <form action = "" method = "get" class = "header-search">
                    <input type = "text" name = "w" value = "" placeholder = "Tìm kiếm trên website...">
                    <button class = "button" type = "submit">
                        <i class = "fa fa-search search_icon"></i>
                    </button>
                </form>
                <div class = "header-member">
                    <?php if ($userInfo !== null) { ?>
                    <span style='color: white'>Xin chào <b> <?= $userInfo['username'] ?> </b> </span>
                        &nbsp;&nbsp;&nbsp;
                        <a title = "Đăng xuất" class = "display_inline_block " href = "user/logout">
                            <i class = "fa fa-user icon"></i>
                            <span class = "detailtext">Đăng xuất</span>

                        </a>
                    <?php } else {
                        ?>
                        <a title = "Đăng nhập vào website" class = "display_inline_block margin_r" href = "user/login">
                            <i class = "fa fa-user icon"></i>
                            <span class = "detailtext">Đăng nhập</span>

                        </a>
                        <a title = "Đăng ký tài khoản mới" class = "display_inline_block" href = "user/register">
                            <i class = "fa fa-user-plus  icon"></i>
                            <span class = "detailtext">Đăng ký</span>
                        </a>
                    <?php } ?>


                </div>
                <div class = "clear_both"></div>
            </div>
        </header>
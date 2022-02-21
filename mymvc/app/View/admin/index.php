<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Trang quản trị</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <base href="<?= \App\Config\Routes::getBaseUrl() ?>">
        <link href="asset/admin/css/fontawesome.css" rel="stylesheet" type="text/css"/>
        <link href="asset/admin/css/common.css" rel="stylesheet" type="text/css"/>
        <?= $action != null ? '<link href="asset/admin/css/' . $action . '.css" rel="stylesheet" type="text/css"/>' : "" ?>
    </head>
    <body>
        <header>
            <div class="admin-container">
                TRANG QUẢN LÝ
            </div>
        </header>
        <main>
            <div class="admin-container">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <nav id="admin-nav">
                            <ul>
                                <li class="<?= $action === 'category' ? "active" : "" ?>"><a href="<?=\App\Config\Routes::getBaseUrl()?>admin/category">Quản lý danh mục sản phẩm</a></li>
                                <li class="<?= $action === 'product' ? "active" : "" ?>"><a href="<?=\App\Config\Routes::getBaseUrl()?>admin/product">Quản lý sản phẩm</a></li>
                                <li class="<?= $action === 'order' ? "active" : "" ?>"><a href="<?=\App\Config\Routes::getBaseUrl()?>admin/order">Quản lý đơn hàng</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-12 col-md-9">
                        <div id="admin-main">
                            <?php
                            if ($action != null) {
                                include_once __DIR__ . '/' . $action . ".php";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div class="admin-container">
                Footer
            </div>
        </footer>

        <script src="asset/admin/js/jquery.js"></script>
        <script src="asset/admin/js/ckeditor/ckeditor.js"></script>
        <script src="asset/admin/js/common.js"></script>
        <?= $action != null ? '<script src="asset/admin/js/' . $action . '.js"></script>' : "" ?>
    </body>
</html>

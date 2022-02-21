<?php include_once "./app/View/page/common/header.php" ?>
<main>
    <div class="container">
        <div class="login-form">
            <form action="" method="post">
                <h1>Đăng nhập vào website</h1>
                <?= $loggedStatus === false ? "<p class='error main'>Tên hoặc mật khẩu không đúng, vui lòng thực hiện lại.</p>" : "" ?>

                <div class="input-box">
                    <input type="text" placeholder="Nhập username" name="username" value="<?= $username ?>">
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Nhập mật khẩu" name="password">
                </div>
                <div class="btn-box">
                    <button type="submit" name="submit" value="yes">
                        Đăng nhập
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
<?php include_once "app/View/page/common/footer.php" ?>
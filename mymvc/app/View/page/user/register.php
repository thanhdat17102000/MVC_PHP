<?php include_once "./app/View/page/common/header.php" ?>
<main>
    <div class="container">
        <div class="register-form">
            <form action="" method="post">
                <h1>Đăng ký tài khoản mới</h1>
                <?= $canRegister === false ? "<p class='error main'>Đăng ký không thành công, vui lòng xem lại các thông tin đã nhập và thực hiện lại.</p>" : "" ?>
                <div class="input-box">
                    <?= !empty($validateError['username']) ? "<p class='error'>" . implode("<br/>", $validateError['username']) . "</p>" : "" ?>
                    <input type="text" placeholder="Nhập username" name="username" value="<?= $username ?>">
                </div>
                <div class="input-box">
                    <?= !empty($validateError['password']) ? "<p class='error'>" . implode("<br/>", $validateError['password']) . "</p>" : "" ?>
                    <input type="password" placeholder="Nhập mật khẩu" name="password" value="<?= $password ?>">
                </div>
                <div class="input-box">
                    <?= !empty($validateError['gender']) ? "<p class='error'>" . implode("<br/>", $validateError['gender']) . "</p>" : "" ?>
                    <label for="gioitinh">Giới tính</label>
                    <br>
                    <select id="gioitinh" name="gender">
                        <option value="1" <?= $gender == '1' ? 'selected="selected"' : "" ?>>Nam</option>
                        <option value="0" <?= $gender == '0' ? 'selected="selected"' : "" ?>>Nữ</option>
                    </select>
                </div>
                <div class="input-box">
                    <?= !empty($validateError['phone']) ? "<p class='error'>" . implode("<br/>", $validateError['phone']) . "</p>" : "" ?>
                    <input type="text" placeholder="Số điện thoại" name="phone" value="<?= $phone ?>">
                </div>
                <div class="input-box">
                    <?= !empty($validateError['email']) ? "<p class='error'>" . implode("<br/>", $validateError['email']) . "</p>" : "" ?>
                    <input type="email" placeholder="Email" name="email" value="<?= $email ?>">
                </div>

                <div class="btn-box">
                    <button type="submit" name="submit" value="yes">
                        Đăng ký
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
<?php include_once "app/View/page/common/footer.php" ?>
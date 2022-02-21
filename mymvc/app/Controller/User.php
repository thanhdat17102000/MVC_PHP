<?php

namespace App\Controller;

class User extends \Core\Controller {

    function register() {
        session_start();
        $userInfo = isset($_SESSION['userInfo']) ? $_SESSION['userInfo'] : null;
        $userModel = new \App\Model\User();

        $submit = isset($_POST['submit']) ? $_POST['submit'] : null;
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
        $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
        $email = isset($_POST['email']) ? $_POST['email'] : null;

        $canRegister = null;
        $validateError = [
            'username' => [],
            'password' => [],
            'gender' => [],
            'phone' => [],
            'email' => []
        ];

        if ($submit === 'yes') {
            // Validate for username
            if (strlen($username) < 8) {
                array_push($validateError['username'], "Tên đăng nhập tối thiểu là 8 ký tự");
            }
            if (strlen($username) > 255) {
                array_push($validateError['username'], "Tên đăng nhập tối đa là 255 ký tự");
            }
            if (strlen($username) >= 8 && strlen($username) <= 255) {
                $existedUser = $userModel
                        ->db
                        ->where([
                            'm_username' => $username
                        ])
                        ->get()
                        ->result();
                if ($existedUser !== false) {
                    array_push($validateError['username'], "Tên đăng nhập đã được sử dụng trước đó, vui lòng chọn tên đăng nhập khác");
                }
            }


            // Validate for password
            if (strlen($password) < 8) {
                array_push($validateError['password'], "Mật khẩu tối thiểu là 8 ký tự");
            }

            $match = false;
            preg_match("/[A-Z]/", $password, $match);
            if (!$match) {
                array_push($validateError['password'], "Mật khẩu phải gồm ít nhất một ký tự in hoa");
            }

            $match = false;
            preg_match("/\d/", $password, $match);
            if (!$match) {
                array_push($validateError['password'], "Mật khẩu phải gồm ít nhất một ký tự số");
            }

            $match = false;
            preg_match("/[^A-z0-9]/", $password, $match);
            if (!$match) {
                array_push($validateError['password'], "Mật khẩu phải gồm ít nhất một ký tự đặc biệt");
            }

            // Validate for gender
            if (!in_array($gender, ['0', '1'], true)) {
                array_push($validateError['gender'], "Giới tính phải là 0 (nữ) hoặc 1 (nam)");
            }

            // Validate for phone
            if (strlen($phone) < 9) {
                array_push($validateError['phone'], "Điện thoại tối thiểu là 9 ký tự");
            }
            if (strlen($phone) > 50) {
                array_push($validateError['phone'], "Điện thoại tối đa là 50 ký tự");
            }

            // Validate for email
            $match = false;
            preg_match("/^([0-9A-Za-z\!\%\_\^\&\*\+\=\`\'\.])+\@([0-9A-Za-z\.])+$/", $email, $match);
            if (!$match) {
                array_push($validateError['email'], "Địa chỉ email không hợp lệ");
            }

            // If you want to display the error variable, uncomment the line bellow
            //print_r($validateError);

            $canRegister = empty($validateError['username']) && empty($validateError['password']) && empty($validateError['gender']) && empty($validateError['phone']) && empty($validateError['email']);

            if ($canRegister) {
                // Register the new user
                $userModel->db->reset()->insert([
                    'm_username' => $username,
                    'm_password' => md5($password),
                    'm_gender' => $gender,
                    'm_phone' => $phone,
                    'm_email' => $email
                ]);
                if ($userModel->db->getErrorText() === null) {
                    // Đăng ký thành công
                    $_SESSION['userInfo'] = [
                        'username' => $username,
                        'gender' => $gender,
                        'phone' => $phone,
                        'email' => $email
                    ];
                    header('location: ' . \App\Config\Routes::getBaseUrl());
                }
            }
        }
        $this->view('page/user/register', [
            'canRegister' => $canRegister,
            'validateError' => $validateError,
            'submit' => $submit,
            'username' => $username,
            'password' => $password,
            'phone' => $phone,
            'email' => $email,
            'gender' => $gender,
            'action' => 'register',
            'userInfo' => $userInfo
        ]);
    }

    function login() {
        session_start();
        $userInfo = isset($_SESSION['userInfo']) ? $_SESSION['userInfo'] : null;
        $userModel = new \App\Model\User();

        $submit = isset($_POST['submit']) ? $_POST['submit'] : null;
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;

        $loggedStatus = null;
        if ($submit === 'yes') {
            $existedUser = $userModel->db
                    ->where([
                        'm_username' => $username,
                        'm_password' => md5($password)
                    ])
                    ->get()
                    ->result();
            if ($existedUser !== false) {
                $existedUser = $existedUser[0];
                $loggedStatus = true;
                $_SESSION['userInfo'] = [
                    'username' => $existedUser['m_username'],
                    'gender' => $existedUser['m_gender'],
                    'phone' => $existedUser['m_phone'],
                    'email' => $existedUser['m_email']
                ];
                header('location: ' . \App\Config\Routes::getBaseUrl());
            } else {
                $loggedStatus = false;
            }
        }
        $this->view('page/user/login', [
            'submit' => $submit,
            'username' => $username,
            'password' => $password,
            'loggedStatus' => $loggedStatus,
            'action' => 'login',
            'userInfo' => $userInfo
        ]);
    }

    function logout() {
        session_start();
        unset($_SESSION['userInfo']);
        header('location: ' . \App\Config\Routes::getBaseUrl());
    }

}

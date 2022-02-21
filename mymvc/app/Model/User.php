<?php
namespace App\Model;
class User extends \Core\Model {
    /*
     * Tên bảng trong hệ thống database là 'user'
     */

    const TABLE_NAME = 'user';
    /*
     * Các tên field trong bảng category
     */
    const FIELD_ID = 'id';
    const FIELD_USERNAME = 'm_username';
    const FIELD_PHONE = 'm_phone';
    const FIELD_PASSWORD = 'm_password';
    const FIELD_GENDER = 'm_gender';
    const FIELD_EMAIL = 'm_email';
    
    const VALUE_GENDER_MALE = 0;
    const VALUE_GENDER_FEMALE = 1;

    /**
     * Class kết nối dùng cho bảng 'user' (bảng lưu thông tin các thành viên)
     * 
     * @param object $connection PDO connect object, nếu $connection=null thì một kết nối mới sẽ được tạo
     * @return object Đối tượng thao tác với bảng 'user'
     */
    public function __construct($connection = null) {
        parent::__construct($connection);
        $this->db->table(self::TABLE_NAME);
        return $this;
    }

    public static function getGenderLabel() {
        return [
            self::VALUE_GENDER_MALE => 'Nam',
            self::VALUE_GENDER_FEMALE => 'Nữ',
        ];
    }
    
}





<?php
namespace App\Model;
class Order extends \Core\Model {
    /*
     * Tên bảng trong hệ thống database là 'category'
     */

    const TABLE_NAME = 'torder';
    /*
     * Các tên field trong bảng category
     */
    const FIELD_ID = 'id';
    const FIELD_NAME = 'm_name';
    const FIELD_PHONE = 'm_phone';
    const FIELD_ADDRESS = 'm_address';
    const FIELD_NOTE = 'm_note';
    const FIELD_TOTAL_PRICE = 'm_total_price';
    const FIELD_CREATE = 'm_create';
    const FIELD_UPDATE = 'm_update';
    const FIELD_STATUS_SHIP = 'm_status_ship';
    const FIELD_STATUS_PURCHAR = 'm_status_purchar';
    const FIELD_STATUS = 'm_status';
    const VALUE_STATUS_READY = '1';
    const VALUE_STATUS_ACCEPT = '2';
    const VALUE_STATUS_FINISH = '3';
    const VALUE_STATUS_CANCEL_REQUEST = '41';
    const VALUE_STATUS_CANCEL_DENY = '42';
    const VALUE_STATUS_CANCEL_COMPLETE = '43';
    const VALUE_STATUS_PURCHAR_NOTYET = '1';
    const VALUE_STATUS_PURCHAR_DONE = '2';
    const VALUE_STATUS_SHIP_NOTYET = '1';
    const VALUE_STATUS_SHIP_INPROGRESS = '2';
    const VALUE_STATUS_SHIP_DONE = '3';

    /**
     * Class kết nối dùng cho bảng 'category' (bảng lưu thông tin các danh mục sản phẩm)
     * 
     * @param object $connection PDO connect object, nếu $connection=null thì một kết nối mới sẽ được tạo
     * @return object Đối tượng thao tác với bảng 'category'
     */
    public function __construct($connection = null) {
        parent::__construct($connection);
        $this->db->table(self::TABLE_NAME);
        return $this;
    }

    public static function getStatusLabel() {
        return [
            self::VALUE_STATUS_READY => 'Khởi tạo',
            self::VALUE_STATUS_ACCEPT => 'Chấp nhận',
            self::VALUE_STATUS_FINISH => 'Hoàn tất',
            self::VALUE_STATUS_CANCEL_REQUEST => 'Yêu cầu hủy',
            self::VALUE_STATUS_CANCEL_DENY => 'Từ chối hủy',
            self::VALUE_STATUS_CANCEL_COMPLETE => 'Đã hủy',
        ];
    }
    
    public static function getStatusPurcharLabel(){
        return [
            self::VALUE_STATUS_PURCHAR_NOTYET => 'Chưa thanh toán',
            self::VALUE_STATUS_PURCHAR_DONE => 'Đã thanh toán'
        ];
    }
    
    public static function getStatusShipLabel(){
        return [
            self::VALUE_STATUS_SHIP_NOTYET => 'Chưa giao hàng',
            self::VALUE_STATUS_SHIP_INPROGRESS => 'Đang giao hàng',
            self::VALUE_STATUS_SHIP_DONE => 'Đã giao hàng'
        ];
    }

}



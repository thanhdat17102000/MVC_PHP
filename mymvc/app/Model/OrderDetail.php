<?php
namespace App\Model;
class OrderDetail extends \Core\Model {
    
    /*
     * Tên bảng trong hệ thống database là 'category'
     */
    const TABLE_NAME = 'torder_detail';
    /*
     * Các tên field trong bảng category
     */
    const FIELD_ID = 'id';
    const FIELD_ID_ORDER = 'm_id_order';
    const FIELD_ID_PRODUCT = 'm_id_product';
    const FIELD_PRICE = 'm_price';
    const FIELD_QUANTI = 'm_quanti';
    const FIELD_PRODUCT_NAME = 'm_product_name';

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

}

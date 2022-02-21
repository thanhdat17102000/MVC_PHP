<?php

namespace App\Model;

class Category extends \Core\Model {
    /*
     * id của danh mục gốc là 0 => danh mục có m_id_parent = 0 là danh mục gốc
     */

    const ID_ROOT = 0;
    /*
     * Vị trí các danh mục con trong một danh mục cha được đánh chỉ số từ 1
     */
    const INDEX_START = 1;
    /*
     * Tên bảng trong hệ thống database là 'category'
     */
    const TABLE_NAME = 'category';
    /*
     * Các tên field trong bảng category
     */
    const FIELD_ID = 'id';
    const FIELD_ID_PARENT = 'm_id_parent';
    const FIELD_TITLE = 'm_title';
    const FIELD_INDEX = 'm_index';

    /**
     * Class kết nối dùng cho bảng 'category' (bảng lưu thông tin các danh mục sản phẩm)
     * 
     * @param object $connection PDO connect object, nếu $connection=null thì một kết nối mới sẽ được tạo
     * @return object Đối tượng thao tác với bảng 'category'
     */
    public function __construct() {
        parent::__construct();
        $this->db->table(self::TABLE_NAME);
        return $this;
    }

    public function getAllCategory($idParent = 0) {
        $list = [];
        $currentList = $this
                ->db
                ->reset()
                ->where([
                    self::FIELD_ID_PARENT => $idParent
                ])
                ->order([
                    self::FIELD_INDEX => 'ASC',
                    self::FIELD_ID => 'ASC'
                ])
                ->get()
                ->result();
        if ($currentList != false) {
            foreach ($currentList as $currentItem) {
                $currentItem['subCategory'] = $this->getAllCategory($currentItem[self::FIELD_ID]);
                array_push($list, $currentItem);
            }
        }
        return $list;
    }

    public function getBreakcums($currentId) {
        $breakcums = [];
        while ($currentId != self::ID_ROOT) {
            $currentCategory = $this
                    ->db
                    ->reset()
                    ->where([
                        self::FIELD_ID => $currentId
                    ])
                    ->get()
                    ->result();
            if ($currentCategory == false) {
                $currentId = self::ID_ROOT;
            } else {
                array_push($breakcums, $currentCategory[0]);
                $currentId = $currentCategory[0][self::FIELD_ID_PARENT];
            }
        }
        return array_reverse($breakcums);
    }

}

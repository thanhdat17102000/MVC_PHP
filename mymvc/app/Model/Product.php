<?php
namespace App\Model;

class Product extends \Core\Model {
    /*
     * Tên bảng trong hệ thống database là 'product'
     */

    const TABLE_NAME = 'product';
    /*
     * Các tên field trong bảng product
     */
    const FIELD_ID = 'id';
    const FIELD_ID_CATEGORY = 'm_id_category';
    const FIELD_TITLE = 'm_title';
    const FIELD_SHORT_DESCRIPTION = 'm_short_description';
    const FIELD_DESCRIPTION = 'm_description';
    const FIELD_PRICE = 'm_price';
    const FIELD_ORIGINAL_PRICE = 'm_original_price';
    const FIELD_TIME_CREATE = 'm_time_create';
    const FIELD_TIME_UPDATE = 'm_time_update';
    const FIELD_VIEW = 'm_view';
    const FIELD_LIKE = 'm_like';
    const FIELD_QUANTI = 'm_quanti';
    const FIELD_BUY = 'm_buy';
    const FIELD_STATUS = 'm_status';
    const FIELD_FILE_TYPE = 'm_file_type';
    const VALUE_STATUS_READY = 1;
    const VALUE_STATUS_PUBLIC = 2;
    const VALUE_STATUS_PENDING = 3;

    public $avataDefault = "asset/img/default/product.jpg";
    public $avataFolder = "upload/productAvata/original/";
    public $avataThumbs = [
        'small' => Array('path' => "upload/productAvata/small/", 'width' => 120, 'height' => 120 * 3 / 4),
        'medium' => Array('path' => "upload/productAvata/medium/", 'width' => 480, 'height' => 480 * 3 / 4),
        'large' => Array('path' => "upload/productAvata/large/", 'width' => 800, 'height' => 800 * 3 / 4)
    ];

    /**
     * Class kết nối dùng cho bảng 'product' (bảng lưu thông tin các sản phẩm)
     * 
     * @param object $connection PDO connect object, nếu $connection=null thì một kết nối mới sẽ được tạo
     * @return object Đối tượng thao tác với bảng 'product'
     */
    public function __construct($connection = null) {
        parent::__construct($connection);
        $this->db->table(self::TABLE_NAME);
        return $this;
    }

    public function getStatusLabel() {
        return [
            self::VALUE_STATUS_READY => "Khởi tạo",
            self::VALUE_STATUS_PUBLIC => "Công khai",
            self::VALUE_STATUS_PENDING => "Tạm dừng"
        ];
    }

    public function getAvataOriginal($id) {
        if (trim($id) == "") {
            return $this->avataDefault;
        }
        $productRow = $this->db->reset()->where([
            self::FIELD_ID => $id
        ])->get()->result();
		
        if ($productRow == false) {
            return $this->avataDefault;
        } else {
            $productRow = $productRow[0];
            $avata = $this->avataFolder . "" . $id . "." . $productRow[self::FIELD_FILE_TYPE];
            if (file_exists(\App\Config\Routes::getBaseUrl() . "/../" . $avata)) {
                return $avata;
            }
        }

        return $this->avataDefault;
    }
    public function getAvata($id, $thumbLabel = 'small') {
        if (!isset($this->avataThumbs[$thumbLabel])) {
            return $this->getAvataOriginal($id);
        }
        $avataThumb = $this->avataThumbs[$thumbLabel]['path'] . "" . $id . ".jpg";
        if (file_exists(__DIR__ . "/../../" . $avataThumb)) {
            return $avataThumb;
        }
        return $this->getAvataOriginal($id);
    }


    public function setAvata($id, $avata) {
        $avata = explode(";base64,", $avata);
        if (count($avata) > 1) {
            $avataMetadata = $avata[0];
            $avata = $avata[1];
            $avata = base64_decode($avata);
            $fileType = "gif";
            foreach (\App\Config\Defined::FILETYPES_IMAGE as $key => $value) {
                if ("data:" . $value == $avataMetadata) {
                    $fileType = $key;
                }
            }
            $filepath = __DIR__ . "/../../" . $this->avataFolder . "" . $id . "." . $fileType;
            $this->delAvata($id);
            file_put_contents($filepath, $avata);
            $this->db->reset()->where([
                self::FIELD_ID => $id
            ])->update([
                self::FIELD_FILE_TYPE => $fileType
            ]);
            if (file_exists($filepath)) {
                $this->setAvataThumb($id, $filepath);
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function setAvataThumb($id, $avataOrigin = false) {
        if (!file_exists($avataOrigin)) {
            $avataOrigin = __DIR__ . "/../../" . $this->getAvataOriginal($id);
        }
        $imageHelper = new \App\Helper\Image();
        foreach ($this->avataThumbs as $key => $avatarThumb) {
            $thumb = $imageHelper->resize(
                    $avataOrigin, __DIR__ . "/../../" . $avatarThumb['path'] . "" . $id, [
                'width' => $avatarThumb['width'],
                'height' => $avatarThumb['height'],
                'crop' => 'cut',
                'type' => 'jpg',
                'quality' => 100
                    ]
            );
        }
        return true;
    }

    public function delAvata($id) {
        $productRow = $this
                ->db
                ->reset()
                ->where([
                    \App\Model\Product::FIELD_ID => $id
                ])
                ->get()
                ->result();
        if ($productRow != false) {
            $productRow = $productRow[0];
            $avataOriginal = __DIR__ . "/../../" . $this->avataFolder . "" . $id . "." . $productRow[self::FIELD_FILE_TYPE];
            if (file_exists($avataOriginal)) {
                unlink($avataOriginal);
            }
            foreach ($this->avataThumbs as $key => $avatar_thumb_line) {
                $avataThumb = __DIR__ . "/../../" . $avatar_thumb_line['path'] . "" . $id . ".jpg";
                if (file_exists($avataThumb)) {
                    unlink($avataThumb);
                }
            }
        }
        return true;
    }

}

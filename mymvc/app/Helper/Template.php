<?php

namespace App\Helper;

class Template{

    private $templateFolder = '';

    public function __construct() {
        $this->templateFolder = __DIR__ . '/../View/template/';
    }

    /**
     * Trả về text sau khi thay thế dữ liệu từ một text mẫu.
     * 
     * @param string $template Dữ liệu mẫu
     * @param array $array_replace Dữ liệu thay thế
     * @return string|null -String: khi quá trình thay thế thành công<br>-null: Dữ liệu thay thế được truyền vào không phải là một mảng.
     */
    public function getFromTemplate($template, $array_replace = []) {
        if (!is_array($array_replace)) {
            return null;
        }
        return str_replace(array_keys($array_replace), array_values($array_replace), $template);
    }

    /**
     * Trả về text sau khi đọc file template và thay thế dữ liệu.
     * 
     * @param string $file Path của file template, tính từ thư mục "app/View/template/". <p>Nếu file template không tồn tại, chuỗi nguồn rỗng sẽ được sử dụng làm template.</p>
     * @param array $array_replace Dữ liệu thay thế
     * @return string
     */
    public function getFromTemplateFile($file, $array_replace = []) {
        return $this->getFromTemplate($this->loadTemplate($file), $array_replace);
    }

    /**
     * Trả về text sau khi đọc từ một file template được chỉ định.
     * 
     * @param string $file Path của file template, tính từ thư mục "app/View/template/". <p>Nếu file template không tồn tại, chuỗi nguồn rỗng sẽ được trả về.</p>
     * @return string
     */
    public function loadTemplate($file = '') {
        if (!file_exists($this->templateFolder . $file)) {
            return '';
        }
        return file_get_contents($this->templateFolder . $file);
    }

}

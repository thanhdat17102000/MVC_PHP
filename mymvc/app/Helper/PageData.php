<?php

namespace App\Helper;

class PageData {

    public \App\Helper\PageData\Meta $meta;
    public \App\Helper\PageData\Asset $asset;
    public $title = '';
    public $slogend = '';
    public $domainName = '';
    public $url = '';
    public $baseurl = '';
    public $canocialUrl = '';
    public $loggedUser = '';
    public $robots = '';
    public $optionShowHeader = '';
    public $optionShowFooter = '';

    /**
     * @var string Chỉ định file xử lý cho thẻ <main>, tính từ thư mục app/view/page/
     */
    public $mainPage = '';

    /**
     * @var mixed Chỉ định dữ liệu cho thẻ <main>
     */
    public $mainData = [];

    public function __construct($initData = null) {
        if (isset($initData)) {
            foreach ($initData as $key => $value) {
                $this->{$key} = $value;
            }
        }
        if ($this->baseurl == ''){
            $this->baseurl = \App\Config\Routes::getBaseUrl();
        }
        return $this;
    }

}

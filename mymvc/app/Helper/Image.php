<?php
namespace App\Helper;

//class phục vụ cho việc xử lí hình ảnh
class Image {

    private $_ar_filetype = "";

    public function __construct() {
        $this->_ar_filetype = Array('png' => 'image/png', 'wbmp' => 'image/bmp', 'gif' => 'image/gif', 'jpg' => 'image/jpeg');
    }

    public function get_image_data($path = false) {
        $out = Array(
            'data' => false,
            'type' => false,
            'width' => 0,
            'height' => 0
        );
        if ($path == false) {
            return $out;
        }
        $image = @imagecreatefrompng($path);
        if ($image != null && $image) {
            $out['type'] = 'png';
        } else {
            $image = @imagecreatefromgif($path);
            if ($image != null && $image) {
                $out['type'] = 'gif';
            } else {
                $image = @imagecreatefromwbmp($path);
                if ($image != null && $image) {
                    $out['type'] = 'wbmp';
                } else {
                    $image = @imagecreatefromjpeg($path);
                    if ($image != null && $image) {
                        $out['type'] = 'jpg';
                    } else {
                        $image = false;
                    }
                }
            }
        }
        $out['data'] = $image;
        if ($image == false) {
            return $out;
        }
        $out['width'] = @imagesx($image);
        if (!$out['width']) {
            $out['width'] = 0;
        }
        $out['height'] = @imagesy($image);
        if (!$out['height']) {
            $out['height'] = 0;
        }
        if ($out['height'] != 0) {
            $out['ratio'] = $out['width'] / $out['height'];
        } else {
            $out['ratio'] = 0;
        }
        return $out;
    }

    public function resize($path, $save = false, $option = Array()) {
        /*
          $path=đường dẫn hình ảnh đưa vào
          $save=false, đường dẫn lưu hình dạng 'duong_dan' không gồm file type
          $option=Array
          (
          'type'=>auto//ép kiểu hình thành, auto:giữ nguyên như file vào, jpg, png, gif
          'crop'=>auto,autofill,cut
          'width'=>auto,px
          'height'=>auto,px
          'ratio'=>auto,ratio//tỉ lệ width/height
         * 'quality' => 100
         * 
          )
         */
        if (!isset($option)) {
            $option = [
                'type' => 'auto',
                'crop' => 'auto',
                'width' => 'auto',
                'height' => 'auto',
                'ratio' => 'auto',
                'quality' => '100'
            ];
        }
        if (!isset($option['type'])) {
            $option['type'] = 'auto';
        }
        if (!isset($option['crop'])) {
            $option['crop'] = 'auto';
        }
        if (!isset($option['width'])) {
            $option['width'] = 'auto';
        }
        if (!isset($option['height'])) {
            $option['height'] = 'auto';
        }
        if (!isset($option['ratio'])) {
            $option['ratio'] = 'auto';
        }
        if (!isset($option['quality'])) {
            $option['quality'] = 100;
        }
        $image_in = $this->get_image_data($path);
        if ($image_in['data'] == false) {
            return false;
        }
        if ($option['ratio'] == 'auto') {
            $option['ratio'] = $image_in['ratio'];
        }
        $image_out = Array(
            'data' => $image_in['data'],
            'type' => $image_in['type'],
            'width' => $image_in['width'],
            'height' => $image_in['height']
        );
        if ($option['type'] != 'auto') {
            $image_out['type'] = $option['type'];
        }

        if ($option['width'] != 'auto') {
            $image_out['width'] = $option['width'];
            if ($option['height'] != 'auto') {
                $image_out['height'] = $option['height'];
            } else {
                $image_out['height'] = $image_out['width'] / $option['ratio'];
            }
        } else {
            if ($option['height'] != 'auto') {
                $image_out['height'] = $option['height'];
                $image_out['width'] = $option['ratio'] * $image_out['height'];
            } else {
                $image_out['width'] = $image_in['width'];
                $image_out['height'] = $image_out['width'] / $option['ratio'];
            }
        }
        $image_out['data'] = imagecreatetruecolor($image_out['width'], $image_out['height']);

        $image_out['ratio'] = $image_out['width'] / $image_out['height'];
        if ($option['crop'] == 'autofill') {
            $copy = Array(
                'from_x' => 0,
                'from_y' => 0,
                'from_width' => $image_in['width'],
                'from_height' => $image_in['height'],
                'to_x' => 0,
                'to_y' => 0,
                'to_width' => $image_out['width'],
                'to_height' => $image_out['height']
            );
            $copy['to_height'] = $copy['to_width'] / $image_in['ratio'];
            if ($copy['to_height'] > $image_out['height']) {
                $copy['to_height'] = $image_out['height'];
                $copy['to_width'] = $copy['to_height'] * $image_in['ratio'];
            }
            $copy['to_x'] = ($image_out['width'] - $copy['to_width']) / 2;
            $copy['to_y'] = ($image_out['height'] - $copy['to_height']) / 2;
        } else if ($option['crop'] == 'cut') {
            $copy = Array(
                'from_x' => 0,
                'from_y' => 0,
                'from_width' => $image_in['width'],
                'from_height' => $image_in['height'],
                'to_x' => 0,
                'to_y' => 0,
                'to_width' => $image_out['width'],
                'to_height' => $image_out['height']
            );
            $copy['from_height'] = $copy['from_width'] / $image_out['ratio'];
            if ($copy['from_height'] > $image_in['height']) {
                $copy['from_height'] = $image_in['height'];
                $copy['from_width'] = $copy['from_height'] * $image_out['ratio'];
            }
            $copy['from_x'] = ($image_in['width'] - $copy['from_width']) / 2;
            $copy['from_y'] = ($image_in['height'] - $copy['from_height']) / 2;
        } else {
            $copy = Array(
                'from_x' => 0,
                'from_y' => 0,
                'from_width' => $image_in['width'],
                'from_height' => $image_in['height'],
                'to_x' => 0,
                'to_y' => 0,
                'to_width' => $image_out['width'],
                'to_height' => $image_out['height']
            );
        }
        imagecopyresampled($image_out['data'], $image_in['data'], $copy['to_x'], $copy['to_y'], $copy['from_x'], $copy['from_y'], $copy['to_width'], $copy['to_height'], $copy['from_width'], $copy['from_height']);
        if ($save != false) {
            $this->save_image($image_out, $save, $option['quality']);
        }
        return $image_out;
    }

    private function save_image($image_data = false, $savepath = false, $quality = 100) {
        if ($image_data == false || $savepath == false) {
            return false;
        }
        if ($image_data['type'] == 'png') {
            imagepng($image_data['data'], $savepath . "." . $image_data['type'], 0);
            return true;
        }
        if ($image_data['type'] == 'gif') {
            imagegif($image_data['data'], $savepath . "." . $image_data['type']);
            return true;
        }
        if ($image_data['type'] == 'jpg') {
            imagejpeg($image_data['data'], $savepath . "." . $image_data['type'], $quality);
            return true;
        }
        if ($image_data['type'] == 'wbmp') {
            imagewbmp($image_data['data'], $savepath . "." . $image_data['type']);
            return true;
        }
        return false;
    }

}
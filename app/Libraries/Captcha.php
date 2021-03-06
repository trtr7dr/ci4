<?php

namespace App\Libraries;

class Captcha {

    public static $width = 220;
    public static $height = 120;
    public static $fonts_num = 4;
    private static $_code_time = 180;

    public function __construct() {
        helper('cookie');
    }

    public function generate_code() {
        $chars = 'ADRabdefhknrstyz23456789';
        $length = rand(5, 7);
        $numChars = strlen($chars); // Узнаем, сколько у нас задано символов
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $numChars - 1)];
        }
        $array_mix = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
        srand((float) microtime() * 1000000);
        shuffle($array_mix);
        delete_cookie('cap');
        set_cookie('cap', implode("", $array_mix), self::$_code_time);
        return implode("", $array_mix);
    }

    private function _add_circ($img) {
        for ($i = 0; $i < rand(1, 10); $i++) {
            $color = imagecolorallocate($img, rand(80, 170), rand(80, 170), rand(80, 170));
            $r = rand(0, 100);
            imageFilledEllipse($img, rand(0, self::$width), rand(0, self::$width), $r, $r, $color);
        }
    }

    private function _add_line($img, $mode = '', $max = 100) {
        for ($i = 0; $i < rand(0, $max); $i++) {

            $color = imagecolorallocate($img, rand(80, 150), rand(80, 150), rand(80, 150));

            if ($mode === 'parallel') {
                $r1 = rand(0, self::$width);
                $r2 = rand(0, self::$width);
                imageline($img, $r1, $r1, $r2, $r1, $color);
                imageline($img, $r1, $r2, $r1, rand(0, 220), $color);
            } else {
                imageline($img, rand(0, self::$width), rand(0, self::$width), rand(0, self::$width), rand(0, self::$width), $color);
            }
        }
    }

    private function _add_poly($img) {
        $points = [];
        for ($i = 0; $i < 10; $i++) {
            array_push($points, rand(0, self::$width * 2));
        }
        $color = imagecolorallocate($img, rand(80, 190), rand(80, 190), rand(80, 190));
        imageFilledPolygon($img, $points, 5, $color);
    }

    private function _set_glitch_color($image, $xn = 0, $yn = 0, $mode = 'normal') {
        $start = rand(self::$height / 2, self::$height / 2 - self::$height / 4);
        $finish = $start + rand(5, 15);
        for ($x = 0; $x < self::$width - 1; $x++) {
            for ($y = 0; $y < self::$height - 1; $y++) {
                if ($mode != 'normal') {
                    $xn = rand(0, 1);
                    $yn = rand(0, 1);
                } else {
                    $finish = $start + 3;
                }
                if ($y > $start && $y < $finish) {
                    imagesetpixel($image, $x + $xn, $y + $yn, imagecolorat($image, $x, $y));
                }
            }
        }
    }

    private function _add_glitch($img, $mode) {
        if ($mode !== 'normal') {
            for ($i = 0; $i < rand(1, 5); $i++) {
                $this->_set_glitch_color($img, rand(0, 1), rand(0, 1), $mode);
            }
        } else {
            $this->_set_glitch_color($img, rand(0, 1), rand(0, 1), $mode);
        }
    }

    private function _add_text($img, $text) {
        $x = 10; //старт
        for ($i = 0; $i < strlen($text); $i++) {
            $text_color = imagecolorallocate($img, rand(150, 250), rand(150, 250), rand(150, 250));
            imagettftext($img, rand(35, 40), rand(0, 10) - rand(0, 10), $x, rand(55, 95), $text_color, 'fonts/' . rand(1, self::$fonts_num) . ".ttf", $text[$i]);
            $x += rand(25, 35);
        }
    }

    private function _add_rand_bg($img) {

        for ($i = 0; $i < 10; $i++) {
            $this->_add_circ($img);
            $this->_add_poly($img);
        }

        for ($i = 0; $i < 30; $i++) {
            $this->_add_line($img, 'parallel');
        }

        for ($x = 0; $x < self::$width - 1; $x++) {
            for ($y = 0; $y < self::$height - 1; $y++) {
                imagesetpixel($img, $x, $y + rand(0, 3) - rand(0, 3), imagecolorat($img, $x, $y));
            }
        }
    }

    public function img_code($code) {
        $image = imagecreatetruecolor(self::$width, self::$height);
        imageantialias($image, true);
        $rand_color = imagecolorallocate($image, rand(50, 120), rand(50, 120), rand(50, 120));
        imagefilledrectangle($image, 0, 0, self::$width, self::$height, $rand_color);

        $this->_add_rand_bg($image);
        $this->_add_text($image, $code);

        $this->_add_glitch($image, 'normal');
        $this->_add_glitch($image, 'boom');
        $this->_add_line($image, 'rand', 200);
        
        $file = 'temp/' . md5($code) . ".png";
        imagepng($image, $file);
        imagedestroy($image);
        $res = base64_encode(file_get_contents($file));
        unlink($file);
        return $res;
    }

    public function check($tested) {
        $cap = get_cookie('cap');
        $r['error'] = '';
        if (!$cap) {
            $r['error'] = 'Срок действия кода безопасности истек.';
        } elseif (strcmp($tested, $cap)) {
            $r['error'] = 'Коды безопасности не совпадают.';
        }
        delete_cookie('cap');
        return $r;
    }

}

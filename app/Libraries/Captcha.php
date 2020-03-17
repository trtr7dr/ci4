<?php

namespace App\Libraries;

class Captcha {

    public static $width = 220;
    public static $height = 120;
    public static $fonts_num = 4;
    public static $code_time = 180;

    public function __construct() {
        helper('cookie');
    }

    public function generate_code() {
        $chars = 'abdefhknrstyz23456789';
        $length = rand(5, 7);
        $numChars = strlen($chars); // Узнаем, сколько у нас задано символов
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $numChars)];
        }
        $array_mix = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
        srand((float) microtime() * 1000000);
        shuffle($array_mix);
        delete_cookie('cap');
        set_cookie('cap', implode("", $array_mix), self::$code_time);
        return implode("", $array_mix);
    }

    private function add_circ($img) {
        for ($i = 0; $i < rand(1, 10); $i++) {
            $color = imagecolorallocate($img, rand(80, 120), rand(80, 120), rand(80, 120));
            $r = rand(0, 100);
            imageFilledEllipse($img, rand(0, self::$width), rand(0, self::$width), $r, $r, $color);
        }
    }

    private function add_line($img) {
        for ($i = 0; $i < rand(1, 10); $i++) {
            $color = imagecolorallocate($img, rand(80, 120), rand(80, 120), rand(80, 120));
            imageline($img, rand(0, self::$width), rand(1, self::$height), rand(self::$width, self::$height), rand(1, self::$height), $color);
        }
    }

    private function add_poly($img) {
        $points = [];
        for ($i = 0; $i < 10; $i++) {
            array_push($points, rand(0, self::$width * 2));
        }
        $color = imagecolorallocate($img, rand(80, 120), rand(80, 120), rand(80, 120));
        imageFilledPolygon($img, $points, 5, $color);
    }

    public function img_code($code) {
        $image = imagecreatetruecolor(self::$width, self::$height);
        imageantialias($image, true);
        $rand_color = imagecolorallocate($image, rand(50, 120), rand(50, 120), rand(50, 120));
        imagefilledrectangle($image, 0, 0, self::$width, self::$height, $rand_color);

        $this->add_circ($image);
        $this->add_poly($image);
        $this->add_line($image);

        $x = 10; //старт
        for ($i = 0; $i < strlen($code); $i++) {
            $text_color = imagecolorallocate($image, rand(100, 200), rand(100, 200), rand(100, 200));
            imagettftext($image, rand(20, 25), rand(0, 10) - rand(0, 10), $x, rand(55, 95), $text_color, 'fonts/' . rand(1, self::$fonts_num) . ".ttf", $code[$i]);
            $x += rand(25, 30);
        }

        $this->add_line($image);
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

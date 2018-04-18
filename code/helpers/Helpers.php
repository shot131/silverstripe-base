<?php

class Helpers
{

    public static function array_map_assoc(callable $f, array $a)
    {
        return array_column(array_map($f, array_keys($a), $a), 1, 0);
    }

    public static function translit($s)
    {
        $s = (string)$s; // преобразуем в строковое значение
        $s = strip_tags($s); // убираем HTML-теги
        $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
        $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => ''));
        $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
        $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
        return $s; // возвращаем результат
    }

    public static function generateRandomString($length = 10, $low = false)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        if ($low) $randomString = mb_strtolower($randomString);
        return $randomString;
    }

    static function getContrastYIQ($hexcolor)
    {
        $r = hexdec(substr($hexcolor, 0, 2));
        $g = hexdec(substr($hexcolor, 2, 2));
        $b = hexdec(substr($hexcolor, 4, 2));
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
        return ($yiq >= 128) ? '000000' : 'ffffff';
    }

    public static function typograph($string)
    {
        $typograf = new EMTypograph();
        $typograf->setup(array(
            'Text.paragraphs' => 'off',
            'OptAlign.oa_oquote' => 'off',
            'OptAlign.oa_obracket_coma' => 'off',
        ));
        $typograf->set_text($string);
        return html_entity_decode($typograf->apply());
    }

    public static function plural($n, $f0, $f1, $f2)
    {
        if ($n % 10 == 1 && $n % 100 != 11) {
            return $f1;
        } elseif ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20)) {
            return $f2;
        } else {
            return $f0;
        }
    }

    public static function mb_ucfirst($string, $encoding = 'UTF-8')
    {
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }

    public static function getStageSuffix()
    {
        $stage = Versioned::current_stage();
        $suffix = $stage != "Stage" ? '_' . $stage : '';
        return $suffix;
    }

    public static function create_image_object(string $fileUrl): Image
    {
        $fileAbsPath = BASE_PATH . '/' . $fileUrl;
        if (!file_exists($fileAbsPath)) throw new Exception("File not found");
        $image = new Image_cached($fileUrl, true);
        return $image;
    }

    public static function create_file_object(string $fileUrl): File
    {
        $fileAbsPath = BASE_PATH . '/' . $fileUrl;
        if (!file_exists($fileAbsPath)) throw new Exception("File not found");
        $file = new File_Cached($fileUrl, true);
        return $file;
    }

    public static function load_remote_file(string $src, string $dirName, string $fileName = ''): ?File {
        $file = File::get()->filter([
            'RemoteName' => $src
        ]);
        /** @var File $result */
        if (!$file->exists()) {
            $dirPath = sprintf('%s/assets/%s', BASE_PATH, $dirName);
            if (!is_dir($dirPath)) {
                mkdir($dirPath, 0777, true);
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_URL, $src);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
            $st = curl_exec($ch);
            if ($st === false) return null;
            $type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            $mimes = new \Mimey\MimeTypes;
            $ext = $mimes->getExtension($type);
            if (empty($ext)) return null;
            $fileUrl = sprintf('assets/%s/%s.%s', $dirName, $fileName ?: basename($src), $ext);
            $filePath = BASE_PATH.'/'.$fileUrl;
            $fd = fopen($filePath, 'w');
            fwrite($fd, $st);
            fclose($fd);
            curl_close($ch);
            Filesystem::sync(null, false);
            $file = File::get()->filter('Filename', $fileUrl);
            if (!$file->exists()) {
                return null;
            }
            $result = $file->first();
            $result->setField('RemoteName', $src);
            $result->write();
        } else {
            $result = $file->first();
        }
        return $result;
    }

    public static function load_remote_image(string $src, string $dirName, string $fileName = ''): ?Image {
        /** @var Image $result */
        $result = self::load_remote_file($src, $dirName, $fileName);
        return $result;
    }

    public static function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object))
                        self::rrmdir($dir . "/" . $object);
                    else
                        unlink($dir . "/" . $object);
                }
            }
            rmdir($dir);
        }
    }

    public static function get_maximum_file_upload_size(): int
    {
        return min(Helpers::convert_php_size_to_bytes(ini_get('post_max_size')), Helpers::convert_php_size_to_bytes(ini_get('upload_max_filesize')));
    }

    public static function convert_php_size_to_bytes($sSize): int
    {
        //
        $sSuffix = strtoupper(substr($sSize, -1));
        if (!in_array($sSuffix, array('P', 'T', 'G', 'M', 'K'))) {
            return (int)$sSize;
        }
        $iValue = substr($sSize, 0, -1);
        switch ($sSuffix) {
            case 'P':
                $iValue *= 1024;
            // Fallthrough intended
            case 'T':
                $iValue *= 1024;
            // Fallthrough intended
            case 'G':
                $iValue *= 1024;
            // Fallthrough intended
            case 'M':
                $iValue *= 1024;
            // Fallthrough intended
            case 'K':
                $iValue *= 1024;
                break;
        }
        return (int)$iValue;
    }

    public static function array_find(array $xs, callable $f)
    {
        foreach ($xs as $x) {
            if (call_user_func($f, $x) === true)
                return $x;
        }
        return null;
    }

}
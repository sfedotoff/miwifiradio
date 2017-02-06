<?php
if (!defined("_KATE_MAIN")) die("You have no access to this file");
include_once($global_path . "include/template.php");
include_once($global_path . "include/security.php");
include_once($global_path . "include/mysql.php");

//Вывод верхнего меню в админке
function top_admin_menu()
{
    global $global_path, $lang, $mod_connect;
    include_once($global_path . "config/valid_modules.php");
    $mana_active = (in_array($mod_connect, $modules)) ? " class=\"active\"" : "";
    $menu = "
   <ul id=\"navbar\">
    <li$mana_active><a href=\"javascript: void(0);\"><span class=\"icon_text content\"></span>Управление</a>
	<ul>";
    for ($i = 0; $i < count($modules); $i++) {
        if (!is_array($modules[$i])) {
            $menu .= "<li";
            if ($mod_connect == $modules[$i]) $menu .= " class=\"active\"";
            $menu .= "><a href='admin.php?mod=" . $modules[$i] . "' class=\"" . $modules[$i] . "\">" . $module_titles[$i] . "</a></li>";
        } else {
            if (file_exists("images/admin/template/small/" . $modules[$i][0] . ".png")) $menu .= "<li><a href='admin.php?mod=" . $modules[$i][0] . "'><img src=\"/images/admin/template/small/" . $modules[$i][0] . ".png\" border=\"0\" alt=\"" . $module_titles[$i][0] . "\">" . $module_titles[$i][0] . "</a><ul>";
            else $menu .= "<li><a href='admin.php?mod=" . $modules[$i][0] . "'><img src=\"/images/admin/template/small/bullet.gif\" border=\"0\" alt=\"" . $module_titles[$i][0] . "\">" . $module_titles[$i][0] . "</a><ul>";
            for ($j = 1; $j < count($modules[$i]); $j++) {
                if (file_exists("images/admin/template/small/" . $modules[$i][$j] . ".png")) $menu .= "<li><a href='admin.php?mod=" . $modules[$i][$j] . "'><img src=\"/images/admin/template/small/" . $modules[$i][$j] . ".png\" border=\"0\" alt=\"" . $module_titles[$i][$j] . "\">" . $module_titles[$i][$j] . "</a></li>";
                else $menu .= "<li><a href='admin.php?mod=" . $modules[$i][$j] . "'><img src=\"/images/admin/template/small/bullet.gif\" border=\"0\" alt=\"" . $module_titles[$i][$j] . "\">" . $module_titles[$i][$j] . "</a></li>";
            }
            $menu .= "</ul></li>";
        }
    }
    $menu .= "
    </ul>
	</li>";
    $confact = (strpos($mod_connect, "configurator") !== false) ? " class=\"active\"" : "";
    $admact = ($mod_connect == "admins") ? " class=\"active\"" : "";
    $menu .= "<li$confact><a href=\"admin.php?mod=kate_configurator\"><span class=\"icon_text settings\"></span>Настройки</a></li>
    <li$admact><a href=\"admin.php?mod=admins\"><span class=\"icon_text users\"></span>Администраторы</a></li>
    <li><a href=\"/\" target=\"_blank\"><span class=\"icon_text sprv\"></span>Просмотр сайта</a></li>
   </ul>
   <script type='text/javascript'>
  $(function() {
    $('#nav').droppy();
  });
</script>";
    return $menu;
}

//Запись файлов конфига
function writefile($filename, $content)
{
    global $global_path;
    $content = "<?php\nif (!defined(\"_KATE_MAIN\")) die(\"You have no access to this file\");\n" . $content . "\n?>";
    $fp = fopen($global_path . $filename, "w");
    fwrite($fp, $content);
    fclose($fp);
}

//Генерация рандомного текста
function gen_pass($m)
{
    $m = intval($m);
    $pass = "";
    for ($i = 0; $i < $m; $i++) {
        $te = mt_rand(48, 122);
        if (($te > 57 && $te < 65) || ($te > 90 && $te < 97)) $te = $te - 9;
        $pass .= chr($te);
    }
    return $pass;
}

//очистка текста от лишнего
function text_filter($message, $type = "")
{
    global $conf;
    $message = is_array($message) ? fields_save($message) : $message;
    if (intval($type) == 2) {
        $message = htmlspecialchars(trim($message), ENT_QUOTES);
    } else {
        $message = strip_tags(urldecode($message));
        $message = htmlspecialchars(trim($message), ENT_QUOTES);
    }
    if ($conf['censor'] && intval($type != 1)) {
        $censor_l = explode(",", $conf['censor_l']);
        foreach ($censor_l as $val) $message = preg_replace("#$val#i", $conf['censor_r'], $message);
    }
    return $message;
}

function is_user()
{
    global $db;
    $id = $_COOKIE['userid'];
    $password = $_COOKIE['userpass'];
    $result = $db->sql_query("SELECT id FROM users WHERE id='$id' AND pass='$password'");
    if ($db->sql_numrows($result) > 0) return true; else return false;
}

//Размер файла, удобный для чтения
function files_size($size)
{
    $name = array("Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
    $mysize = $size ? "" . round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . " " . $name[$i] . "" : "" . $size . " Bytes";
    return $mysize;
}

//Обрезка строки
function cutstr($linkstrip, $strip)
{
    if (strlen($linkstrip) > $strip) $linkstrip = substr($linkstrip, 0, $strip) . "…";
    return $linkstrip;
}

//Вывод поля выбора даты
function date_field($timestamp, $field_name)
{
    $months = array("", "января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
    $month = date("m", $timestamp);
    $day = date("d", $timestamp);
    $year = date("Y", $timestamp);
    $hour = date("H", $timestamp);
    $minute = date("i", $timestamp);
    $content = "<div style=\"vertical-align:middle;\" class=\"datefield\"><input type=\"text\" size=\"2\" maxlength=\"2\" name=\"day_$field_name\" id=\"day_$field_name\" value=\"$day\"> <select id=\"month_$field_name\" name=\"month_$field_name\">";
    for ($i = 1; $i < 13; $i++) {
        $content .= "<option value=\"$i\"";
        if ($i == $month) $content .= " selected";
        $content .= ">" . $months[$i] . "</option>";
    }
    $content .= "</select> <input type=\"text\" size=\"4\" maxlength=\"4\" name=\"year_$field_name\" id=\"year_$field_name\" value=\"$year\"> в <input type=\"text\" name=\"hour_$field_name\" id=\"hour_$field_name\" value=\"$hour\" size=\"2\" maxlength=\"2\"> : <input type=\"text\" name=\"minute_$field_name\" id=\"minute_$field_name\" value=\"$minute\" size=\"2\" maxlength=\"2\"></div>";
    return $content;
}

//Мультибайтовая обрезка строки
function mb_trim($string, $charlist = '\\\\s', $ltrim = true, $rtrim = true)
{
    $both_ends = $ltrim && $rtrim;

    $char_class_inner = preg_replace(
        array('/[\^\-\]\\\]/S', '/\\\{4}/S'),
        array('\\\\\\0', '\\'),
        $charlist
    );

    $work_horse = '[' . $char_class_inner . ']+';
    $ltrim && $left_pattern = '^' . $work_horse;
    $rtrim && $right_pattern = $work_horse . '$';

    if ($both_ends) {
        $pattern_middle = $left_pattern . '|' . $right_pattern;
    } elseif ($ltrim) {
        $pattern_middle = $left_pattern;
    } else {
        $pattern_middle = $right_pattern;
    }
    return preg_replace("/$pattern_middle/usSD", '', $string);
}

//Склонение числительных
//declOfNum(5, array('иностранный язык', 'иностранных языка', 'иностранных языков'))
function declOfNum($number, $titles)
{
    $cases = array(2, 0, 1, 1, 1, 2);
    return $number . " " . $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
}

function output_file($file, $name, $mime_type = '')
{
    /*
    This function takes a path to a file to output ($file),
    the filename that the browser will see ($name) and
    the MIME type of the file ($mime_type, optional).

    If you want to do something on download abort/finish,
    register_shutdown_function('function_name');
    */
    if (!is_readable($file)) die('File not found or inaccessible!');

    $size = filesize($file);
    $name = rawurldecode($name);


    /* Figure out the MIME type (if not specified) */
    $known_mime_types = array(
        "pdf" => "application/pdf",
        "txt" => "text/plain",
        "html" => "text/html",
        "htm" => "text/html",
        "exe" => "application/octet-stream",
        "zip" => "application/zip",
        "doc" => "application/msword",
        "xls" => "application/vnd.ms-excel",
        "ppt" => "application/vnd.ms-powerpoint",
        "gif" => "image/gif",
        "png" => "image/png",
        "jpeg" => "image/jpg",
        "jpg" => "image/jpg",
        "php" => "text/plain",
        "m3u8" => 'application/vnd.apple.mpegurl'
    );

    if ($mime_type == '') {
        $file_extension = strtolower(substr(strrchr($file, "."), 1));
        if (array_key_exists($file_extension, $known_mime_types)) {
            $mime_type = $known_mime_types[$file_extension];
        } else {
            $mime_type = "application/force-download";
        };
    };

    @ob_end_clean(); //turn off output buffering to decrease cpu usage

    // required for IE, otherwise Content-Disposition may be ignored
    if (ini_get('zlib.output_compression'))
        ini_set('zlib.output_compression', 'Off');

    header('Content-Type: ' . $mime_type);
    header('Content-Disposition: attachment; filename="' . $name . '"');
    header("Content-Transfer-Encoding: binary");
    header('Accept-Ranges: bytes');

    /* The three lines below basically make the
       download non-cacheable */
    header("Cache-control: private");
    header('Pragma: private');
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

    // multipart-download and download resuming support
    if (isset($_SERVER['HTTP_RANGE'])) {
        list($a, $range) = explode("=", $_SERVER['HTTP_RANGE'], 2);
        list($range) = explode(",", $range, 2);
        list($range, $range_end) = explode("-", $range);
        $range = intval($range);
        if (!$range_end) {
            $range_end = $size - 1;
        } else {
            $range_end = intval($range_end);
        }

        $new_length = $range_end - $range + 1;
        header("HTTP/1.1 206 Partial Content");
        header("Content-Length: $new_length");
        header("Content-Range: bytes $range-$range_end/$size");
    } else {
        $new_length = $size;
        header("Content-Length: " . $size);
    }

    /* output the file itself */
    $chunksize = 1 * (1024 * 1024); //you may want to change this
    $bytes_send = 0;
    if ($file = fopen($file, 'r')) {
        if (isset($_SERVER['HTTP_RANGE']))
            fseek($file, $range);

        while (!feof($file) &&
            (!connection_aborted()) &&
            ($bytes_send < $new_length)
        ) {
            $buffer = fread($file, $chunksize);
            print($buffer); //echo($buffer); // is also possible
            flush();
            $bytes_send += strlen($buffer);
        }
        fclose($file);
    } else die('Error - can not open file.');

    die();
}

//File uploading control
function upload_file($fieldname, $dirtoplace, $filename = "", $thumbdir = "", $thumbwidth = 0, $thumbheight = 0, $centercrop = false)
{
    $file = $_FILES[$fieldname];
    if (intval($file['size'])) {
        if (is_uploaded_file($file['tmp_name'])) {
            $type = strtolower(substr(strrchr($file['name'], "."), 1));
            $notypename = (strlen($filename) > 0) ? $filename : gen_pass(15);
            $newname = $notypename . "." . $type;
            move_uploaded_file($file['tmp_name'], $dirtoplace . "/" . $newname);
            chmod($dirtoplace . "/" . $newname, 0666);
            if (strlen($thumbdir) > 0 OR $thumbwidth > 0 OR $thumbheight > 0) {
                $on=$dirtoplace . "/" . $newname;
                $nn=$dirtoplace . "/thumb/thumb_" . $newname;
                make_thumb($on,$nn,250,250);
            }
            return $newname;
        } else return "";
    } else return "";
}

// Recursive directory removing
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . "/" . $object))
                    rrmdir($dir . "/" . $object);
                else
                    unlink($dir . "/" . $object);
            }
        }
        rmdir($dir);
    }
}

// Logging function. We need to reverse the requests
function addlog($var)
{
    ob_start();
    print_r($var);
    echo PHP_EOL . '-----------------------------------------------------' . PHP_EOL;
    $req_dump = ob_get_clean();
    $fp = fopen('log.txt', 'a');
    fwrite($fp, $req_dump);
    fclose($fp);
}

// Function to compose request to the API and return the parameters to our main script
function request_compose()
{
    $httpHost = $_SERVER['HTTP_HOST'];
    $httpScheme = $_SERVER['REQUEST_SCHEME'];
    $method = $_SERVER['REQUEST_METHOD'];
    $pathExploded = explode('?', $_SERVER['REQUEST_URI']);
    $requestPath = $pathExploded[0];
    $params = [];
    $paramsString = '';
    if ($method == 'GET') {
        $paramsString = $pathExploded[1];
        $paramStringExploded = explode('&', $pathExploded[1]);
        foreach ($paramStringExploded as $param) {
            $paramExploded = explode('=', $param);
            $params[$paramExploded[0]] = $paramExploded[1];
        }
    }
    if ($method == 'POST') {
        foreach ($_POST as $key => $val) {
            $params[$key] = $val;
        }
    }
    $request = [
        'method' => $method,
        'httpScheme' => $httpScheme,
        'httpHost' => $httpHost,
        'requestPath' => $requestPath,
        'params' => $params,
        'paramsString' => $paramsString
    ];
    return $request;
}

function make_thumb($src, $dest, $desired_width,$desired_h) {
  $info = new SplFileInfo($src);
  $ext = $info->getExtension();
  if(strcasecmp($ext, "jpg")==0 or strcasecmp($ext, "jpeg")==0 ) {
      $source_image = imagecreatefromjpeg($src);
  } else if(strcasecmp($ext, "png")==0) {
      $source_image = imagecreatefrompng($src);
  } else if(strcasecmp($ext, "gif")==0) {
      $source_image = imagecreatefromgif($src);
  } else {
    echo "Error extension: $ext!";
  }
  $width = imagesx($source_image);
  $height = imagesy($source_image);

  $desired_height = $desired_h;

  /* create a new, "virtual" image */
  $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

  /* copy source image at a resized size */
  imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

  /* create the physical thumbnail image to its destination */
  if(strcasecmp($ext, "jpg")==0 or strcasecmp($ext, "jpeg")==0 ) {
      imagejpeg($virtual_image, $dest);
  } else if(strcasecmp($ext, "png")==0) {
      imagepng($virtual_image, $dest);
  } else if(strcasecmp($ext, "gif")==0) {
      imagegif($virtual_image, $dest);
  }
}

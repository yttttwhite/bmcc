<?php
/*{{{LICENSE
+-----------------------------------------------------------------------+
| SlightPHP Framework                                                   |
+-----------------------------------------------------------------------+
| This program is free software; you can redistribute it and/or modify  |
| it under the terms of the GNU General Public License as published by  |
| the Free Software Foundation. You should have received a copy of the  |
| GNU General Public License along with this program.  If not, see      |
| https://www.gnu.org/licenses/.                                         |
| Copyright (C) 2008-2009. All Rights Reserved.                         |
+-----------------------------------------------------------------------+
| Supports: https://www.slightphp.com                                    |
+-----------------------------------------------------------------------+
}}}*/

if (!defined("SLIGHTPHP_PLUGINS_DIR")) define("SLIGHTPHP_PLUGINS_DIR", dirname(__FILE__));
require_once(SLIGHTPHP_PLUGINS_DIR . "/tpl/Tpl.php");

/**
 * @package SlightPHP
 */
class STpl extends Tpl
{
    static $engine;

    /**
     * render a .tpl
     */
    public function render($tpl, $parames = array(), $theme = "")
    {
        $this->assign('_GET', $_GET);
        $defaultTheme = "default";
        $tpl = str_replace('v2', '', $tpl);
        $tpl = trim($tpl, '/');
        $tpl = '/' . $tpl;

        parent::$compile_dir = SlightPHP::$appDir . DIRECTORY_SEPARATOR . "templates_c";
        parent::$template_dir = SlightPHP::$appDir . DIRECTORY_SEPARATOR . "templates";

        if (strlen($theme) > 0) {
            $template = $theme . $tpl;
        } else {
            $template = $defaultTheme . $tpl;
        }
        if (file_exists(parent::$template_dir . '/' . $template)) {
        } elseif (file_exists(parent::$template_dir . '/' . $defaultTheme . $tpl)) {
            $template = $defaultTheme . $tpl;
        } elseif (file_exists(parent::$template_dir . $tpl)) {
            $template = $tpl;
        }
        parent::assign($parames);
        return parent::fetch($template);
    }

    /**
     * 302 redirect
     */
    //edit by 方正 2019.8.2,所有url加上/baichuan_advertisement_manage前缀
    public function redirect($url)
    {
        $url = $this->setUrlPrefix($url);
        header('Location:' . $url);
        exit;
    }

    //edit by 方正 2019.8.2,所有url加上/baichuan_advertisement_manage前缀
    public function success($msg = "", $url = "/", $second = 1)
    {
        $url = $this->setUrlPrefix($url);
        $this->assign('msg', $msg);
        $this->assign('url', $url);
        $this->assign('second', $second);
        return $this->render("public/success.html");
    }

    //edit by 方正 2019.8.2,所有url加上/baichuan_advertisement_manage前缀
    public function parentReload($msg = "", $url = "/", $second = 1)
    {
        $url = $this->setUrlPrefix($url);
        $this->assign('msg', $msg);
        $this->assign('url', $url);
        $this->assign('second', $second);
        return $this->render("public/parentReload.html");
    }

    public function unsetGet($get, $keepPATHINFO = false)
    {
        $getArray = $_GET;
        if (is_array($get) && is_array($getArray)) {
            foreach ($get as $key) {
                if (isset($getArray[$key])) {
                    unset($getArray[$key]);
                }
            }
        } elseif (is_array($getArray) && isset($getArray[$get])) {
            unset($getArray[$get]);
        }

        if (!$keepPATHINFO && is_array($getArray) && isset($getArray['PATH_INFO'])) {
            unset($getArray['PATH_INFO']);
        }

        return $getArray;
    }

    public function setGet($url, $getArray)
    {
        $url = $url . "?";
        foreach ($getArray as $key => $value) {
            $url .= $key . "=" . $value . "&";
        }
        return $url;
    }

    public function array_column($input, $column_key, $index_key = "")
    {
        $return = array();
        foreach ($input as $key => $value) {
            if (isset($value[$column_key])) {
                if (strlen($index_key) > 0 && isset($value[$index_key])) {
                    $return[$index_key] = $value[$column_key];
                } else {
                    $return[] = $value[$column_key];
                }
            }
        }
        return $return;
    }


    //验证上传图标素材是否符合标准
    public function Validate($paragram, $flag)
    {
        $icon_size = SConfig::getConfigArray(ROOT_CONFIG . "/config.php", "icon_size");
//		$inmobi_stuff_size1 = SConfig::getConfigArray(ROOT_CONFIG."/config.php","inmobi_stuff_size1");
//		$inmobi_stuff_size2 = SConfig::getConfigArray(ROOT_CONFIG."/config.php","inmobi_stuff_size2");
        $inmobi_stuff_size3 = SConfig::getConfigArray(ROOT_CONFIG . "/config.php", "inmobi_stuff_size3");
        $inmobi_stuff_size4 = SConfig::getConfigArray(ROOT_CONFIG . "/config.php", "inmobi_stuff_size4");
        $response = array();
        if ($paragram['view_type'] == 1002) {
            if ($flag == 1 && strlen($paragram['file']['ad-icon-file']['tmp_name']) > 0) {
                $img_info = getimagesize($paragram['file']['ad-icon-file']['tmp_name']);
                $img_wid = $img_info[0];
                $img_hei = $img_info[1];
                if ($img_wid != $paragram['stuff_icon_size'] && $img_hei != $paragram['stuff_icon_size']) {
                    $response['error']++;
                    $response['message'] .= "图标素材实际尺寸(宽度*长度)为：" . $img_wid . '*' . "$img_hei";
                    $response['message'] .= "\n预期值为:" . $paragram['stuff_icon_size'] . '*' . $paragram['stuff_icon_size'];
                }
            }
            if ($flag == 2 && strlen($paragram['file']['ad-logo-file']['tmp_name']) > 0) {
                $img_info_logo = getimagesize($paragram['file']['ad-logo-file']['tmp_name']);
                $img_wid_logo = $img_info_logo[0];
                $img_hei_logo = $img_info_logo[1];
                if ($img_wid_logo != $paragram['stuff_logo_size'] && $img_hei_logo != $paragram['stuff_logo_size']) {
                    $response['error']++;
                    $response['message'] .= "logo素材实际尺寸(宽度*长度)为：" . $img_wid_logo . '*' . "$img_hei_logo";
                    $response['message'] .= "\n预期值为:" . $paragram['stuff_logo_size'] . '*' . $paragram['stuff_logo_size'];
                }
            }
        }
        return $response;
    }

    //获取视频信息
    public function getVideoInfo($file)
    {
        require_once(ROOT_APP . "/../tools/getid3/getid3.php");
        $getID3 = new getID3;
        $getID3->option_md5_data = true;
        $getID3->option_md5_data_source = true;
        $getID3->encoding = 'UTF-8';
        $id3Info = $getID3->analyze($file);
        return $id3Info;
    }

    //保存文件
    public function saveFile($file)
    {
        $f_type = strtolower($file['type']);
        $result['mime_type'] = $f_type;
        $result['size'] = $file['size'];

        if ($f_type == "image/gif" OR $f_type == "image/png" OR $f_type == "image/jpeg" OR $f_type == "image/jpg") {
            if (filesize($file['tmp_name']) > 400 * 1024) {
                $result['error'] = "图片不能大于400K";
            } else {
                list($width, $height, $type, $attr) = getimagesize($file['tmp_name']);
                if (!empty($width) || !empty($height)) {
                    $result['width'] = $width;
                    $result['height'] = $height;
                    $result['type'] = 1;
                }
            }
        } elseif ($f_type == "application/x-shockwave-flash") {
            if (filesize($file['tmp_name']) > 400 * 1024) {
                $result['error'] = "Flash不能大于400K";
            } else {
                exec(ROOT_APP . "/../tools/swfdump -X -Y -r " . $file['tmp_name'], $r);
                preg_match("/\-X (\d+) \-Y (\d+) \-r ([\d|\.]+)/msi", $r[0], $m);
                if (!empty($m)) {
                    $width = $m[1];
                    $height = $m[2];
                    $result['width'] = $width;
                    $result['height'] = $height;
                    $result['type'] = 2;
                }
            }
        } elseif ($f_type == "video/mp4" || $f_type == "video/x-flv") {
            if ($f_type == "video/mp4") {
                $result['type'] = 6;
            } else if ($f_type == "video/x-flv") {
                $result['type'] = 10;
            }
            if (isset($file['tmp_name'])) {
                $info = $this->getVideoInfo($file['tmp_name']);
                if (isset($info['video']['resolution_x']) && isset($info['video']['resolution_y'])) {
                    $result['width'] = $info['video']['resolution_x'];
                    $result['height'] = $info['video']['resolution_y'];
                    $result['frame_rate'] = $info['video']['frame_rate'];
                }
                if (isset($info['playtime_seconds'])) {
                    $result['duration'] = floor($info['playtime_seconds']);
                }
                if (isset($info['bitrate'])) {
                    $result['bitrate'] = ceil($info['bitrate']);
                }
            }
        }

        if (empty($result['error']) && !empty($file['tmp_name'])) {
            require_once(ROOT . "/stuff/id.class.php");
            $file_object = new stuff_id;
            $file_id = $file_object->upload($file['tmp_name'], user_api::getUserID(), $result['type']);
            if ($file_id !== false) {
                //$result['fileid']=$file_id.'.'.end(explode(".", $file["name"]));
                $result['fileid'] = $file_id;
            } else {
                $result['error'] = "上传文件失败v1";
            }
        } else {
            $result['error'] = "上传文件失败v2";
        }
        return $result;
    }

    private function setUrlPrefix($url)
    {
        $urlLower = strtolower($url);
        if (strpos($urlLower, 'https') !== false) {
            return $url;
        }
        if (strpos($urlLower, '/baichuan_advertisement_manage') === false) {
            $url = '/baichuan_advertisement_manage/' . $url;
        }
        return $url;
    }

}

?>

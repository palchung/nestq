<?php

/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
session_start();
define('DIR_DOWNLOAD', $_SERVER['DOCUMENT_ROOT'] . '/');
define('HTTP_SERVER', 'http://' . $_SERVER['HTTP_HOST']);


/*
  error_reporting(E_ALL | E_STRICT);
  require('UploadHandler.php');
  //$upload_handler = new UploadHandler();



  $upload_handler = new UploadHandler(array(
  'upload_dir' => DIR_DOWNLOAD . '/nestq/public/upload/',
  'upload_url' => HTTP_SERVER . '/nestq/public/upload/',
  'image_versions' => array(
  'thumbnail' => array(
  'upload_dir' => DIR_DOWNLOAD . '/nestq/public/upload/thumbnail/',
  'upload_url' => HTTP_SERVER . '/nestq/public/upload/thumbnail/',
  'max_width' => 80,
  'max_height' => 80
  ),
  ),
  ));
 */




$options = array(
    'upload_dir' => DIR_DOWNLOAD . 'upload/' . $_SESSION['photofolder'] . '/',
    'upload_url' => HTTP_SERVER . '/upload/' . $_SESSION['photofolder'] . '/',
    'image_versions' => array(
        'thumbnail' => array(
            'upload_dir' => DIR_DOWNLOAD . 'upload/' . $_SESSION['photofolder'] . '/thumbnail/',
            'upload_url' => HTTP_SERVER . '/upload/' . $_SESSION['photofolder'] . '/thumbnail/',
            'max_width' => 80,
            'max_height' => 80
        ),
    ),
);
error_reporting(E_ALL | E_STRICT);
require('UploadHandler.php');

class CustomUploadHandler extends UploadHandler {
    /*
      protected function trim_file_name($name, $type) {

      $name = parent::trim_file_name($name, $type);
      $split_ext = explode('.', $name);
      $ext = end($split_ext);
      $name = sha1(time()) . '.' . $ext;

      return $name;
      }
     */

    protected function trim_file_name($file_path, $name, $size, $type, $error, $index, $content_range) {
        $name = utf8_decode($name);
        return parent::trim_file_name($file_path, $name, $size, $type, $error, $index, $content_range);
    }

}

$upload_handler = new CustomUploadHandler($options);


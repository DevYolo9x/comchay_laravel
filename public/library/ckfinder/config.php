<?php
$auth = isset($_COOKIE['authImagesManager']) ? $_COOKIE['authImagesManager'] : NULL;
//  dd($auth);
$flag = false;
$folder = '';
if (isset($auth) && !empty($auth)) {
    $auth = json_decode($auth, TRUE);
    if (isset($auth['email']) && !empty($auth['email'])) {
        $flag = true;
    }
    if (isset($auth['folder_upload']) && !empty($auth['folder_upload'])) {
        $folder = $auth['folder_upload'];
    }
    if (isset($auth['permission']) && is_array($auth['permission']) && count($auth['permission'])) {
        $upload = ((in_array('upload', $auth['permission'])) ? true : false);
        $delete = ((in_array('delete', $auth['permission'])) ? true : false);
        $copy = ((in_array('copy', $auth['permission'])) ? true : false);
        $move = ((in_array('move', $auth['permission'])) ? true : false);
        $rename = ((in_array('rename', $auth['permission'])) ? true : false);

        $dir_create = ((in_array('create_dirs', $auth['permission'])) ? true : false);
        $dir_rename = ((in_array('rename_dirs', $auth['permission'])) ? true : false);
        $dir_delete = ((in_array('delete_dirs', $auth['permission'])) ? true : false);
        $see_all  =  ((in_array('all', $auth['permission'])) ? true : false);
    } else {
        $upload = false;
        $delete = false;
        $copy = false;
        $move = false;
        $rename = false;
        $dir_delete = false;
        $dir_create = false;
        $dir_rename = false;
    }
}
/*
 * CKFinder Configuration File
 *
 * For the official documentation visit https://ckeditor.com/docs/ckfinder/ckfinder3-php/
 */

/*============================ PHP Error Reporting ====================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/debugging.html

// Production
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', 0);

// Development
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/*============================ General Settings =======================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html

$config = array();

/*============================ Enable PHP Connector HERE ==============================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_authentication
/*if ($flag == 'true') {
    $config['authentication'] = function () {
        return true;
    };
} else {
    $config['authentication'] = function () {
        return false;
    };
} */
$config['authentication'] = function () {
    return true;
};
/*============================ License Key ============================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_licenseKey

// $config['licenseName'] = 'localhost';
// $config['licenseKey']  = 'R9C9D6H1HBXPQJMJR3NP4BC6W2MDY';
$config['licenseName'] =  !empty($auth['domain']) ? $auth['domain'] : 'laravel.local';
$config['licenseKey']  = 'NHPHDT5DYNMJ6ZK3F8BADFXA9C8D2';
/*============================ CKFinder Internal Directory ============================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_privateDir
$config['privateDir'] = array(
    'backend' => 'default',
    'tags'   => '.ckfinder/tags',
    'logs'   => '.ckfinder/logs',
    'cache'  => '.ckfinder/cache',
    'thumbs' => '.ckfinder/cache/thumbs',
);
/*============================ Images and Thumbnails ==================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_images

$config['images'] = array(
    'maxWidth'  => 5000,
    'maxHeight' => 5000,
    'quality'   => 80,
    'sizes' => array(
        'small'  => array('width' => 480, 'height' => 320, 'quality' => 80),
        'medium' => array('width' => 600, 'height' => 480, 'quality' => 80),
        'large'  => array('width' => 800, 'height' => 600, 'quality' => 80)
    )
);

/*=================================== Backends ========================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_backends

$config['backends'][] = array(
    'name'         => 'default',
    'adapter'      => 'local',
    'baseUrl'      => '/upload/',
    //  'root'         => '', // Can be used to explicitly set the CKFinder user files directory.
    'chmodFiles'   => 0777,
    'chmodFolders' => 0755,
    'filesystemEncoding' => 'UTF-8',
);

/*================================ Resource Types =====================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_resourceTypes

$config['defaultResourceTypes'] = '';

$config['resourceTypes'][] = array(
    'name'              => 'Files', // Single quotes not allowed.
    'directory'         => 'files',
    'maxSize'           => 0,
    'allowedExtensions' => '7z,aiff,asf,avi,bmp,csv,doc,docx,fla,flv,gif,gz,gzip,jpeg,webp,svg,jpg,mid,mov,mp3,mp4,mpc,mpeg,mpg,ods,odt,pdf,png,ppt,pptx,qt,ram,rar,rm,rmi,rmvb,rtf,sdc,swf,sxc,sxw,tar,tgz,tif,tiff,txt,vsd,wav,wma,wmv,xls,xlsx,zip',
    'deniedExtensions'  => '',
    'backend'           => 'default'
);

$config['resourceTypes'][] = array(
    'name'              => 'Images',
    'directory'         => 'images',
    'maxSize'           => 0,
    'allowedExtensions' => 'bmp,gif,jpeg,jpg,png,webp,svg',
    'deniedExtensions'  => '',
    'backend'           => 'default'
);

/*================================ Access Control =====================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_roleSessionVar

$config['roleSessionVar'] = 'CKFinder_UserRole';

// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_accessControl
$config['accessControl'][] = array(
    'role'                => '*',
    'resourceType'        => '*',
    'folder'              => '/',

    'FOLDER_VIEW'         => $see_all, //xem toàn bộ
    'FOLDER_CREATE'       => $dir_create, //thêm mới thư mục
    'FOLDER_RENAME'       => $dir_rename, //đổi tên thư mục
    'FOLDER_DELETE'       => $dir_delete, //xóa thư mục

    'FILE_VIEW'           => true,
    'FILE_CREATE'         => $upload, //tạo file
    'FILE_RENAME'         => $rename, //đổi tên file
    'FILE_DELETE'         => $delete, //xóa file

    'IMAGE_RESIZE'        => false,
    'IMAGE_RESIZE_CUSTOM' => false
);


/*================================ Other Settings =====================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html

$config['overwriteOnUpload'] = false;
$config['checkDoubleExtension'] = true;
$config['disallowUnsafeCharacters'] = false;
$config['secureImageUploads'] = true;
$config['checkSizeAfterScaling'] = true;
$config['htmlExtensions'] = array('html', 'htm', 'xml', 'js');
$config['hideFolders'] = array('.*', 'CVS', '__thumbs');
$config['hideFiles'] = array('.*');
$config['forceAscii'] = false;
$config['xSendfile'] = false;

// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_debug
$config['debug'] = false;

/*==================================== Plugins ========================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_plugins

$config['pluginsDirectory'] = __DIR__ . '/plugins';
$config['plugins'] = array();

/*================================ Cache settings =====================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_cache

$config['cache'] = array(
    'imagePreview' => 24 * 3600,
    'thumbnails'   => 24 * 3600 * 365,
    'proxyCommand' => 0
);

/*============================ Temp Directory settings ================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_tempDirectory

$config['tempDirectory'] = sys_get_temp_dir();

/*============================ Session Cause Performance Issues =======================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_sessionWriteClose

$config['sessionWriteClose'] = true;

/*================================= CSRF protection ===================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_csrfProtection

$config['csrfProtection'] = true;

/*===================================== Headers =======================================*/
// https://ckeditor.com/docs/ckfinder/ckfinder3-php/configuration.html#configuration_options_headers

$config['headers'] = array();

/*============================== End of Configuration =================================*/

// Config must be returned - do not change it.
return $config;

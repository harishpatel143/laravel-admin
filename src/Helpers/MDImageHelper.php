<?php

namespace Multidots\Admin\Helpers;

use Illuminate\Support\Facades\Storage;

//use Webpatser\Uuid\Uuid;

class MDImageHelper
{

    /**
     * Stores errors
     *
     * @var array
     */
    public $Errors = [];

    /**
     * Global settings for image upload
     *
     * @var array
     */
    public static $GlobalSettings = [
        'imgMaxWidth' => 1024,
        'imgMaxHeight' => 768,
        'maxFileSize' => 34457280, // Approx 30MB
        'autoResize' => false,
        'uploadBasePath' => ''
    ];

    public static function constructor($settings = [])
    {
        if (!extension_loaded('gd') && !extension_loaded('gd2')) {
            trigger_error("GD is not loaded. You can not use this component.", E_USER_WARNING);

            return false;
        }

        self::$GlobalSettings['uploadBasePath'] = public_path('/files/');

        self::setupVars($settings);
    }

    /**
     * SetupVars
     * @param array $settings settings
     * @return void
     */
    public static function setupVars($settings = [])
    {
        self::$GlobalSettings = array_merge(self::$GlobalSettings, $settings);
    }

    /**
     * @param type $uploadedFile UploadFile
     * @param type $prefix Prefix
     * @param type $uploadToPath Uploadtopath
     * @param type $uploadImage Uploadtopath
     * @return bool Boolean
     */
//    public static function uploadImage($uploadedFile, $prefix = '', $uploadToPath = null)
//    {
//
//        $filename = $prefix . $uploadedFile->hashName();
//
//        $uploadedFilePath = self::$GlobalSettings['uploadBasePath'] . $filename;
//        $uploadDirectoryName = basename(self::$GlobalSettings['uploadBasePath']);
//
//        if ($uploadedFile->getpathName()) {
//            Storage::putFile($uploadDirectoryName, $uploadedFile, 'public');
//        } else {
//            return false;
//        }
//
//        return ['imagePath' => $uploadedFilePath, 'imageName' => $filename];
//    }

    public static function uploadImage($uploadedFile, $uploadToPath = null, $prefix = '')
    {
//        $uuid = Uuid::generate();
        $uuid = uniqid();
        $filename = $uuid . '.' . $uploadedFile->getClientOriginalExtension();

        $uploadedFilePath = $uploadToPath . $filename;
        $uploadDirectoryName = $uploadToPath;
        if ($uploadedFile->getpathName()) {
            Storage::putFileAs($uploadDirectoryName, $uploadedFile, $filename, 'public');
        } else {
            return false;
        }
        return ['imagePath' => $uploadedFilePath, 'imageName' => $filename];
    }

    /**
     * GetHeight
     * @param type $image Image
     * @return type Type
     */
    public static function getHeight($image)
    {
        $sizes = getimagesize($image);
        $height = $sizes[1];

        return $height;
    }

    /**
     * getWidth
     * @param type $image imageWidth
     * @return type Type
     */
    public static function getWidth($image)
    {
        $sizes = getimagesize($image);
        $width = $sizes[0];

        return $width;
    }

    /**
     * get fileExtension
     * @param type $filename filename
     * @return type
     */
    public static function getFileExtension($filename)
    {
        $tmp = explode(".", $filename);

        return end($tmp);
    }

    /**
     * Resize image from orignal image
     * @param string $img Image
     * @param int $resizeWidth Resizewidth
     * @param int $resizeHeight Resizeheight
     * @param string $newFilename NewFilename
     * @return string resize image path
     * @author The Chief
     */
    public static function resizeImage($img, $resizeWidth, $resizeHeight, $newFilename)
    {
        //Check if GD extension is loaded
        if (!extension_loaded('gd') && !extension_loaded('gd2')) {
            trigger_error("GD is not loaded", E_USER_WARNING);

            return false;
        }

        //Get Image size info
        $imgInfo = getimagesize($img);
        switch ($imgInfo[2]) {
            case 1:
                $image = imagecreatefromgif($img);
                break;
            case 2:
                $image = imagecreatefromjpeg($img);
                break;
            case 3:
                $image = imagecreatefrompng($img);
                break;
            default:
                trigger_error('Unsupported filetype!', E_USER_WARNING);
                break;
        }

        $nWidth = $resizeWidth;
        $nHeight = $resizeHeight;

        $newImg = imagecreatetruecolor($nWidth, $nHeight);

        /* Check if this image is PNG or GIF, then set if Transparent */
        if (($imgInfo[2] == 1) || ($imgInfo[2] == 3)) {
            imagealphablending($newImg, false);
            imagesavealpha($newImg, true);
            $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
            imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
        }

        imagecopyresampled($newImg, $image, 0, 0, 0, 0, $nWidth, $nHeight, $imgInfo[0], $imgInfo[1]);

        //Generate the file, and rename it to $newfilename
        switch ($imgInfo[2]) {
            case 1:
                imagegif($newImg, $newFilename);
                break;
            case 2:
                imagejpeg($newImg, $newFilename, 91);
                break;
            case 3:
                imagepng($newImg, $newFilename);
                break;
            default:
                trigger_error('Failed resize image!', E_USER_WARNING);
                break;
        }

        return $newFilename;
    }

}

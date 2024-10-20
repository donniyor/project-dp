<?php

namespace app\helpers;

use Yii;
use yii\base\Exception;
use yii\web\UploadedFile;
use \yii\web\HttpException;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\FileHelper;

class Upload
{
    public static string $UPLOADS_DIR = 'uploads';

    /**
     * @throws Exception
     * @throws HttpException
     */
    public static function file(UploadedFile $fileInstance, $dir = '', $namePostfix = true): array | string
    {
        $fileName = sprintf(
            '%s%s%s',
            Upload::getUploadPath($dir),
            DIRECTORY_SEPARATOR,
            Upload::getFileName($fileInstance, $namePostfix)
        );

        if (!$fileInstance->saveAs($fileName)) {
            throw new HttpException(
                500,
                sprintf(
                    '%s \'%s\' %s',
                    'Cannot upload file',
                    $fileName,
                    'Please check write permissions.'
                )
            );
        }

        return Upload::getLink($fileName);
    }

    /**
     * @throws Exception
     * @throws HttpException
     */
    static function getUploadPath($dir): string
    {
        $uploadPath = Yii::getAlias(
                '@webroot'
            ) . DIRECTORY_SEPARATOR . self::$UPLOADS_DIR . ($dir ? DIRECTORY_SEPARATOR . $dir : '');
        if (!FileHelper::createDirectory($uploadPath)) {
            throw new HttpException(500, 'Cannot create "' . $uploadPath . '". Please check write permissions.');
        }

        return $uploadPath;
    }

    static function getLink($fileName): array | string
    {
        return str_replace('\\', '/', str_replace(Yii::getAlias('@webroot'), '', $fileName));
    }

    static function getFileName($fileInstance, $namePostfix = true): string
    {
        $baseName = str_ireplace('.' . $fileInstance->extension, '', $fileInstance->name);
        $fileName = StringHelper::truncate(Inflector::slug($baseName), 32, '');
        if ($namePostfix || !$fileName) {
            $fileName .= ($fileName ? '-' : '') . substr(uniqid(md5(rand()), true), 0, 10);
        }
        $fileName .= '.' . $fileInstance->extension;

        return $fileName;
    }
}

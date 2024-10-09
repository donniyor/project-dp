<?php

namespace app\helpers;

use vova07\imperavi\Widget;
use vova07\imperavi\actions\GetImagesAction;
use vova07\imperavi\actions\UploadFileAction;
use Yii;
use yii\bootstrap5\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\StringHelper;
use yii\helpers\Url;

class Data
{
    public static function purifier($items)
    {
        if (is_array($items)) {
            $result = [];
            foreach ($items as $lang => $item) {
                if(is_array($item)) {
                    $data = [];
                    foreach ($item as $key => $value) {
                        $data[$key] = trim(HtmlPurifier::process($value));
                    }
                    $result[$lang] = $data;
                } else {
                    $result[$lang] = trim(HtmlPurifier::process($item));
                }
            }
            return $result;
        }
        return trim(HtmlPurifier::process($items));
    }

    public static function generateSeveralTabs($model, array $inputs = [], array $textareaInputs = [], array $textsToolOff = []): array
    {
        $className = StringHelper::basename(get_class($model));
        $tabItems = [];
        $controller = Yii::$app->controller->getUniqueId();

        foreach (self::languages() as $key => $language) {
            $content = '';
            if (count($inputs) > 0) {
                foreach($inputs as $input){
                    $content .= "<div class='mb-3'>";
                    $content .= Html::label("{$model->getAttributeLabel($input)}", '', ['class' => 'control-label']);
                    $content .= Html::input('text', "{$className}[$input][$key]", $model[$input][$key] ?? '', ['class' => 'form-control', 'required' => false]);
                    $content .=Html::error($model, "{$input}", ['class' => 'help-block']);
                    $content .= "</div>";
                }
            }

            if (count($textareaInputs) > 0) {
                foreach ($textareaInputs as $textareaInput){
                    $content .= "<div class='mb-3'>";
                    $content .= Html::label("{$model->getAttributeLabel($textareaInput)}", '', ['class' => 'control-label']);
                    $content .= Widget::widget([
                        'name' => "{$className}[$textareaInput][$key]",
                        'value' => $model[$textareaInput][$key] ?? '',
                        'settings' => [
                            'lang' => 'ru',
                            'minHeight' => 300,
                            'maxHeight' => 500,
                            'imageUpload' => Url::to(["/{$controller}/upload-image"]),
                            'plugins' => ['imagemanager', 'fullscreen', 'table'],
                        ],
                    ]);
                    $content .=Html::error($model, "{$textareaInput}", ['class' => 'help-block']);
                    $content .= "</div>";
                }
            }

            if (count($textsToolOff) > 0) {
                foreach ($textsToolOff as $textToolOff) {
                    $content .= "<div class='mb-3'>";
                    $content .= Html::label("{$model->getAttributeLabel($textToolOff)}", '', ['class' => 'control-label']);
                    $content .= Html::textarea("{$className}[$textToolOff][$key]", $model[$textToolOff][$key] ?? '', ['class' => 'form-control', 'required' => false]);
                    $content .= Html::error($model, "{$textToolOff}", ['class' => 'help-block']);
                    $content .= "</div>";
                }
            }

            $tabItems[] = [
                'label' => $language,
                'content' => $content
            ];
        }
        return $tabItems;
    }

    public static function languages(): array
    {
        return [
            'ru' => 'Русский',
            'uz' => 'Узбекский',
            'en' => 'Английский',
        ];
    }

    public static function statuses(): array
    {
        return [
            1 => 'Активный',
            0 => 'Отключён'
        ];
    }

    public static function getUploadImageSetting(): array
    {
        $controller = Yii::$app->controller->getUniqueId();
        return [
            'get-images' => [
                'class' => GetImagesAction::class,
                'url' => env('API_HOST')."/uploads/{$controller}",
                'path' => "@webroot/uploads/{$controller}",
            ],
            'upload-image' => [
                'class' => UploadFileAction::class,
                'url' => env('API_HOST')."/uploads/{$controller}",
                'path' => "@webroot/uploads/{$controller}",
            ],
        ];
    }

}
<?php

namespace app\helpers;

use app\models\Users;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class Buttons
{
    public static function get($model, $delete = true): ?string
    {
        $url = \Yii::$app->controller->id;
        $update = '<a href="' . Url::to(["/{$url}/update", "id" => $model->primaryKey]) . '" class="btn btn-bd-light actions" title="Редактирование"><i class="material-icons-two-tone">create</i></a>';
        $view = '<a href="' . Url::to(["/{$url}/make", "id" => $model->primaryKey]) . '" class="btn btn-bd-light actions" title="Просмотр"><i class="material-icons">visibility</i></a>';

        if ($delete) {
            $delete = $model->status !== -1;
        }

        $delete = $delete ? '<a href="' . Url::to(["/{$url}/delete", "id" => $model->primaryKey]) . '" class="btn btn-danger actions confirm-delete" title="Удалить"><i class="material-icons-two-tone">close</i></a>' : '';
        return '<div class="btn-group btn-group-sm" role="group">' . $update . $view . $delete . '</div>';
    }

    public static function getSeveral($model, $primaryKeys, $delete = true)
    {
        $url = \Yii::$app->controller->id;
        $update = '<a href="' . Url::to(["/{$url}/update"] + $primaryKeys) . '" class="btn btn-bd-light actions" title="Редактирование"><i class="material-icons-two-tone">create</i></a>';

        if ($delete) {
            $delete = $model->status === 1;
        }

        $delete = $delete ? '<a href="' . Url::to(["/{$url}/delete"] + $primaryKeys) . '" class="btn btn-danger actions confirm-delete" title="Удалить"><i class="material-icons-two-tone">close</i></a>' : '';
        return '<div class="btn-group btn-group-sm" role="group">' . $update . $delete . '</div>';
    }


    public static function getUser($model, $delete = true)
    {
        $url = \Yii::$app->controller->id;

        if ($delete) {
            $delete = Users::getStatusToDelete($model->status);
        }

        $delete = $delete ? '<a href="' . Url::to(["/{$url}/delete", "id" => $model->primaryKey]) . '" class="btn btn-danger actions confirm-delete" title="Удалить"><i class="material-icons-two-tone">close</i></a>' : '';
        return '<div class="btn-group btn-group-sm" role="group">' . $delete . '</div>';
    }

    public static function getView($model): string
    {
        $url = \Yii::$app->controller->id;
        $btn = '<a href="' . Url::to(["/{$url}/view", "id" => $model->primaryKey]) . '" class="btn actions" title="Просмотр"><i class="material-icons">visibility</i></a>';
        return '<div class="btn-group btn-group-sm" role="group">' . $btn . '</div>';
    }

    public static function getDate()
    {
        $input = '<div class="btn-group" role="group">';
        $input .= Html::input('text', 'TransactionsSearch[created_at]', Yii::$app->request->get('TransactionsSearch')['created_at'] ?? '', ['class' => 'form-control event-date']);
        $input .= '<div style="width: 40px;">';
        $input .= Html::a('<i class="material-icons">close</i>', '/' . Yii::$app->controller->id, ['class' => 'form-control btn btn-danger ', 'title' => 'очистить']);
        $input .= '</div>';
        $input .= '</div>';
        return $input;
    }
}
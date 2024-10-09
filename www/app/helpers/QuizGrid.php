<?php

namespace app\helpers;

use yii\grid\GridView;
use app\models\QuizizzSearch;
use yii\data\ActiveDataProvider;
use app\helpers\Buttons;


class QuizGrid
{
    public static function getView(ActiveDataProvider $dataProvider, QuizizzSearch $searchModel): void
    {
        echo 'da';

        echo self::getView($dataProvider, $searchModel);
    }

    protected static function viewGrid(ActiveDataProvider $dataProvider, QuizizzSearch $searchModel): string
    {
        return  'da';
        // echo GridView::widget([
        //     'dataProvider' => $dataProvider,
        //     'filterModel' => $searchModel,
        //     'tableOptions' => ['class' => 'table table-bordered'],
        //     //'rowOptions' => static fn($model) => $model->giveStatus($model->status),
        //     'columns' => [
        //         ['class' => 'yii\grid\SerialColumn'],
        //         'id',
        //         'title',
        //         'description:ntext',
        //         [
        //             'label' => 'Автор',
        //             'value' => 'user.username',
        //         ],
        //         [
        //             'header' => 'Действия',
        //             'format' => 'html',
        //             'headerOptions' => ['width' => '150'],
        //             //'content' => static fn($model) => Buttons::get($model)
        //         ],
        //     ],
        //     'pager' => [
        //         'class' => '\yii\bootstrap5\LinkPager',
        //     ],
        // ]);
    }
}
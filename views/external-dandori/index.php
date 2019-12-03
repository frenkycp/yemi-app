<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\web\View;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var app\models\search\SapPoRcvSearch $searchModel
*/

$this->title = [
    'page_title' => 'Dashboard',
    'tab_title' => 'Dashboard',
    'breadcrumbs_title' => 'Dashboard'
];
//$this->params['breadcrumbs'][] = $this->title['breadcrumbs_title'];

$this->registerCss("");

$this->registerJs($script, View::POS_READY);

?>
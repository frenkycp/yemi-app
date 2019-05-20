<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\IpqaPatrolTbl $model
*/

$this->title = 'Daily Patrol Input';
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Ipqa Patrol Tbls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud ipqa-patrol-tbl-create">

    <?= $this->render('_form', [
        'model' => $model,
        'section_arr' => $section_arr
    ]); ?>

</div>

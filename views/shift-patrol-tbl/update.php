<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\ShiftPatrolTbl $model
*/

$this->title = Yii::t('models', 'Shift Patrol Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Shift Patrol Tbl'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud shift-patrol-tbl-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    'location_arr' => $location_arr,
    'section_arr' => $section_arr,
    ]); ?>

</div>

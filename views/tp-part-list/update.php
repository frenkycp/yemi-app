<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\TpPartList $model
*/
    
$this->title = Yii::t('app', 'Tp Part List') . " " . $model->tp_part_list_id . ', ' . 'Edit';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tp Part List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->tp_part_list_id, 'url' => ['view', 'tp_part_list_id' => $model->tp_part_list_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud tp-part-list-update">

    <h1>
        <?= Yii::t('app', 'Tp Part List') ?>
        <small>
                        <?= $model->tp_part_list_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'tp_part_list_id' => $model->tp_part_list_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>

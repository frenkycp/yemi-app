<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SernoOutput $model
*/

$this->title = Yii::t('app', 'Update Data ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Serno Output'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->pk, 'url' => ['view', 'pk' => $model->pk]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud serno-output-update">

    <h1 style="display: none;">
        <?= Yii::t('app', 'Serno Output') ?>
        <small>
                        <?= $model->pk ?>
        </small>
    </h1>

    <div class="crud-navigation" style="display: none;">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'pk' => $model->pk], ['class' => 'btn btn-default']) ?>
    </div>


    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>

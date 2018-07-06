<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\VisualPickingList $model
*/

$this->title = Yii::t('models', 'Visual Picking List');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Visual Picking List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->seq_no, 'url' => ['view', 'seq_no' => $model->seq_no]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud visual-picking-list-update">

    <h1>
        <?= Yii::t('models', 'Visual Picking List') ?>
        <small>
                        <?= $model->seq_no ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'seq_no' => $model->seq_no], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>

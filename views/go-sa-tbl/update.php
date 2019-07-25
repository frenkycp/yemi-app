<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\GoSaTbl $model
*/

$this->title = Yii::t('models', 'Go Sa Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Go Sa Tbl'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud go-sa-tbl-update">

    <h1>
        <?= Yii::t('models', 'Go Sa Tbl') ?>
        <small>
                        <?= Html::encode($model->ID) ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'ID' => $model->ID], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>

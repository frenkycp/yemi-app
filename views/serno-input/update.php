<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\SernoInput $model
*/

$this->title = Yii::t('models', 'Serno Input');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Serno Input'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->pk, 'url' => ['view', 'pk' => $model->pk]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud serno-input-update">

    <h1>
        <?= Yii::t('models', 'Serno Input') ?>
        <small>
                        <?= $model->pk ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'pk' => $model->pk], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>

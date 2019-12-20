<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MitaUrl $model
*/

$this->title = Yii::t('models', 'Mita Url');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Mita Url'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud mita-url-update">

    <h1>
        <?= Yii::t('models', 'Mita Url') ?>
        <small>
                        <?= Html::encode($model->title) ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>

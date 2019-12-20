<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\MitaUrl $model
*/

$this->title = Yii::t('models', 'Mita Url');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Mita Urls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud mita-url-create">

    <h1>
        <?= Yii::t('models', 'Mita Url') ?>
        <small>
                        <?= Html::encode($model->title) ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            'Cancel',
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>

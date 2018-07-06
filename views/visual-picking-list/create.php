<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\VisualPickingList $model
*/

$this->title = Yii::t('models', 'Visual Picking List');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Visual Picking Lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud visual-picking-list-create">

    <h1>
        <?= Yii::t('models', 'Visual Picking List') ?>
        <small>
                        <?= $model->seq_no ?>
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

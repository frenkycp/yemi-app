<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\TpPartList $model
*/

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tp Part Lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud tp-part-list-create">

    <h1>
        <?= Yii::t('app', 'Tp Part List') ?>
        <small>
                        <?= $model->tp_part_list_id ?>
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

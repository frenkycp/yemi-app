<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var app\models\InjMachineTbl $model
*/

$this->title = Yii::t('models', 'Inj Machine Tbl');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Inj Machine Tbls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud inj-machine-tbl-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>

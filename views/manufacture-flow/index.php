<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$this->title = [
    'page_title' => 'Manufacturing Flow <span class="japanesse text-green"></span>',
    'tab_title' => 'Manufacturing Flow',
    'breadcrumbs_title' => 'Manufacturing Flow'
];

$this->registerCss(".japanesse { font-family: 'MS PGothic', Osaka, Arial, sans-serif; }");

date_default_timezone_set('Asia/Jakarta');

?>
<div>
    <?= Html::a(Html::img('@web/uploads/mita-flow.png', [
        'class' => 'media-object',
        'width' => '100%',
    ]), ['uploads/mita-flow.pdf'], ['target' => '_blank']);
    ?>
</div>